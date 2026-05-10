<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Simulasi hitung progres (nanti ini ambil dari database)
        $progressCount = 0; 
        $userName = auth()->user()->nama ?? 'Siswa';

        return view('dashboard', compact('progressCount', 'userName'));
    }
}
