<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Path;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Support\Facades\Validator;

class ExplorePathController extends Controller
{
    public function index()
    {
        $paths = Path::all();
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        return view('explore-path', compact('paths', 'userName'));
    }

    public function enroll($id)
    {
        session(['active_path_id' => $id]);
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->isAdmin()) {
                return redirect()->route('dashboard')->with('error', 'Admin tidak diperbolehkan enroll path belajar.');
            }
            $user->active_path_id = $id;
            $user->save();
        }
        return redirect()->route('dashboard')->with('success', 'Berhasil memilih jalur pembelajaran!');
    }

    /**
     * Unified detail helper
     */
    protected function showPathDetail(string $slug)
    {
        $path = Path::where('slug', $slug)->firstOrFail();
        $modules = $path->modules()->orderBy('step_number')->with('quizzes')->get();
        
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        $isAdmin = auth()->check() && auth()->user()->isAdmin();

        if ($isAdmin) {
            // Bypass logic locks for admin so they can click/edit anything
            $currentStep = $modules->count();
        } else if (auth()->check()) {
            $user = auth()->user();
            if ($user->active_path_id !== $path->id) {
                $user->active_path_id = $path->id;
                $user->save();
            }
            session(['active_path_id' => $path->id]);

            if ($this->isCustomPath($slug)) {
                $progress = $user->custom_paths_progress ?? [];
                $currentStep = isset($progress[$slug]) ? (int)$progress[$slug] : 0;
            } else {
                $stepColumn = $this->getStepColumnName($slug);
                $currentStep = $user->$stepColumn ?? 0;
            }
            session([$slug . '_current_step' => $currentStep]);
        } else {
            $currentStep = session($slug . '_current_step', 0);
        }

        // Map modules for frontend consumption
        $modulesData = $modules->map(function ($mod) {
            return [
                'id' => $mod->id,
                'title' => $mod->title,
                'fullTitle' => $mod->content_title,
                'content' => $mod->content_body,
                'desc' => $mod->desc,
                'quiz' => $mod->quizzes->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'question' => $q->question,
                        'options' => $q->options,
                        'correct' => $q->correct,
                    ];
                })->toArray()
            ];
        })->toArray();

        return view('detail-path', compact('path', 'modules', 'modulesData', 'currentStep', 'userName', 'isAdmin'));
    }

    public function frontendDetail()
    {
        return $this->showPathDetail('frontend');
    }

    public function backendDetail()
    {
        return $this->showPathDetail('backend');
    }

    public function fullstackDetail()
    {
        return $this->showPathDetail('fullstack');
    }

    public function pmDetail()
    {
        return $this->showPathDetail('project-manager');
    }

    public function uiuxDetail()
    {
        return $this->showPathDetail('uiux');
    }

    /**
     * Unified complete step logic
     */
    protected function handleCompleteStep(Request $request, string $slug, int $pathId)
    {
        $path = Path::where('slug', $slug)->firstOrFail();
        $totalModules = $path->modules()->count();
        if ($totalModules === 0) {
            $totalModules = 7;
        }

        session(['active_path_id' => $pathId]);
        
        if (auth()->check()) {
            $user = auth()->user();
            // Admins don't write progress
            if (!$user->isAdmin()) {
                $user->active_path_id = $pathId;
                if ($this->isCustomPath($slug)) {
                    $progress = $user->custom_paths_progress ?? [];
                    $currentStep = isset($progress[$slug]) ? (int)$progress[$slug] : 0;
                    if ($currentStep < $totalModules) {
                        $currentStep++;
                        $progress[$slug] = $currentStep;
                        $user->custom_paths_progress = $progress;
                        $user->save();
                    }
                } else {
                    $stepColumn = $this->getStepColumnName($slug);
                    if ($user->$stepColumn < $totalModules) {
                        $user->$stepColumn = $user->$stepColumn + 1;
                        $user->save();
                    }
                    $currentStep = $user->$stepColumn;
                }
            } else {
                $currentStep = $totalModules;
            }
            session([$slug . '_current_step' => $currentStep]);
        } else {
            $currentStep = session($slug . '_current_step', 0);
            if ($currentStep < $totalModules) {
                $currentStep++;
                session([$slug . '_current_step' => $currentStep]);
            }
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'currentStep' => $currentStep,
                'message' => 'Selamat! Modul berhasil diselesaikan.'
            ]);
        }

        if ($this->isCustomPath($slug)) {
            return redirect()->route('path.detail.dynamic', $slug)->with('success', 'Selamat! Modul berhasil diselesaikan.');
        }

        $routeName = 'path.detail.' . ($slug === 'project-manager' ? 'pm' : $slug);
        return redirect()->route($routeName)->with('success', 'Selamat! Modul berhasil diselesaikan.');
    }

    public function completeStep(Request $request)
    {
        return $this->handleCompleteStep($request, 'frontend', 1);
    }

    public function completeBackendStep(Request $request)
    {
        return $this->handleCompleteStep($request, 'backend', 2);
    }

    public function completeFullstackStep(Request $request)
    {
        return $this->handleCompleteStep($request, 'fullstack', 4);
    }

    public function completePmStep(Request $request)
    {
        return $this->handleCompleteStep($request, 'project-manager', 5);
    }

    public function completeUiuxStep(Request $request)
    {
        return $this->handleCompleteStep($request, 'uiux', 3);
    }

    /**
     * Reset Progress
     */
    protected function handleResetProgress(string $slug)
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($this->isCustomPath($slug)) {
                $progress = $user->custom_paths_progress ?? [];
                $progress[$slug] = 0;
                $user->custom_paths_progress = $progress;
                $user->save();
            } else {
                $stepColumn = $this->getStepColumnName($slug);
                $user->$stepColumn = 0;
                $user->save();
            }
            session([$slug . '_current_step' => 0]);
        } else {
            session([$slug . '_current_step' => 0]);
        }

        if ($this->isCustomPath($slug)) {
            return redirect()->route('path.detail.dynamic', $slug)->with('success', 'Progres belajar berhasil direset dari awal.');
        }

        $routeName = 'path.detail.' . ($slug === 'project-manager' ? 'pm' : $slug);
        return redirect()->route($routeName)->with('success', 'Progres belajar berhasil direset dari awal.');
    }

    public function resetDetailProgress()
    {
        return $this->handleResetProgress('frontend');
    }

    public function resetBackendDetailProgress()
    {
        return $this->handleResetProgress('backend');
    }

    public function resetFullstackDetailProgress()
    {
        return $this->handleResetProgress('fullstack');
    }

    public function resetPmDetailProgress()
    {
        return $this->handleResetProgress('project-manager');
    }

    public function resetUiuxDetailProgress()
    {
        return $this->handleResetProgress('uiux');
    }

    /**
     * Admin APIs
     */
    public function updatePath(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|url',
            'theme' => 'required|in:cyan,green,pink,orange,yellow',
            'salary_range' => 'required|string|max:255',
            'skills' => 'required|array',
            'suitability' => 'required|array',
            'career_description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $path = Path::findOrFail($id);
        $path->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Path card berhasil diperbarui secara realtime!'
        ]);
    }

    public function updateModule(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'content_title' => 'required|string|max:255',
            'content_body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $module = Module::findOrFail($id);
        $module->update($request->all());

        // Update parent path's timestamp too
        $module->path->touch();

        return response()->json([
            'success' => true,
            'message' => 'Konten materi berhasil diperbarui secara realtime!'
        ]);
    }

    public function updateQuiz(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'correct' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $quiz = Quiz::findOrFail($id);
        $quiz->update($request->all());

        // Touch parent module and path
        $quiz->module->touch();
        $quiz->module->path->touch();

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil diperbarui secara realtime!'
        ]);
    }

    public function checkUpdates(Request $request, $slug)
    {
        $path = Path::where('slug', $slug)->first();
        if (!$path) {
            return response()->json(['has_updates' => false]);
        }

        $lastUpdatedClient = $request->query('last_updated');
        if (!$lastUpdatedClient) {
            return response()->json(['has_updates' => false]);
        }

        // Get latest updated_at from path, its modules, or quizzes
        $pathUpdated = $path->updated_at ? $path->updated_at->timestamp : 0;
        
        $latestModuleUpdated = Module::where('path_id', $path->id)
            ->max('updated_at');
        $moduleUpdated = $latestModuleUpdated ? strtotime($latestModuleUpdated) : 0;

        $latestQuizUpdated = Quiz::whereHas('module', function ($q) use ($path) {
                $q->where('path_id', $path->id);
            })
            ->max('updated_at');
        $quizUpdated = $latestQuizUpdated ? strtotime($latestQuizUpdated) : 0;

        $maxTimestamp = max($pathUpdated, $moduleUpdated, $quizUpdated);

        $hasUpdates = $maxTimestamp > intval($lastUpdatedClient);

        return response()->json([
            'has_updates' => $hasUpdates,
            'last_updated' => $maxTimestamp
        ]);
    }

    public function isCustomPath(string $slug): bool
    {
        return !in_array($slug, ['frontend', 'backend', 'uiux', 'fullstack', 'project-manager']);
    }

    public function detailBySlug($slug)
    {
        return $this->showPathDetail($slug);
    }

    public function completeStepDynamic(Request $request, $slug)
    {
        $path = Path::where('slug', $slug)->firstOrFail();
        return $this->handleCompleteStep($request, $slug, $path->id);
    }

    public function resetStepDynamic($slug)
    {
        return $this->handleResetProgress($slug);
    }

    public function storePath(Request $request)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:paths,slug',
            'image' => 'required|string',
            'theme' => 'required|string',
            'description' => 'required|string',
            'salary_range' => 'required|string',
            'skills' => 'required|string',
            'suitability' => 'required|string',
            'career_description' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $skills = array_filter(array_map('trim', explode(',', $request->skills)));
        $suitability = array_filter(array_map('trim', explode("\n", $request->suitability)));

        $path = Path::create([
            'title' => $request->title,
            'slug' => $request->slug,
            'icon' => 'uiux',
            'image' => $request->image,
            'description' => $request->description,
            'theme' => $request->theme,
            'salary_range' => $request->salary_range,
            'skills' => $skills,
            'suitability' => $suitability,
            'career_description' => $request->career_description,
        ]);

        $module = Module::create([
            'path_id' => $path->id,
            'step_number' => 0,
            'title' => 'Pengenalan',
            'desc' => 'Modul pengenalan awal untuk ' . $path->title,
            'side' => 'left',
            'icon' => '01',
            'content_title' => 'Selamat Datang di Jalur ' . $path->title,
            'content_body' => '<p>Ini adalah modul pengenalan untuk jalur pembelajaran baru Anda. Selamat belajar!</p>',
        ]);

        for ($i = 1; $i <= 5; $i++) {
            Quiz::create([
                'module_id' => $module->id,
                'question' => 'Pertanyaan placeholder ' . $i . ' untuk ' . $path->title . '?',
                'options' => ['Jawaban Benar', 'Pilihan Salah A', 'Pilihan Salah B'],
                'correct' => 0,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Path baru berhasil dibuat!',
            'redirect' => route('explore.path')
        ]);
    }

    public function storeModule(Request $request, $path_id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $path = Path::findOrFail($path_id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
            'content_title' => 'required|string',
            'content_body' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $nextStepNumber = Module::where('path_id', $path->id)->count();
        $side = ($nextStepNumber % 2 === 0) ? 'left' : 'right';
        $icon = sprintf("%02d", $nextStepNumber + 1);

        $module = Module::create([
            'path_id' => $path->id,
            'step_number' => $nextStepNumber,
            'title' => $request->title,
            'desc' => $request->desc,
            'side' => $side,
            'icon' => $icon,
            'content_title' => $request->content_title,
            'content_body' => $request->content_body,
        ]);

        for ($i = 1; $i <= 5; $i++) {
            Quiz::create([
                'module_id' => $module->id,
                'question' => 'Pertanyaan Kuis ' . $i . ' untuk ' . $module->title . '?',
                'options' => ['Pilihan Benar', 'Pilihan Salah A', 'Pilihan Salah B'],
                'correct' => 0,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Modul baru berhasil ditambahkan!',
        ]);
    }

    public function deletePath($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $path = Path::findOrFail($id);
        
        foreach ($path->modules as $module) {
            $module->quizzes()->delete();
            $module->delete();
        }
        
        $path->delete();

        return response()->json([
            'success' => true,
            'message' => 'Path berhasil dihapus secara realtime!'
        ]);
    }

    public function deleteModule($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $module = Module::findOrFail($id);
        $pathId = $module->path_id;

        $module->quizzes()->delete();
        $module->delete();

        // Reorder remaining modules
        $remainingModules = Module::where('path_id', $pathId)
            ->orderBy('step_number', 'asc')
            ->get();

        foreach ($remainingModules as $index => $mod) {
            $mod->step_number = $index;
            $mod->side = ($index % 2 === 0) ? 'left' : 'right';
            $mod->icon = sprintf("%02d", $index + 1);
            $mod->save();
        }

        $path = Path::find($pathId);
        if ($path) {
            $path->touch();
        }

        return response()->json([
            'success' => true,
            'message' => 'Modul berhasil dihapus dan urutan kurikulum telah diperbarui!'
        ]);
    }

    private function getStepColumnName(string $slug): string
    {
        switch ($slug) {
            case 'frontend': return 'frontend_current_step';
            case 'backend': return 'backend_current_step';
            case 'uiux': return 'uiux_current_step';
            case 'fullstack': return 'fullstack_current_step';
            case 'project-manager': return 'pm_current_step';
            default: return 'frontend_current_step';
        }
    }
}
