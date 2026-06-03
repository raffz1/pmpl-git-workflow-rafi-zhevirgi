<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Path;
use App\Models\Module;
use App\Models\Quiz;

class CheckForUpdates
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->isAdmin()) {
            $user = Auth::user();

            // Only run comparison once per login session
            if (!session()->has('has_checked_login_updates')) {
                $latestPath = Path::max('updated_at');
                $latestModule = Module::max('updated_at');
                $latestQuiz = Quiz::max('updated_at');

                $latestDb = max(
                    $latestPath ? strtotime($latestPath) : 0,
                    $latestModule ? strtotime($latestModule) : 0,
                    $latestQuiz ? strtotime($latestQuiz) : 0
                );

                if ($user->last_seen_update && $latestDb > strtotime($user->last_seen_update)) {
                    session()->flash('pending_update_notification', true);
                }

                session(['has_checked_login_updates' => true]);
            }

            // Always update last_seen_update to current time
            $user->last_seen_update = now();
            $user->save();
        }

        return $next($request);
    }
}
