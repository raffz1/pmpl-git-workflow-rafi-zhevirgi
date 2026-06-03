<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $dbPaths = \App\Models\Path::with('modules')->get();
        $progresses = [];
        $pathDetails = [];
        $completedPathsCount = 0;

        foreach ($dbPaths as $path) {
            $slug = $path->slug;
            $step = 0;
            switch ($slug) {
                case 'frontend':
                    $step = $user->frontend_current_step;
                    break;
                case 'backend':
                    $step = $user->backend_current_step;
                    break;
                case 'uiux':
                    $step = $user->uiux_current_step;
                    break;
                case 'fullstack':
                    $step = $user->fullstack_current_step;
                    break;
                case 'project-manager':
                    $step = $user->pm_current_step;
                    break;
                default:
                    $customProgress = $user->custom_paths_progress ?? [];
                    $step = isset($customProgress[$slug]) ? (int)$customProgress[$slug] : 0;
                    break;
            }

            $total = $path->modules->count();
            if ($total == 0) {
                $total = 7;
            }

            $progress = round(($step / $total) * 100);
            if ($progress > 100) {
                $progress = 100;
            }
            $completed = $step >= $total;
            if ($completed) {
                $completedPathsCount++;
            }

            $color = 'from-blue-500 to-indigo-600';
            switch ($path->theme) {
                case 'cyan':
                    $color = 'from-cyan-500 to-blue-600';
                    break;
                case 'green':
                    $color = 'from-emerald-500 to-teal-600';
                    break;
                case 'pink':
                    $color = 'from-pink-500 to-rose-600';
                    break;
                case 'orange':
                    $color = 'from-orange-500 to-amber-600';
                    break;
                case 'yellow':
                    $color = 'from-yellow-500 to-orange-600';
                    break;
            }

            $progresses[$path->title] = $progress;
            $pathDetails[] = [
                'name' => $path->title,
                'progress' => $progress,
                'completed' => $completed,
                'step' => $step,
                'total' => $total,
                'color' => $color,
            ];
        }

        // Determine title based on completed paths
        if ($dbPaths->count() > 0 && $completedPathsCount == $dbPaths->count()) {
            $dominantTitle = 'Expert';
        } elseif ($completedPathsCount >= 3) {
            $dominantTitle = 'Pro';
        } else {
            $dominantTitle = 'Beginner';
        }

        return view('profile', compact('user', 'dominantTitle', 'pathDetails', 'progresses'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ], [
            'profile_photo.uploaded' => 'Foto profil gagal diunggah. Pastikan ukuran file tidak melebihi 10MB.',
            'cover_photo.uploaded' => 'Foto cover gagal diunggah. Pastikan ukuran file tidak melebihi 10MB.',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_avatar_' . $user->id . '.' . $file->getClientOriginalExtension();
            $dir = public_path('uploads/profile');
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file->move($dir, $filename);
            $user->profile_photo = '/uploads/profile/' . $filename;
        }

        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $filename = time() . '_cover_' . $user->id . '.' . $file->getClientOriginalExtension();
            $dir = public_path('uploads/cover');
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file->move($dir, $filename);
            $user->cover_photo = '/uploads/cover/' . $filename;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
