<?php

namespace App\Http\Controllers;

use App\Models\Selections;
use App\Models\SelectionType;
use Illuminate\Http\Request;

class SelectionsController extends Controller
{
    public function index($type)
    {
        $validTypes = [1,2,3,4,5,6,7];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        $title = SelectionType::where('id', $type)->value('name');

        $datas = Selections::where('type_test_id', $type)->get();
        return view("selections", compact('datas', 'title'));
    }

}
