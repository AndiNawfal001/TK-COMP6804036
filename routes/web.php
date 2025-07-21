<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SelectionsController;
use App\Http\Controllers\SelectVacanciesController;
use App\Http\Controllers\StaffRequestController;
use App\Http\Controllers\VacancyController;
use App\Models\Applicant;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);


    Route::get('/signup', [RegisterController::class, 'register'])->name('register');
    Route::post('/signup', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', function () {
        return view('dashboard');
    });

    Route::get('/applicant', function () {
        return view('applicant', ['title' => 'Applicants', 'datas' => Applicant::all()]);
    });

    Route::resource('staff_request', StaffRequestController::class);
    Route::get('staff_request_edit/{id}', [StaffRequestController::class, 'edit'])->name('staff_request_edit');
    Route::post('staff_request_update/{id}', [StaffRequestController::class, 'update'])->name('staff_request_update');
    Route::get('staff_request_approve/{id}', [StaffRequestController::class, 'approve'])->name('staff_request_approve');
    Route::post('staff_request_update_appr/{id}', [StaffRequestController::class, 'updateAppr'])->name('staff_request_update_appr');
    Route::delete('staff_request_destroy/{id}', [StaffRequestController::class, 'destroy'])->name('staff_request_destroy');

    Route::resource('vacancies', VacancyController::class);
    Route::get('vacancies_edit/{id}', [VacancyController::class, 'edit'])->name('vacancies_edit');
    Route::post('vacancies_update/{id}', [VacancyController::class, 'update'])->name('vacancies_update');
    Route::get('vacancies_approve/{id}', [VacancyController::class, 'approve'])->name('vacancies_approve');
    Route::post('vacancies_update_appr/{id}', [VacancyController::class, 'updateAppr'])->name('vacancies_update_appr');
    Route::delete('vacancies_destroy/{id}', [VacancyController::class, 'destroy'])->name('vacancies_destroy');

    Route::resource('select_vacancies', SelectVacanciesController::class);
    Route::get('select_vacancies_detail/{id}', [SelectVacanciesController::class, 'detail'])->name('select_vacancies_detail');

    Route::get('/selection/{type}', [SelectionsController::class, 'index'])->name('selection.index');
    Route::get('selection_approve/{type}/{id}', [SelectionsController::class, 'approve'])->name('selection_approve');
    Route::post('selection_update_appr/{type}/{id}', [SelectionsController::class, 'updateAppr'])->name('selection_update_appr');

    Route::resource('profile', ProfileController::class);

});
