<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activePathId = session('active_path_id');
        $userName = auth()->user()->name ?? 'Student';
        
        $paths = [
            1 => [
                'title' => 'Front End Developer',
                'module' => 'Modul 1 : Dasar-dasar HTML',
                'progress' => 30,
                'lessons' => '12/45',
                'quiz' => '92%',
                'image' => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?w=600&auto=format&fit=crop&q=80',
            ],
            2 => [
                'title' => 'Back End Developer',
                'module' => 'Modul 1 : Dasar-dasar PHP',
                'progress' => 45,
                'lessons' => '18/40',
                'quiz' => '88%',
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&auto=format&fit=crop&q=80',
            ],
            3 => [
                'title' => 'UI/UX Designer',
                'module' => 'Modul 1 : Pengantar Figma & Wireframe',
                'progress' => 20,
                'lessons' => '8/35',
                'quiz' => '95%',
                'image' => 'https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=600&auto=format&fit=crop&q=80',
            ],
            4 => [
                'title' => 'Full Stack Developer',
                'module' => 'Modul 1 : Git & Alur Kerja Tim',
                'progress' => 15,
                'lessons' => '6/50',
                'quiz' => '90%',
                'image' => 'https://images.unsplash.com/photo-1605379399642-870262d3d051?w=600&auto=format&fit=crop&q=80',
            ],
            5 => [
                'title' => 'Product Manager',
                'module' => 'Modul 1 : Product Lifecycle & Roadmap',
                'progress' => 50,
                'lessons' => '25/50',
                'quiz' => '94%',
                'image' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=600&auto=format&fit=crop&q=80',
            ]
        ];
        
        $activePath = isset($paths[$activePathId]) ? $paths[$activePathId] : null;
        $progressCount = $activePath ? 1 : 0;

        return view('dashboard', compact('progressCount', 'activePath', 'userName'));
    }

    public function resetProgress()
    {
        session()->forget('active_path_id');
        return redirect()->route('dashboard')->with('success', 'Progress berhasil di-reset.');
    }
}
