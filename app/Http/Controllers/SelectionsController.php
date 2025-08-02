<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Position;
use App\Models\Selections;
use App\Models\SelectionType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SelectionsController extends Controller
{
    public function index($type)
    {
        $positions = Position::all();

        $validTypes = [1,2,3,4,5,6,7];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $title = SelectionType::where('id', $type)->value('name');

        $datas = Selections::where('type_test_id', $type)->paginate(10);

//        dd($datas);

        return view("selections", compact('datas', 'title', 'positions', 'type'));
    }

    public function approve($type, $id)
    {
        $data = Selections::where('id',$id)->where('type_test_id', $type)->first();

        return response()->json($data);
    }

    public function updateAppr(Request $request, $type, $id)
    {

        $selection = Selections::where('id',$id)->where('type_test_id', $type)->first();

        if (isset($request->old_file) && empty($request->file('file'))) {
            $path_file = $request->old_file;
//            dd(1);
        } elseif ($request->file('file') !== null) {
            if(isset($request->old_file)){
                Storage::disk('public')->delete($request->old_file);
            }
            $path_file = $request->file('file')->store('documents', 'public');
//            dd(2);
        }else{
            $path_file ="";
//            dd(3);
        }
//        dd($path_file);

        $data = $request->all();
        $data['app_by'] = $selection->app_by ?? auth()->user()->id;
        $data['file'] = $path_file;

        $selection->update($data);

        if($request->app_status == 't' && $type < 7){

            $data = [];
            $data['vac_id'] = $selection->vac_id;
            $data['applicant_id'] = $selection->applicant_id;
            $data['type_test_id'] = $type + 1 ;

            Selections::create($data);
        }elseif($request->app_status == 't' && $type == 7){
            Appointments::create([
                'applicant_id' => $selection->applicant_id,
                'vac_id' => $selection->vac_id,
                'appointment_date' => now()->addDays(3),
            ]);
        }

        if($selection){
            return redirect("selection/$type")->with('success', 'Request approval updated.');
        }
    }

}
