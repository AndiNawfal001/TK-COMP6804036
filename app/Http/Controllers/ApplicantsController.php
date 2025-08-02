<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Education;
use App\Models\Religions;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicantsController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Applicants';
        $educations = Education::all();
        $religions = Religions::all();
        $datas = User::query()
            ->with('applicants')
            ->where('group_id', 4)
            ->latest()
            ->paginate(10)
            ->withQueryString();
        $data = null;

        return view('applicant', compact('title', 'datas', 'educations', 'religions', 'data'));
    }

    public function detail($id)
    {
        $applicant = Applicant::where('user_id', $id)->first();
        $user = User::find($id);

        return response()->json([
            'data' => $applicant,
            'user' => $user,
        ]);
    }
}
