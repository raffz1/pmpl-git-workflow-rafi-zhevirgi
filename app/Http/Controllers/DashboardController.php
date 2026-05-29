<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $activePathId = session('active_path_id');
        if (auth()->check()) {
            $user = auth()->user();
            $activePathId = $user->active_path_id ?? $activePathId;
            $frontendStep = $user->frontend_current_step;
            $backendStep = $user->backend_current_step;
            $fullstackStep = $user->fullstack_current_step;
            // Sync to session
            session(['active_path_id' => $activePathId]);
            session(['frontend_current_step' => $frontendStep]);
            session(['backend_current_step' => $backendStep]);
            session(['fullstack_current_step' => $fullstackStep]);
        } else {
            $frontendStep = session('frontend_current_step', 0);
            $backendStep = session('backend_current_step', 0);
            $fullstackStep = session('fullstack_current_step', 0);
        }
        
        $userName = auth()->user()->name ?? 'Student';
        
        $frontendModulesList = [
            0 => 'Modul 1 : Pendahuluan',
            1 => 'Modul 2 : Pengenalan HTML',
            2 => 'Modul 3 : Pendalaman HTML',
            3 => 'Modul 4 : Pengenalan CSS',
            4 => 'Modul 5 : Pendalaman CSS',
            5 => 'Modul 6 : Layout Responsive',
            6 => 'Modul 7 : Quiz',
            7 => 'Kurikulum Selesai! 🎉'
        ];
        $frontendModule = $frontendModulesList[$frontendStep] ?? 'Kurikulum Selesai! 🎉';
        $frontendProgress = min(100, round(($frontendStep / 7) * 100));
        $frontendLessons = $frontendStep . '/7';

        $backendModulesList = [
            0 => 'Modul 1 : Dasar-dasar Pemrograman',
            1 => 'Modul 2 : Konsep Dasar Web Development',
            2 => 'Modul 3 : Dasar-dasar Database',
            3 => 'Modul 4 : Framework Backend',
            4 => 'Modul 5 : Keamanan Dasar',
            5 => 'Modul 6 : Menguasai Version Control System (Git)',
            6 => 'Modul 7 : Deploy dan Cloud Computing',
            7 => 'Modul 8 : Quiz',
            8 => 'Kurikulum Selesai! 🎉'
        ];
        $backendModule = $backendModulesList[$backendStep] ?? 'Kurikulum Selesai! 🎉';
        $backendProgress = min(100, round(($backendStep / 8) * 100));
        $backendLessons = $backendStep . '/8';

        $fullstackModulesList = [
            0 => 'Modul 1 : HTML, CSS, JavaScript',
            1 => 'Modul 2 : Responsive Web Design',
            2 => 'Modul 3 : Git & GitHub',
            3 => 'Modul 4 : Frontend Framework',
            4 => 'Modul 5 : Backend Development',
            5 => 'Modul 6 : Database',
            6 => 'Modul 7 : API & Authentication',
            7 => 'Modul 8 : Deployment & Hosting',
            8 => 'Modul 9 : Testing dan optimization',
            9 => 'Modul 10 : QUIZ',
            10 => 'Kurikulum Selesai! 🎉'
        ];
        $fullstackModule = $fullstackModulesList[$fullstackStep] ?? 'Kurikulum Selesai! 🎉';
        $fullstackProgress = min(100, round(($fullstackStep / 10) * 100));
        $fullstackLessons = $fullstackStep . '/10';
 
        $paths = [
            1 => [
                'title' => 'Front End Developer',
                'module' => $frontendModule,
                'progress' => $frontendProgress,
                'lessons' => $frontendLessons,
                'quiz' => '92%',
                'image' => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?w=600&auto=format&fit=crop&q=80',
                'url' => route('path.detail.frontend'),
            ],
            2 => [
                'title' => 'Back End Developer',
                'module' => $backendModule,
                'progress' => $backendProgress,
                'lessons' => $backendLessons,
                'quiz' => '88%',
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&auto=format&fit=crop&q=80',
                'url' => route('path.detail.backend'),
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
                'module' => $fullstackModule,
                'progress' => $fullstackProgress,
                'lessons' => $fullstackLessons,
                'quiz' => '90%',
                'image' => 'https://images.unsplash.com/photo-1605379399642-870262d3d051?w=600&auto=format&fit=crop&q=80',
                'url' => route('path.detail.fullstack'),
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
        session()->forget('frontend_current_step');
        session()->forget('backend_current_step');
        session()->forget('fullstack_current_step');
        
        if (auth()->check()) {
            $user = auth()->user();
            $user->active_path_id = null;
            $user->frontend_current_step = 0;
            $user->backend_current_step = 0;
            $user->fullstack_current_step = 0;
            $user->save();
        }
        return redirect()->route('dashboard')->with('success', 'Progress berhasil di-reset.');
    }
}
