<?php

namespace App\Http\Controllers;

use App\Models\StaffRequest;
use App\Models\Position;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StaffRequestController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Staff Request';

        $positions = Position::all();

        $datas = StaffRequest::query()
            ->filter($request->all())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff_request', compact('title', 'datas', 'positions'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'date' => 'required',
            'position_id' => 'required',
            'qty' => 'required',
        ],[
            'title.required' => 'Title cannot be empty!',
            'date.required' => 'Date cannot be empty!',
            'position_id.required' => 'Position cannot be empty!',
            'qty.required' => 'Qty cannot be empty!',
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff_request.index')
                ->withErrors($validator, 'insert')
                ->withInput();
        }

        $data = $request->all();
        $data['number'] = StaffRequest::generateNumber();
        $data['user_id'] = auth()->user()->id;

        StaffRequest::create($data);

        return redirect()->route('staff_request.index')->with('success', 'Request created.');
    }


    public function edit($id)
    {
        $data = StaffRequest::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('staff_request.index')
                ->withErrors($validator, 'edit')
                ->withInput()
                ->with('edit_id', $id);
        }

        $staff_request = StaffRequest::findOrFail($id);
        $staff_request->update($request->all());

        if($staff_request){
            return redirect()->route('staff_request.index')->with('success', 'Request updated.');
        }
    }

    public function approve($id)
    {
        $data = StaffRequest::findOrFail($id);

        return response()->json($data);
    }

    public function updateAppr(Request $request, $id)
    {

        $staff_request = StaffRequest::findOrFail($id);

        $data = $request->all();
        $data['app_by'] = $staff_request->app_by ?? auth()->user()->id;

        $staff_request->update($data);

        if($request->app_status == 't'){
            $data_vac['request_id'] = $id;
            $data_vac['title'] = $staff_request->title;
            $data_vac['note'] = $staff_request->note;

            Vacancy::create($data_vac);
        }

        if($staff_request){
            return redirect()->route('staff_request.index')->with('success', 'Request Approve updated.');
        }
    }

    public function destroy($id)
    {
        $staffRequest = StaffRequest::findOrFail($id);
        $staffRequest->delete();

        return redirect()->route('staff_request.index')->with('success', 'Request deleted.');
    }
}
