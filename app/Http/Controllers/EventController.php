<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class EventController extends Controller
{
    public function event(Tools $tools)
    {
        echo storage_path();
        $info= file_get_contents("php://input");
         file_put_contents(storage_path('logs/wecahr'.date('Y-m-d').'.log'),$info,FILE_APPEND);

    }                                                                                                                                    
}
