<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Menu;
class MenuController extends Controller
{
    //菜单列表页面;
    public function menu_create()
    {
        $model=new Menu; 
        return view('menu.menu_create');
    }
}
