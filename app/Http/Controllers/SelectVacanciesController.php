<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Position;
use App\Models\SallaryType;
use App\Models\Selections;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class SelectVacanciesController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Select Vacancies';

        $positions = Position::all();
        $educations = Education::all();
        $sallary_types = SallaryType::all();

        $activeSelections = Selections::where('applicant_id', auth()->id())
            ->where('app_status', '!=', 'f')
            ->exists();

        if($activeSelections){
            $status_check = 'active';
        }else{
            $status_check = 'ready';
        }


        $datas = Vacancy::query()
            ->where('status', 't')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('select_vacancies', compact('title', 'datas', 'positions', 'educations', 'sallary_types', 'status_check'));
    }

    public function detail($id)
    {

        $data = Vacancy::findOrFail($id);
        $data['position'] = $data->staff_request->position->name;
        $data['sallary'] = number_format($data->sallary, 0, '.', ',');

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $data = [];
        $data['vac_id'] = $request->vacancy_id;
        $data['applicant_id'] = auth()->user()->id;
        $data['type_test_id'] = 1;

        Selections::create($data);

        return redirect()->route('select_vacancies.index')->with('success', 'Request created.');

    }

}
