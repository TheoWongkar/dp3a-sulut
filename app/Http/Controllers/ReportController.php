<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $title = "Laporkan";

        return view('reports', compact('title'));
    }
}
