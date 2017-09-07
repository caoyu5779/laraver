<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class AddArticleController extends Controller
{
    //
   public function index()
   {
        return view('admin/article/create');
   }
}
