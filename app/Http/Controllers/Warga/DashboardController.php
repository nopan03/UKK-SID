<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Kita tidak perlu mengambil data apa pun di sini
        // karena kita bisa memanggilnya langsung di view menggunakan Auth::user()
        // Ini membuat controller tetap bersih.

        return view('warga.dashboard');
    }
}