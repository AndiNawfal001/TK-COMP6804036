<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Education;
use App\Models\Religions;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Profile';
        $educations = Education::all();
        $religions = Religions::all();

        $data = Applicant::where('user_id', auth()->id())->first();
//        dd($data->photo);
        return view('profile', compact('data', 'title', 'educations', 'religions'));
    }
    public function store(Request $request)
    {

        $path_photo = $request->file('photo') ? $request->file('photo')->store('documents', 'public') : "";

        Applicant::create([
            'user_id' => auth()->id(),
            'gender' => $request->gender,
            'religion' => $request->religion,
            'last_edu' => $request->last_edu,
            'height' => $request->height,
            'weight' => $request->weight,
            'address' => $request->address,
            'birth_place' => $request->birth_place,
            'birth_date' => $request->birth_date,
            'photo' => $path_photo,
//            'cv' => $path_cv,
//            'ktp' => $path_ktp,
        ]);

    }
}
