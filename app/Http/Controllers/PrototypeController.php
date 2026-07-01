<?php

namespace App\Http\Controllers;

use App\Support\DemoData;

/**
 * Dashboard masih memakai data contoh (DemoData) untuk KPI & grafik
 * sampai modul ringkasan dibuat dari data nyata.
 */
class PrototypeController extends Controller
{
    public function dashboard()
    {
        return view('dashboard', ['chart' => DemoData::chart()]);
    }
}
