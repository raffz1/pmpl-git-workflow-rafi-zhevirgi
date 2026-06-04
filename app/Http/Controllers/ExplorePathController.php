<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Path;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Support\Facades\Validator;

class ExplorePathController extends Controller
{
    /*
     * EXPLORE PATHS
     * menampilkan semua learning path ke user
    */
    public function index()
    {
        $paths = Path::all();
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        return view('explore-path', compact('paths', 'userName'));
    }

    /*
     * memilih path belajar
     * mengatur path aktif user dan menyimpannya di database dan session
     */
    public function enroll($id)
    {
        session(['active_path_id' => $id]);
        if (auth()->check()) {
            $user = auth()->user();
            // ROLE USER DAN ADMIN: Admin tidak bisa mendaftar/enroll path belajar
            if ($user->isAdmin()) {
                return redirect()->route('dashboard')->with('error', 'Admin tidak bisa enroll path belajar.');
            }
            $user->active_path_id = $id;
            $user->save();
        }
        return redirect()->route('dashboard')->with('success', 'Berhasil memilih jalur pembelajaran!');
    }

    /*
     * DETAIL LEARNING PATH
     * mengatur pembatasan akses modul belajar agar berurutan
     * ROLE USER DAN ADMIN:
     * - Admin: membuka semua kunci modul agar bisa memeriksa dan mengedit konten kapan saja
     * - Student: membatasi akses modul, hanya modul <= currentStep yang bisa dibuka
     * PENYESUAIAN FORMAT EDIT ADMIN (QUIZ CUSTOM SELECTION):
     * - Admin bisa memilih menampilkan soal kuis secara acak (random) atau pilihan manual (custom selection)
     */
    protected function showPathDetail(string $slug)
    {
        $path = Path::where('slug', $slug)->firstOrFail();
        $modules = $path->modules()->orderBy('step_number')->with('quizzes')->get();
        
        $userName = auth()->check() ? (auth()->user()->name ?? 'Student') : 'Guest';
        $isAdmin = auth()->check() && auth()->user()->isAdmin();

        // ROLE USER & ADMIN - BYPASS KUNCI UNTUK ADMIN
        if ($isAdmin) {
            // admin mem-bypass limitasi sehingga step diset maksimal (membuka seluruh modul)
            $currentStep = $modules->count();
        } else if (auth()->check()) {
            $user = auth()->user();
            if ($user->active_path_id !== $path->id) {
                $user->active_path_id = $path->id;
                $user->save();
            }
            session(['active_path_id' => $path->id]);

            // mengambil step aktif user berdasarkan slug path
            if ($this->isCustomPath($slug)) {
                $progress = $user->custom_paths_progress ?? [];
                $currentStep = isset($progress[$slug]) ? (int)$progress[$slug] : 0;
            } else {
                $stepColumn = $this->getStepColumnName($slug);
                $currentStep = $user->$stepColumn ?? 0;
            }
            session([$slug . '_current_step' => $currentStep]);
        } else {
            // guest menggunakan session saja
            $currentStep = session($slug . '_current_step', 0);
        }

        // memetakan data modul ke struktur JSON yang akan dibaca oleh JavaScript di frontend
        $modulesData = $modules->map(function ($mod) use ($isAdmin) {
            $quizzesCollection = $mod->quizzes;

            // penyesuaian format edit oleh admin (custom selection vs shuffled quiz)
            if (!$isAdmin) {
                // jika admin memilih opsi 'custom' dan telah menentukan pertanyaan tertentu, tampilkan pertanyaan tersebut
                if ($mod->quiz_selection_type === 'custom' && is_array($mod->quiz_custom_questions) && count($mod->quiz_custom_questions) > 0) {
                    $customIds = $mod->quiz_custom_questions;
                    $filteredQuizzes = $quizzesCollection->filter(function ($q) use ($customIds) {
                        return in_array($q->id, $customIds);
                    });
                    
                    // urutkan soal sesuai dengan urutan ID yang ditentukan admin
                    $sortedQuizzes = collect();
                    foreach ($customIds as $id) {
                        $match = $filteredQuizzes->firstWhere('id', $id);
                        if ($match) {
                            $sortedQuizzes->push($match);
                        }
                    }
                    
                    // ambil maksimal 5 soal saja
                    $quizzesCollection = $sortedQuizzes->take(5);
                } else {
                    // opsi default: acak 5 soal dari semua kumpulan soal yang tersedia di modul
                    $quizzesCollection = $quizzesCollection->shuffle()->take(5);
                }
            }

            return [
                'id' => $mod->id,
                'title' => $mod->title,
                'fullTitle' => $mod->content_title,
                'content' => $mod->content_body,
                'desc' => $mod->desc,
                'quiz_selection_type' => $mod->quiz_selection_type ?? 'random',
                'quiz_custom_questions' => $mod->quiz_custom_questions ?? [],
                'quiz' => $quizzesCollection->map(function ($q) {
                    return [
                        'id' => $q->id,
                        'question' => $q->question,
                        'options' => $q->options,
                        'correct' => $q->correct,
                    ];
                })->values()->toArray()
            ];
        })->toArray();

        // LOGIKA BOOKMARKS: ambil modul-modul yang ditandai (marked) oleh user
        $markedModules = auth()->check() ? (auth()->user()->marked_modules ?? []) : [];

        return view('detail-path', compact('path', 'modules', 'modulesData', 'currentStep', 'userName', 'isAdmin', 'markedModules'));
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
     * menyimpan progres secara realtime (AJAX complete step)
     * mengunci/membuka (sequential unlock) modul berikutnya setelah user menyelesaikan checkpoint quiz saat ini.
     * dipanggil secara realtime dari workspace quiz setelah user lulus (minimal 80% jawaban benar).
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
            // admin tidak menulis / mengubah progres belajarnya
            if (!$user->isAdmin()) {
                $user->active_path_id = $pathId;
                
                // menambahkan 1 step progress jika belum mencapai akhir modul
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
            // guest menyimpan progres realtime di session saja
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
     * reset detail progress
     * mereset progres khusus untuk satu learning path tertentu kembali ke 0.
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
     * edit admin & realtime live update (update path card)
     * mengedit informasi path karir dan memperbarui data database
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

    /**
     * edit admin & realtime live update (update modul konten)
     * mengubah materi pembelajaran modul menggunakan quill editor
     * menggunakan method `touch()` pada model path agar timestamp `updated_at` diperbarui
     * sehingga memicu notifikasi refresh pada akun pengguna lain yang sedang membukanya
     */
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

        // touch parent path agar updated_at di-update
        $module->path->touch();

        return response()->json([
            'success' => true,
            'message' => 'Konten materi berhasil diperbarui secara realtime!'
        ]);
    }

    /**
     * edit admin & realtime live update (update soal kuis)
     * mengubah detail pertanyaan dan opsi kuis
     */
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

        // perbarui timestamp agar live update notifikasi terpicu
        $quiz->module->touch();
        $quiz->module->path->touch();

        return response()->json([
            'success' => true,
            'message' => 'Kuis berhasil diperbarui secara realtime!'
        ]);
    }

    /**
     * edit admin (store baru quiz)
     * menambahkan soal baru ke dalam kuis modul
     */
    public function storeQuiz(Request $request, $module_id)
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

        $module = Module::findOrFail($module_id);
        $quiz = $module->quizzes()->create([
            'question' => $request->question,
            'options' => $request->options,
            'correct' => $request->correct,
        ]);

        // perbarui timestamp
        $module->touch();
        $module->path->touch();

        return response()->json([
            'success' => true,
            'message' => 'Soal kuis baru berhasil ditambahkan!',
            'quiz' => [
                'id' => $quiz->id,
                'question' => $quiz->question,
                'options' => $quiz->options,
                'correct' => $quiz->correct,
            ]
        ]);
    }

    /**
     * edit admin (delete quiz)
     * menghapus soal kuis dari database dan membersihkan id dari data custom selection modul
     */
    public function deleteQuiz(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $quiz = Quiz::findOrFail($id);
        $module = $quiz->module;
        
        // bersihkan dari daftar custom selection modul
        if ($module->quiz_custom_questions && is_array($module->quiz_custom_questions)) {
            $custom = $module->quiz_custom_questions;
            if (($key = array_search($quiz->id, $custom)) !== false) {
                unset($custom[$key]);
                $module->quiz_custom_questions = array_values($custom);
                $module->save();
            }
        }

        $quiz->delete();

        // sentuh timestamp path untuk live update
        $module->touch();
        $module->path->touch();

        return response()->json([
            'success' => true,
            'message' => 'Soal kuis berhasil dihapus!'
        ]);
    }

    /**
     * format edit admin (update quiz settings)
     * menyimpan pilihan format kuis modul (apakah diacak atau memilih manual 5 pertanyaan spesifik)
     */
    public function updateQuizSettings(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $module = Module::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'quiz_selection_type' => 'required|in:random,custom',
            'quiz_custom_questions' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $module->quiz_selection_type = $request->quiz_selection_type;
        $module->quiz_custom_questions = $request->quiz_custom_questions ?? [];
        $module->save();

        $module->touch();
        $module->path->touch();

        return response()->json([
            'success' => true,
            'message' => 'Pengaturan kuis modul berhasil diperbarui!'
        ]);
    }

    /**
     * polling deteksi perubahan oleh user lain (check updates)
     * mengambil timestamp edit terakhir di database (path, module, atau quiz)
     * dan membandingkannya dengan timestamp `last_updated` milik client untuk memicu notifikasi reload page
     */
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

        // cari timestamp update terbaru dari path, module, maupun quiz
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

        // jika timestamp database lebih baru daripada milik client, kembalikan has_updates = true
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

    /**
     * store path baru (admin only)
     * membuat path pembelajaran kustom beserta modul pengenalan default dan 5 kuis placeholder
     */
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

        // buat modul pengenalan
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

        // buat 5 kuis default
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

    /**
     * tambah modul baru (admin only)
     * menambahkan modul baru ke akhir kurikulum path beserta 5 kuis default di dalamnya
     */
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

        // buat kuis default
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

    /**
     * delete path (admin only)
     * menghapus learning path beserta modul dan kuis di dalamnya
     */
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

    /**
     * delete modul (admin only)
     * menghapus modul, kuis di dalamnya, lalu menata ulang (reorder) step_number modul yang tersisa agar sequential
     */
    public function deleteModule($id)
    {
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $module = Module::findOrFail($id);
        $pathId = $module->path_id;

        $module->quizzes()->delete();
        $module->delete();

        // tata ulang nomor urutan step_number modul tersisa agar tetap berurutan (0, 1, 2, dst.)
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

    /**
     * polling deteksi perubahan global (untuk dashboard)
     * mengecek apakah ada pembaruan path, modul, atau kuis secara keseluruhan
     */
    public function checkGlobalUpdates(Request $request)
    {
        $lastChecked = $request->query('last_updated');
        if (!$lastChecked) {
            return response()->json(['has_updates' => false]);
        }

        $latestPath = Path::max('updated_at');
        $latestModule = Module::max('updated_at');
        $latestQuiz = Quiz::max('updated_at');

        $latestDb = max(
            $latestPath ? strtotime($latestPath) : 0,
            $latestModule ? strtotime($latestModule) : 0,
            $latestQuiz ? strtotime($latestQuiz) : 0
        );

        $hasUpdates = $latestDb > (int)$lastChecked;

        return response()->json([
            'has_updates' => $hasUpdates,
            'last_updated' => $latestDb
        ]);
    }

    /**
     * bookmarks / toggle mark modul
     * menambahkan/menghapus id modul dari kolom JSON `marked_modules` di model User
     */
    public function toggleModuleMark(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 401);
        }

        $user = auth()->user();
        if ($user->isAdmin()) {
            return response()->json(['success' => false, 'message' => 'Admin cannot mark modules.'], 403);
        }

        $marked = $user->marked_modules ?? [];
        $moduleId = (int)$id;

        // toggle logic: jika ada hapus, jika tidak ada tambahkan
        if (in_array($moduleId, $marked)) {
            $marked = array_values(array_diff($marked, [$moduleId]));
            $isMarked = false;
        } else {
            $marked[] = $moduleId;
            $isMarked = true;
        }

        $user->marked_modules = $marked;
        $user->save();

        return response()->json([
            'success' => true,
            'is_marked' => $isMarked,
            'message' => $isMarked ? 'Modul berhasil ditandai!' : 'Modul batal ditandai.'
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
