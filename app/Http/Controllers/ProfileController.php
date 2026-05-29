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

        // Calculate progress percentages
        $frontendProgress = round(($user->frontend_current_step / 7) * 100);
        $backendProgress = round(($user->backend_current_step / 8) * 100);
        $uiuxProgress = round(($user->uiux_current_step / 10) * 100);
        $fullstackProgress = round(($user->fullstack_current_step / 10) * 100);
        $pmProgress = round(($user->pm_current_step / 10) * 100);

        $progresses = [
            'Front End Developer' => $frontendProgress,
            'Back End Developer' => $backendProgress,
            'UI/UX Designer' => $uiuxProgress,
            'Full Stack Developer' => $fullstackProgress,
            'Project Manager' => $pmProgress,
        ];

        // Determine dominant title
        $dominantTitle = '';
        $maxProgress = 0;
        
        // Find highest progress path
        foreach ($progresses as $title => $progress) {
            if ($progress > $maxProgress) {
                $maxProgress = $progress;
                $dominantTitle = $title;
            }
        }

        // Paths detailed structure for view
        $pathDetails = [
            [
                'name' => 'Front End Developer',
                'progress' => $frontendProgress,
                'completed' => $user->frontend_current_step >= 7,
                'step' => $user->frontend_current_step,
                'total' => 7,
                'color' => 'from-cyan-500 to-blue-600',
            ],
            [
                'name' => 'Back End Developer',
                'progress' => $backendProgress,
                'completed' => $user->backend_current_step >= 8,
                'step' => $user->backend_current_step,
                'total' => 8,
                'color' => 'from-emerald-500 to-teal-600',
            ],
            [
                'name' => 'UI/UX Designer',
                'progress' => $uiuxProgress,
                'completed' => $user->uiux_current_step >= 10,
                'step' => $user->uiux_current_step,
                'total' => 10,
                'color' => 'from-pink-500 to-rose-600',
            ],
            [
                'name' => 'Full Stack Developer',
                'progress' => $fullstackProgress,
                'completed' => $user->fullstack_current_step >= 10,
                'step' => $user->fullstack_current_step,
                'total' => 10,
                'color' => 'from-orange-500 to-amber-600',
            ],
            [
                'name' => 'Project Manager',
                'progress' => $pmProgress,
                'completed' => $user->pm_current_step >= 10,
                'step' => $user->pm_current_step,
                'total' => 10,
                'color' => 'from-yellow-500 to-orange-600',
            ],
        ];

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
