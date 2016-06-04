<?php

namespace Garble\Http\Controllers;

use Illuminate\Http\Request;

use Garble\Http\Requests;

class WelcomeController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }
}
