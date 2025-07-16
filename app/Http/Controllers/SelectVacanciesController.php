<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Position;
use App\Models\SallaryType;
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

        $datas = Vacancy::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('select_vacancies', compact('title', 'datas', 'positions', 'educations', 'sallary_types'));
    }

    public function detail($id)
    {

        $data = Vacancy::findOrFail($id);
        $data['position'] = $data->staff_request->position->name;
        $data['sallary'] = number_format($data->sallary, 0, '.', ',');

        return response()->json($data);
    }

}
