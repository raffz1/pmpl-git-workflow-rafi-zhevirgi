<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Path;

class DashboardController extends Controller
{
    /*
     * DASHBOARD UTAMA
     * memuat seluruh data statistik untuk pengguna (Guest maupun Terautentikasi):
     * 1. mengambil progres pengerjaan (step) untuk setiap Learning Path
     * 2. menghitung persentase penyelesaian modul (Your Progress & Completed Lessons)
     * 3. menyimpan/mengatur path yang sedang aktif dipelajari ke dalam session/database (Continue Learning)
     * 4. memuat daftar modul yang diberi tanda bookmark (Marked Modules)
     */
    public function index()
    {
        // CONTINUE LEARNING
        $activePathId = session('active_path_id');
        if (auth()->check()) {
            $user = auth()->user();
            $activePathId = $user->active_path_id ?? $activePathId;
            $frontendStep = $user->frontend_current_step;
            $backendStep = $user->backend_current_step;
            $fullstackStep = $user->fullstack_current_step;
            $pmStep = $user->pm_current_step;
            $uiuxStep = $user->uiux_current_step;
            
            // sinkronisasi data progres user ke dalam session
            session(['active_path_id' => $activePathId]);
            session(['frontend_current_step' => $frontendStep]);
            session(['backend_current_step' => $backendStep]);
            session(['fullstack_current_step' => $fullstackStep]);
            session(['pm_current_step' => $pmStep]);
            session(['uiux_current_step' => $uiuxStep]);
        } else {
            // untuk guest, ambil progres dari session saja
            $frontendStep = session('frontend_current_step', 0);
            $backendStep = session('backend_current_step', 0);
            $fullstackStep = session('fullstack_current_step', 0);
            $pmStep = session('pm_current_step', 0);
            $uiuxStep = session('uiux_current_step', 0);
        }
        
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        $isAdmin = auth()->check() && auth()->user()->isAdmin();

        // mengambil semua data Learning Path beserta relasi modulnya dari database
        $dbPaths = Path::with('modules')->get();
        
        $paths = [];
        foreach ($dbPaths as $path) {
            $step = 0;
            // menentukan step saat ini berdasarkan slug path masing-masing
            switch ($path->slug) {
                case 'frontend':
                    $step = $frontendStep;
                    $url = route('path.detail.frontend');
                    break;
                case 'backend':
                    $step = $backendStep;
                    $url = route('path.detail.backend');
                    break;
                case 'uiux':
                    $step = $uiuxStep;
                    $url = route('path.detail.uiux');
                    break;
                case 'fullstack':
                    $step = $fullstackStep;
                    $url = route('path.detail.fullstack');
                    break;
                case 'project-manager':
                    $step = $pmStep;
                    $url = route('path.detail.pm');
                    break;
                default:
                    if (auth()->check()) {
                        // untuk custom path dinamis, ambil dari JSON custom_paths_progress
                        $customProgress = auth()->user()->custom_paths_progress ?? [];
                        $step = isset($customProgress[$path->slug]) ? (int)$customProgress[$path->slug] : 0;
                    } else {
                        $step = session($path->slug . '_current_step', 0);
                    }
                    $url = route('path.detail.dynamic', $path->slug);
                    break;
            }

            $totalModules = $path->modules->count();
            if ($totalModules == 0) {
                $totalModules = 7; // fallback jika belum ada modul yang terisi
            }

            // YOUR PROGRESS DAN COMPLETED LESSONS
            // progres dihitung berdasarkan rasio (step aktif / total modul) * 100%.
            $currentModuleModel = $path->modules->where('step_number', $step)->first();
            if ($step >= $totalModules) {
                $moduleTitle = 'Kurikulum Selesai! 🎉';
                $progress = 100;
            } else {
                $moduleTitle = $currentModuleModel ? ('Modul ' . ($step + 1) . ' : ' . $currentModuleModel->title) : 'Belum Memulai';
                $progress = min(100, round(($step / $totalModules) * 100));
            }

            $paths[$path->id] = [
                'id' => $path->id,
                'title' => $path->title,
                'module' => $moduleTitle,
                'progress' => $progress, // persentase progres (your progress)
                'lessons' => $step . '/' . $totalModules, // completed lessons (modul terselesaikan)
                'quiz' => '90%', // rata-rata nilai quiz (data placeholder/static)
                'image' => $path->image,
                'url' => $url,
                'slug' => $path->slug,
            ];
        }
        
        // LANJUTKAN BELAJAR (mencari path dengan progres aktif)
        $activePath = null;
        if ($activePathId && isset($paths[$activePathId])) {
            $activePath = $paths[$activePathId];
        } else {
            // jika tidak ada active_path_id, cari path pertama yang progresnya sudah berjalan (> 0)
            foreach ($paths as $p) {
                if ($p['progress'] > 0) {
                    $activePath = $p;
                    if (auth()->check()) {
                        $user = auth()->user();
                        $user->active_path_id = $p['id'];
                        $user->save();
                    }
                    session(['active_path_id' => $p['id']]);
                    break;
                }
            }
        }
        
        $progressCount = $activePath ? 1 : 0;

        // BOOKMARKS / MARKED MODULES (mengambil modul yang ditandai/marks)
        // mengambil daftar ID modul yang ditandai dari kolom JSON marked_modules milik user di database, lalu memuat objek model modul beserta path-nya.
        $markedModules = [];
        if (auth()->check()) {
            $user = auth()->user();
            $markedIds = $user->marked_modules ?? [];
            if (!empty($markedIds)) {
                $markedModules = \App\Models\Module::whereIn('id', $markedIds)
                    ->with('path')
                    ->get();
            }
        }
  
        return view('dashboard', compact('progressCount', 'activePath', 'userName', 'isAdmin', 'markedModules'));
    }
  
    //reset progress
    // menghapus semua riwayat belajar, baik yang ada di session maupun yang tersimpan di profil database pengguna.
    public function resetProgress()
    {
        session()->forget('active_path_id');
        session()->forget('frontend_current_step');
        session()->forget('backend_current_step');
        session()->forget('fullstack_current_step');
        session()->forget('pm_current_step');
        session()->forget('uiux_current_step');
        
        if (auth()->check()) {
            $user = auth()->user();
            $user->active_path_id = null;
            $user->frontend_current_step = 0;
            $user->backend_current_step = 0;
            $user->fullstack_current_step = 0;
            $user->pm_current_step = 0;
            $user->uiux_current_step = 0;
            $user->custom_paths_progress = [];
            $user->save();
        }
        return redirect()->route('dashboard')->with('success', 'Progress berhasil di-reset.');
    }
}
