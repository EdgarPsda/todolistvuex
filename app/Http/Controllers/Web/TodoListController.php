<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoListController extends Controller
{
    public function index(){
        return view('todolist.index');
    }
}
