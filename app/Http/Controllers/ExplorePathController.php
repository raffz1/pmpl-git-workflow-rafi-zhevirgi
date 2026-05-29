<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExplorePathController extends Controller
{
    public function index()
    {
        $paths = [
            [
                'id'          => 1,
                'title'       => 'Front End',
                'slug'        => 'frontend',
                'icon'        => 'frontend',
                'image'       => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?w=600&auto=format&fit=crop&q=80',
                'description' => 'Kuasai seni merancang antarmuka pengguna yang indah dan responsif dengan kerangka kerja modern dan praktik aksesibilitas.',
                'theme'       => 'cyan',
            ],
            [
                'id'          => 2,
                'title'       => 'Back End',
                'slug'        => 'backend',
                'icon'        => 'backend',
                'image'       => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&auto=format&fit=crop&q=80',
                'description' => 'Rancang server yang dapat diskalakan, buat API yang andal, dan kelola basis data yang kompleks untuk aplikasi berkinerja tinggi.',
                'theme'       => 'green',
            ],
            [
                'id'          => 5,
                'title'       => 'Product Manager',
                'slug'        => 'product-manager',
                'icon'        => 'pm',
                'image'       => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=600&auto=format&fit=crop&q=80',
                'description' => 'Learn to define vision, prioritize roadmaps, and lead cross-functional teams to deliver impactful products.',
                'theme'       => 'yellow',
            ],
            [
                'id'          => 4,
                'title'       => 'Full Stack',
                'slug'        => 'fullstack',
                'icon'        => 'fullstack',
                'image'       => 'https://images.unsplash.com/photo-1605379399642-870262d3d051?w=600&auto=format&fit=crop&q=80',
                'description' => 'Jembatani kesenjangan antara klien dan server. Jadilah pengembang serba bisa yang mampu membangun solusi end-to-end.',
                'theme'       => 'orange',
            ],
            [
                'id'          => 3,
                'title'       => 'UI/UX Designer',
                'slug'        => 'uiux',
                'icon'        => 'uiux',
                'image'       => 'https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=600&auto=format&fit=crop&q=80',
                'description' => 'Selesaikan masalah pengguna melalui pendekatan desain thinking. Ciptakan pengalaman yang intuitif dan komponen visual yang apik.',
                'theme'       => 'pink',
            ],
        ];

        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';

        return view('explore-path', compact('paths', 'userName'));
    }

    public function enroll($id)
    {
        session(['active_path_id' => $id]);
        if (auth()->check()) {
            $user = auth()->user();
            $user->active_path_id = $id;
            $user->save();
        }
        return redirect()->route('dashboard')->with('success', 'Berhasil memilih jalur pembelajaran!');
    }

    public function frontendDetail()
    {
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        if (auth()->check()) {
            $user = auth()->user();
            $currentStep = $user->frontend_current_step;
            session(['frontend_current_step' => $currentStep]);
        } else {
            if (!session()->has('frontend_current_step')) {
                session(['frontend_current_step' => 0]);
            }
            $currentStep = session('frontend_current_step', 0);
        }
        return view('detail-frontend', compact('userName', 'currentStep'));
    }

    public function completeStep(\Illuminate\Http\Request $request)
    {
        session(['active_path_id' => 1]); // Auto enroll in Front End path
        if (auth()->check()) {
            $user = auth()->user();
            $user->active_path_id = 1;
            if ($user->frontend_current_step < 7) {
                $user->frontend_current_step++;
                $user->save();
            }
            $currentStep = $user->frontend_current_step;
            session(['frontend_current_step' => $currentStep]);
        } else {
            $currentStep = session('frontend_current_step', 0);
            if ($currentStep < 7) {
                $currentStep++;
                session(['frontend_current_step' => $currentStep]);
            }
        }
        return redirect()->route('path.detail.frontend')->with('success', 'Selamat! Modul berhasil diselesaikan.');
    }

    public function resetDetailProgress()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->frontend_current_step = 0;
            $user->save();
            session(['frontend_current_step' => 0]);
        } else {
            session(['frontend_current_step' => 0]);
        }
        return redirect()->route('path.detail.frontend')->with('success', 'Progres belajar berhasil direset dari awal.');
    }

    public function backendDetail()
    {
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        if (auth()->check()) {
            $user = auth()->user();
            $currentStep = $user->backend_current_step;
            session(['backend_current_step' => $currentStep]);
        } else {
            if (!session()->has('backend_current_step')) {
                session(['backend_current_step' => 0]);
            }
            $currentStep = session('backend_current_step', 0);
        }
        return view('detail-backend', compact('userName', 'currentStep'));
    }

    public function completeBackendStep(\Illuminate\Http\Request $request)
    {
        session(['active_path_id' => 2]); // Auto enroll in Back End path
        if (auth()->check()) {
            $user = auth()->user();
            $user->active_path_id = 2;
            if ($user->backend_current_step < 8) {
                $user->backend_current_step++;
                $user->save();
            }
            $currentStep = $user->backend_current_step;
            session(['backend_current_step' => $currentStep]);
        } else {
            $currentStep = session('backend_current_step', 0);
            if ($currentStep < 8) {
                $currentStep++;
                session(['backend_current_step' => $currentStep]);
            }
        }
        return redirect()->route('path.detail.backend')->with('success', 'Selamat! Modul berhasil diselesaikan.');
    }

    public function resetBackendDetailProgress()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $user->backend_current_step = 0;
            $user->save();
            session(['backend_current_step' => 0]);
        } else {
            session(['backend_current_step' => 0]);
        }
        return redirect()->route('path.detail.backend')->with('success', 'Progres belajar berhasil direset dari awal.');
    }
}
