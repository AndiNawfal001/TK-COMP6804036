<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Education;
use App\Models\Religions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index(Request $request)
    {

        if (auth()->user()->group_id != 4) {
            abort(403);
        }

        $title = 'Profile';
        $educations = Education::all();
        $religions = Religions::all();

        $data = Applicant::where('user_id', auth()->id())->first();
//        dd($data->photo);
        return view('profile', compact('data', 'title', 'educations', 'religions'));
    }
    public function store(Request $request)
    {

        if (isset($request->old_photo) && empty($request->file('photo'))) {
            $path_photo = $request->old_photo;
        } elseif ($request->file('photo') !== null) {
            if(isset($request->old_photo)){
                Storage::disk('public')->delete($request->old_photo);
            }
            $path_photo = $request->file('photo')->store('documents', 'public');
        }else{
            $path_photo ="";
        }

        if (isset($request->old_cv) && empty($request->file('cv'))) {
            $path_cv = $request->old_cv;
        } elseif ($request->file('cv') !== null) {
            if(isset($request->old_cv)){
                Storage::disk('public')->delete($request->old_cv);
            }
            $path_cv = $request->file('cv')->store('documents', 'public');
        }else{
            $path_cv ="";
        }

        if (isset($request->old_ktp) && empty($request->file('ktp'))) {
            $path_ktp = $request->old_ktp;
        } elseif ($request->file('ktp') !== null) {
            if(isset($request->old_ktp)){
                Storage::disk('public')->delete($request->old_ktp);
            }
            $path_ktp = $request->file('ktp')->store('documents', 'public');
        }else{
            $path_ktp ="";
        }



        Applicant::updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'applicant_number' => Applicant::whereNotNull('applicant_number')->exists()
                    ? fake()->unique()->regexify('[A-Z]{5}[0-4]{3}')
                    : fake()->regexify('[A-Z]{5}[0-4]{3}'),
                'gender' => $request->gender,
                'religion' => $request->religion,
                'last_edu' => $request->last_edu,
                'height' => $request->height,
                'weight' => $request->weight,
                'address' => $request->address,
                'birth_place' => $request->birth_place,
                'birth_date' => $request->birth_date,
                'photo' => $path_photo,
                 'cv' => $path_cv,
                 'ktp' => $path_ktp,
            ]
        );


        return redirect()->route('profile.index')->with('success', 'Request saved.');

    }
}
