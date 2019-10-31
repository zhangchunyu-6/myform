<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class BstudentController extends Controller
{
    public function student_index(Request $request,Tools $tools)
    {
        $openid=$request->all;

        echo $tools->index();die;
    }

    public function student_list(Tools $tools,Request $request)
    {
        $openlist=$tools->fans();
        //dd($openlist);
        return view('bstudent.create',['list'=>$openlist]);
    }
}
