<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\SallaryType;
use App\Models\Vacancy;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VacancyController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Vacancies';

        $positions = Position::all();
        $educations = Education::all();
        $sallary_types = SallaryType::all();
        $datas = Vacancy::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('vacancies', compact('title', 'datas', 'positions', 'educations', 'sallary_types'));
    }

    public function edit($id)
    {
        $data = Vacancy::findOrFail($id);
        $data['position'] = $data->staff_request->position->name;
        $data['sallary'] = number_format($data->sallary, 0, '.', ',');

        return response()->json($data);
    }

    public function update(Request $request, $id)
    {

        $request->sallary = str_replace(',', '', $request->sallary);

        $validator = Validator::make($request->all(), [
            'title'  => 'required',
            'note' => 'required',
            'min_edu' => 'required',
            'sallary_id' => 'required',
            'sallary'  => 'min:1'
        ], [
            'title.required' => 'Title cannot be empty!',
            'note.required' => 'Note cannot be empty!',
            'min_edu.required' => 'Minimum Education cannot be empty!',
            'sallary_id.required' => 'Salary Type cannot be empty!',
            'sallary.min' => 'Salary must be greater than zero!',
        ]);

        if ($validator->fails()) {
            return redirect()->route('vacancies.index')
                ->withErrors($validator, 'edit')
                ->withInput()
                ->with('edit_id', $id);
        }

        $vacancies = Vacancy::findOrFail($id);
        $data = $request->all();

        $data['sallary'] = str_replace(',', '', $request->sallary);

        $vacancies->update($data);
        if($vacancies){
            return redirect()->route('vacancies.index')->with('success', 'Request updated.');
        }
    }

    public function approve($id)
    {
        $data = Vacancy::findOrFail($id);

        return response()->json($data);
    }

    public function updateAppr(Request $request, $id)
    {

        $vacancies = Vacancy::findOrFail($id);

        $data = $request->all();
        $data['app_by'] = $vacancies->app_by ?? auth()->user()->id;

        $vacancies->update($data);

        if($vacancies){
            return redirect()->route('vacancies.index')->with('success', 'Request Approve updated.');
        }
    }

    public function destroy($id)
    {
        $staffRequest = Vacancy::findOrFail($id);
        $staffRequest->delete();

        return redirect()->route('vacancies.index')->with('success', 'Request deleted.');
    }
}
