<?php

namespace Garble\Http\Controllers;

use Illuminate\Http\Response;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(): Response
    {
        return response()->view('home');
    }

    /**
     * @return Response
     */
    public function welcome(): Response
    {
        return response()->view('welcome');
    }
}
