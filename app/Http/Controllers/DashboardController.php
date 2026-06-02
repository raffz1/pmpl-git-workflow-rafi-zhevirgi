<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Path;

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
            $pmStep = $user->pm_current_step;
            $uiuxStep = $user->uiux_current_step;
            // Sync to session
            session(['active_path_id' => $activePathId]);
            session(['frontend_current_step' => $frontendStep]);
            session(['backend_current_step' => $backendStep]);
            session(['fullstack_current_step' => $fullstackStep]);
            session(['pm_current_step' => $pmStep]);
            session(['uiux_current_step' => $uiuxStep]);
        } else {
            $frontendStep = session('frontend_current_step', 0);
            $backendStep = session('backend_current_step', 0);
            $fullstackStep = session('fullstack_current_step', 0);
            $pmStep = session('pm_current_step', 0);
            $uiuxStep = session('uiux_current_step', 0);
        }
        
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        $isAdmin = auth()->check() && auth()->user()->isAdmin();

        // Fetch paths from database
        $dbPaths = Path::with('modules')->get();
        
        $paths = [];
        foreach ($dbPaths as $path) {
            $step = 0;
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
                $totalModules = 7; // Fallback
            }

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
                'progress' => $progress,
                'lessons' => $step . '/' . $totalModules,
                'quiz' => '90%', // Static placeholder
                'image' => $path->image,
                'url' => $url,
                'slug' => $path->slug,
            ];
        }
        
        $activePath = null;
        if ($activePathId && isset($paths[$activePathId])) {
            $activePath = $paths[$activePathId];
        } else {
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
  
        return view('dashboard', compact('progressCount', 'activePath', 'userName', 'isAdmin'));
    }
  
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
