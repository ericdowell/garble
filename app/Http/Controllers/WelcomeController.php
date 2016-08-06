<?php

namespace Garble\Http\Controllers;

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
