<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class BstudentController extends Controller
{
    public function student_index(Request $request,Tools $tools)
    {

        echo $tools->index();die;
    }

    public function student_list()
    {

        return view('bstudent.create');
    }
}
