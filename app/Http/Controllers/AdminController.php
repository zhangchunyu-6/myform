<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tools\Tools;
class AdminController extends Controller
{
    public function create(Tools $tools)
    {
        return $tools->index();
    }
}
