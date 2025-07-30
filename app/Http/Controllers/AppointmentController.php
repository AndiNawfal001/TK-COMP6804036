<?php

namespace App\Http\Controllers;

use App\Models\Appointments;
use App\Models\Position;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    protected array $placement_locations = [
        '1' => 'Head Office',
        '2' => 'IT Operations Office',
        '3' => 'Tech Hub'
    ];

    public function index(Request $request)
    {
        $title = 'Appointments';
        $placement_locations = $this->placement_locations;

        $positions = Position::all();
        $datas = Appointments::query()
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('appointments', compact('title', 'datas', 'positions', 'placement_locations'));
    }


    public function edit($id)
    {
        $data = Appointments::findOrFail($id);

        $data['appointment_date'] = date('Y-m-d', strtotime($data['appointment_date']));

        return response()->json([
            'data' => $data,
            'placement_locations' => $this->placement_locations,
        ]);
    }

    public function update(Request $request, $id)
    {

        $appointment = Appointments::findOrFail($id);
        $appointment->update($request->all());
        return redirect()->route('appointments.index')->with('success', 'Request updated.');

    }
}
