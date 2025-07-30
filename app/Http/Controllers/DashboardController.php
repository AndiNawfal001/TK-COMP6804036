<?php

namespace App\Http\Controllers;

use App\Models\Selections;
use App\Models\SelectionType;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalUsers' => User::count(),
            'totalVacancies' => Vacancy::count(),
            'applicationsThisMonth' => Selections::whereMonth('created_at', now()->month)->count(),

            'selectionTypes' => SelectionType::withCount(['selection'])->get()->map(function ($type) {
                return (object)[
                    'name' => $type->name,
                    'total' => $type->selections_count,
                ];
            }),

            'chartLabels' => SelectionType::pluck('name'),
            'chartData' => SelectionType::withCount('selection')->pluck('selection_count'),


            'recentApplications' => Selections::with(['applicant', 'vacancy.staff_request'])
                ->whereIn('id', function ($query) {
                    $query->select(DB::raw('MAX(id)'))
                        ->from('selections')
                        ->groupBy('applicant_id');
                })
                ->latest()
                ->get(),
        ]);
    }

}
