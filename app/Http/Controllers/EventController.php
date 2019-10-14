<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class EventController extends Controller
{
    public function event(Tools $tools)
    {
      
        $info= file_get_contents("php://input");
         file_put_contents(storage_path('logs/wechar'.date('Y-m-d').'.log'),$info,FILE_APPEND);

    }                                                                                                                                    
}
