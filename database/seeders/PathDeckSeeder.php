<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Path;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PathDeckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Users
        // Admin Account
        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin Path Deck',
                'username' => 'adminpath',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'active_path_id' => null,
            ]
        );

        // Student Account
        User::updateOrCreate(
            ['email' => 'student@pathdeck.com'],
            [
                'name' => 'Student Path Deck',
                'username' => 'studentpath',
                'password' => Hash::make('password'),
                'role' => 'user',
                'active_path_id' => 1, // Start on Front End
                'frontend_current_step' => 0,
                'backend_current_step' => 0,
                'uiux_current_step' => 0,
                'fullstack_current_step' => 0,
                'pm_current_step' => 0,
            ]
        );

        // 2. Seed Paths
        $pathsData = [
            'frontend' => [
                'title' => 'Front End Developer',
                'icon' => 'frontend',
                'image' => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?w=600&auto=format&fit=crop&q=80',
                'description' => 'Kuasai seni merancang antarmuka pengguna yang indah dan responsif dengan kerangka kerja modern dan praktik aksesibilitas.',
                'theme' => 'cyan',
                'salary_range' => 'Rp 5.750.000 - Rp 15.000.000',
                'skills' => ['HTML', 'CSS', 'JavaScript', 'React'],
                'suitability' => [
                    'Menyukai detail yang sangat presisi hingga tingkat piksel dan pola desain yang sangat rapi.',
                    'Senang menjembatani kesenjangan antara desain dan teknik tingkat tinggi.',
                    'Ingin membangun sistem modular yang dapat diskalakan hingga jutaan pengguna.'
                ],
                'career_description' => 'Frontend Developer bertanggung jawab membangun tampilan web yang interaktif, cepat, dan responsif. Mereka bekerja sama dengan Designer UI/UX untuk menerjemahkan mockup visual menjadi kode nyata yang dapat diakses pengguna di browser.'
            ],
            'backend' => [
                'title' => 'Back End Developer',
                'icon' => 'backend',
                'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600&auto=format&fit=crop&q=80',
                'description' => 'Rancang server yang dapat diskalakan, buat API yang andal, dan kelola basis data yang kompleks untuk aplikasi berkinerja tinggi.',
                'theme' => 'green',
                'salary_range' => 'Rp 6.000.000 - Rp 18.000.000',
                'skills' => ['PHP', 'Laravel', 'Node.js', 'SQL', 'REST API'],
                'suitability' => [
                    'Senang memecahkan algoritma rumit dan merancang alur logika data.',
                    'Tertarik dengan keamanan data, arsitektur server, dan query basis data.',
                    'Mengutamakan performa sistem di balik layar yang cepat dan andal.'
                ],
                'career_description' => 'Backend Developer mengelola apa yang tidak dilihat oleh mata pengguna: server, database, keamanan, dan logika integrasi API. Mereka memastikan data tersimpan aman dan terkirim dengan cepat ke sisi Frontend.'
            ],
            'uiux' => [
                'title' => 'UI/UX Designer',
                'icon' => 'uiux',
                'image' => 'https://images.unsplash.com/photo-1586717791821-3f44a563fa4c?w=600&auto=format&fit=crop&q=80',
                'description' => 'Selesaikan masalah pengguna melalui pendekatan desain thinking. Ciptakan pengalaman yang intuitif dan komponen visual yang apik.',
                'theme' => 'pink',
                'salary_range' => 'Rp 5.500.000 - Rp 14.000.000',
                'skills' => ['Figma', 'User Research', 'Wireframing', 'Prototyping'],
                'suitability' => [
                    'Memiliki rasa empati tinggi untuk memahami keluhan dan kebutuhan pengguna.',
                    'Menyukai seni visual, komposisi warna, tata letak, dan keindahan estetika.',
                    'Senang menguji coba alur navigasi aplikasi agar terasa intuitif.'
                ],
                'career_description' => 'UI/UX Designer merancang struktur pengalaman pengguna (UX) dan keindahan visual antarmuka (UI). Tugas mereka meliputi riset pengguna, pembuatan wireframe, hingga prototype interaktif siap uji.'
            ],
            'fullstack' => [
                'title' => 'Full Stack Developer',
                'icon' => 'fullstack',
                'image' => 'https://images.unsplash.com/photo-1605379399642-870262d3d051?w=600&auto=format&fit=crop&q=80',
                'description' => 'Jembatani kesenjangan antara klien dan server. Jadilah pengembang serba bisa yang mampu membangun solusi end-to-end.',
                'theme' => 'orange',
                'salary_range' => 'Rp 7.000.000 - Rp 22.000.000',
                'skills' => ['HTML/CSS', 'JavaScript', 'Node.js', 'Database', 'Docker'],
                'suitability' => [
                    'Ingin memiliki kontrol penuh terhadap seluruh siklus pengembangan aplikasi.',
                    'Suka mempelajari teknologi client-side dan server-side secara bersamaan.',
                    'Dibutuhkan fleksibilitas tinggi untuk berpindah fokus tugas dengan cepat.'
                ],
                'career_description' => 'Full Stack Developer menguasai Frontend sekaligus Backend. Mereka adalah generalis tangguh yang mampu membangun sebuah produk digital dari nol hingga siap tayang di internet secara mandiri.'
            ],
            'project-manager' => [
                'title' => 'Project Manager',
                'icon' => 'pm',
                'image' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=600&auto=format&fit=crop&q=80',
                'description' => 'Profesional yang bertanggung jawab penuh merencanakan, mengelola, mengeksekusi, serta mengawasi sebuah proyek dari awal hingga selesai.',
                'theme' => 'yellow',
                'salary_range' => 'Rp 8.000.000 - Rp 25.000.000',
                'skills' => ['Agile/Scrum', 'Jira', 'Risk Management', 'Leadership'],
                'suitability' => [
                    'Memiliki kemampuan kepemimpinan dan komunikasi interpersonal yang sangat kuat.',
                    'Sangat terorganisir dalam menjadwalkan tugas dan memperkirakan estimasi waktu.',
                    'Senang memecahkan masalah dalam tim dan bernegosiasi dengan klien.'
                ],
                'career_description' => 'Project Manager memimpin jalannya proyek teknologi agar selesai tepat waktu, sesuai anggaran, dan memenuhi standar kualitas. Mereka menjembatani komunikasi antara developer, desainer, dan stakeholder bisnis.'
            ]
        ];

        $paths = [];
        foreach ($pathsData as $slug => $data) {
            $paths[$slug] = Path::updateOrCreate(['slug' => $slug], $data);
        }

        // 3. Seed Front End Modules (Rich & Interactive)
        $frontendModules = [
            [
                'step_number' => 0,
                'title' => 'Pengenalan',
                'desc' => 'Mempelajari peran Frontend Developer dalam pengembangan aplikasi web modern.',
                'side' => 'left',
                'icon' => '01',
                'content_title' => 'Apa itu Frontend Developer?',
                'content_body' => '
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-6 font-medium">
                        Dalam siklus pengembangan perangkat lunak (software development), <strong>Frontend Developer</strong> adalah insinyur yang bertanggung jawab penuh dalam membangun bagian aplikasi yang berinteraksi langsung dengan pengguna. Semua visual, teks, tombol, layout, dan animasi yang Anda lihat saat membuka website adalah hasil kerja seorang Frontend Developer.
                    </p>
                    <div class="h-0.5 w-48 bg-gradient-to-r from-[#0050d2] to-transparent my-8"></div>
                    <h3 class="text-xl font-bold text-slate-900 mb-4 border-l-4 border-[#0050d2] pl-3">Tiga Pilar Utama Teknologi Frontend</h3>
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-4 font-medium">
                        Untuk membangun antarmuka web modern yang dinamis dan berkinerja tinggi, Anda wajib menguasai tiga pilar utama berikut:
                    </p>
                    <ul class="space-y-3.5 text-slate-600 pl-4 list-disc mb-6 font-medium">
                        <li><strong>HTML (HyperText Markup Language):</strong> Sebagai kerangka dasar yang menstrukturkan seluruh elemen halaman.</li>
                        <li><strong>CSS (Cascading Style Sheets):</strong> Sebagai desainer estetika yang mengatur gaya, warna, responsivitas layout, dan tipografi.</li>
                        <li><strong>JavaScript:</strong> Sebagai motor penggerak logika interaktif pada browser (misal: penanganan klik, fetching data API, manipulasi status UI).</li>
                    </ul>

                    <!-- WIDGET INTERAKTIF 1 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Mana Pilihan Karirmu?</h4>
                        <p class="text-xs text-slate-500 mb-4">Klik tombol di bawah untuk melihat ringkasan visual fokus masing-masing role!</p>
                        <div class="flex gap-2 mb-4">
                            <button type="button" onclick="toggleVisualRole(\'fe\')" id="visual-fe-btn" class="px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl shadow-sm transition-all cursor-pointer">Frontend</button>
                            <button type="button" onclick="toggleVisualRole(\'be\')" id="visual-be-btn" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all cursor-pointer">Backend</button>
                        </div>
                        <div id="visual-fe-desc" class="text-xs text-slate-600 leading-relaxed bg-white border border-slate-150 p-4 rounded-xl shadow-sm">
                            <strong>Fokus Frontend:</strong> Merancang antarmuka pengguna (UI), performa rendering browser, animasi transisi, aksesibilitas (accessibility), dan integrasi API client-side. Senjata utama: HTML, CSS, JavaScript, React.
                        </div>
                        <div id="visual-be-desc" class="text-xs text-slate-600 leading-relaxed bg-white border border-slate-150 p-4 rounded-xl shadow-sm hidden">
                            <strong>Fokus Backend:</strong> Mengelola logika server, keamanan sistem, enkripsi data, query database relasional/non-relasional, caching, dan deployment server cloud. Senjata utama: PHP, Node.js, SQL, Linux.
                        </div>
                    </div>
                    <script>
                        window.toggleVisualRole = function(role) {
                            const feBtn = document.getElementById(\'visual-fe-btn\');
                            const beBtn = document.getElementById(\'visual-be-btn\');
                            const feDesc = document.getElementById(\'visual-fe-desc\');
                            const beDesc = document.getElementById(\'visual-be-desc\');
                            if (role === \'fe\') {
                                feBtn.className = \'px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl shadow-sm transition-all cursor-pointer\';
                                beBtn.className = \'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all cursor-pointer\';
                                feDesc.classList.remove(\'hidden\');
                                beDesc.classList.add(\'hidden\');
                            } else {
                                beBtn.className = \'px-4 py-2 bg-blue-600 text-white text-xs font-bold rounded-xl shadow-sm transition-all cursor-pointer\';
                                feBtn.className = \'px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition-all cursor-pointer\';
                                beDesc.classList.remove(\'hidden\');
                                feDesc.classList.add(\'hidden\');
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    [
                        'question' => 'Di dunia industri modern, saat merancang arsitektur aplikasi e-commerce besar, apa batasan utama tugas seorang Frontend Developer dibanding Backend Developer?',
                        'options' => [
                            'A. Frontend fokus pada performa query database, sedangkan Backend fokus pada layout halaman checkout.',
                            'B. Frontend fokus pada antarmuka visual dan kenyamanan interaksi pengguna di browser, sedangkan Backend menangani logika bisnis di server dan database.',
                            'C. Frontend bertugas membackup file server cloud, sedangkan Backend menulis stylesheet CSS.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Sebuah startup ingin merilis web app dengan layout interaktif yang memuat grafik penjualan real-time. Manakah susunan teknologi yang tepat untuk menangani struktur, estetika, dan data dinamis pada client-side?',
                        'options' => [
                            'A. SQL untuk struktur, PHP untuk estetika, Java untuk interaksi.',
                            'B. HTML untuk struktur, CSS untuk tata letak/gaya, dan JavaScript untuk visualisasi grafik interaktif.',
                            'C. HTML untuk data, Docker untuk styling, dan Python untuk browser rendering.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Saat berdiskusi dengan UI/UX Designer, mereka meminta Anda membuat tombol yang \'bergoyang\' saat di-hover untuk meningkatkan conversion rate. Komponen mana yang bertanggung jawab atas perilaku interaktif ini?',
                        'options' => [
                            'A. HTML saja, karena tag link otomatis memicu animasi di browser.',
                            'B. CSS transition/animation untuk efek gerak visual, atau JavaScript untuk penanganan event detail.',
                            'C. Database relasional untuk menyimpan titik kordinat goyangan.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Sebagai Frontend Engineer, Anda menemukan bahwa user mengalami error saat menekan tombol submit form. Setelah dicek, server mengembalikan error 500. Di manakah letak masalah sebenarnya?',
                        'options' => [
                            'A. Terjadi bug pada CSS layout tombol.',
                            'B. Ada kesalahan pada browser pengguna yang memblokir tag HTML.',
                            'C. Terjadi kegagalan di sisi server (Backend) saat memproses data form.'
                        ],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Dalam pengembangan web modern, mengapa seorang Frontend Developer harus memahami konsep REST API atau GraphQL?',
                        'options' => [
                            'A. Untuk dapat mengambil dan mengirimkan data dinamis dari dan ke server database secara aman.',
                            'B. Untuk menulis kode program langsung ke dalam firmware router internet.',
                            'C. Karena browser hanya mendukung file berekstensi .api.'
                        ],
                        'correct' => 0
                    ]
                ]
            ],
            [
                'step_number' => 1,
                'title' => 'Dasar-Dasar HTML',
                'desc' => 'Memahami struktur dokumen web, tag-tag penting, dan konsep Semantic HTML.',
                'side' => 'right',
                'icon' => '02',
                'content_title' => 'Menguasai Struktur Halaman Web dengan HTML',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        HTML (HyperText Markup Language) adalah fondasi mutlak dari setiap halaman web. Menulis HTML yang baik bukan sekadar membuat teks muncul di layar, melainkan menyusun dokumen yang logis, dapat diakses oleh semua orang, serta ramah bagi mesin pencari (SEO).
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Mengapa Harus Semantic HTML?
                    </h3>
                    <p class="text-slate-600 leading-relaxed mb-4 font-medium">
                        Semantic HTML menggunakan tag yang mendeskripsikan arti atau makna dari konten tersebut, bukan sekadar gaya visualnya. Contoh tag semantik meliputi <code>&lt;header&gt;</code>, <code>&lt;nav&gt;</code>, <code>&lt;main&gt;</code>, <code>&lt;article&gt;</code>, dan <code>&lt;footer&gt;</code>. Penggunaan tag ini membantu mesin pencari mengindeks website Anda dan membantu tunanetra yang menggunakan alat pembaca layar (screen reader).
                    </p>

                    <!-- WIDGET INTERAKTIF 2 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Live HTML Preview</h4>
                        <p class="text-xs text-slate-500 mb-3">Ketik atau ubah kode HTML sederhana di bawah ini untuk melihat hasil rendernya secara live di browser!</p>
                        <textarea id="live-html-code" class="w-full h-24 p-3 font-mono text-xs border border-slate-200 rounded-xl mb-3 focus:outline-none focus:border-blue-500 bg-white" placeholder="Ketik tag HTML di sini...">&lt;h3 class="text-lg font-extrabold text-blue-600"&gt;HTML Hebat!&lt;/h3&gt;&#10;&lt;p class="text-xs text-slate-600 mt-1"&gt;Ini dirender secara real-time oleh browser.&lt;/p&gt;&#10;&lt;button class="mt-2 px-3 py-1 bg-emerald-500 text-white rounded text-[10px] font-bold" onclick="alert(\'Tombol diklik!\')"&gt;Coba Klik&lt;/button&gt;</textarea>
                        <button type="button" onclick="renderLiveHtml()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm mb-3 cursor-pointer">Lihat Hasil Render</button>
                        <div class="text-[10px] font-bold text-slate-400 mb-1">HASIL PREVIEW:</div>
                        <div id="live-html-preview" class="p-4 bg-white border border-slate-200 rounded-xl text-sm min-h-[60px]">
                            <h3 class="text-lg font-extrabold text-blue-600">HTML Hebat!</h3>
                            <p class="text-xs text-slate-600 mt-1">Ini dirender secara real-time oleh browser.</p>
                            <button class="mt-2 px-3 py-1 bg-emerald-500 text-white rounded text-[10px] font-bold" onclick="alert(\'Tombol diklik!\')">Coba Klik</button>
                        </div>
                    </div>
                    <script>
                        window.renderLiveHtml = function() {
                            const code = document.getElementById(\'live-html-code\').value;
                            document.getElementById(\'live-html-preview\').innerHTML = code;
                        }
                    </script>
                ',
                'quizzes' => [
                    [
                        'question' => 'Dalam audit SEO sebuah situs berita, Google Bot memberikan skor rendah karena struktur konten dinilai tidak jelas. Tag manakah yang harus digunakan untuk membungkus artikel berita utama agar ramah mesin pencari?',
                        'options' => [
                            'A. Tag &lt;div class="artikel"&gt; karena paling serbaguna.',
                            'B. Tag &lt;article&gt; secara semantik menyatakan sebuah konten independen.',
                            'C. Tag &lt;section-news-box&gt; buatan sendiri.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Sebuah tim e-government ingin membuat form registrasi yang ramah bagi penyandang disabilitas (aksesibilitas WCAG). Properti HTML apa yang wajib disematkan pada tag input agar dapat dibaca dengan baik oleh screen reader?',
                        'options' => [
                            'A. Menghubungkan tag &lt;label&gt; menggunakan atribut "for" dengan atribut "id" pada input terkait.',
                            'B. Mengubah tipe input menjadi type="accessibility".',
                            'C. Mengisi teks penjelas di dalam atribut "color".'
                        ],
                        'correct' => 0
                    ],
                    [
                        'question' => 'Seorang junior developer menulis tag gambar &lt;img src="hero.jpg"&gt;. Saat jaringan lambat, gambar gagal dimuat dan layout berantakan tanpa keterangan apapun. Apa yang kurang dari tag tersebut?',
                        'options' => [
                            'A. Ketinggian gambar harus ditulis di dalam tag &lt;css&gt;.',
                            'B. Atribut "alt" sebagai teks alternatif pembaca layar dan pengganti saat gambar gagal dimuat.',
                            'C. Link download manual di dalam tag &lt;src&gt;.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Bagaimana cara membuat tautan internal yang dapat mengarahkan pengguna langsung ke bagian footer halaman web (contoh ID: "#footer") saat diklik?',
                        'options' => [
                            'A. &lt;a href="#footer"&gt;Pergi ke Footer&lt;/a&gt;',
                            'B. &lt;link src="footer"&gt;Pergi ke Footer&lt;/link&gt;',
                            'C. &lt;a link="/footer"&gt;Pergi ke Footer&lt;/a&gt;'
                        ],
                        'correct' => 0
                    ],
                    [
                        'question' => 'Manakah dari tag HTML berikut yang benar secara semantik untuk menyajikan daftar fitur utama produk tanpa urutan numerik (bulleted list)?',
                        'options' => [
                            'A. Menggunakan tag &lt;ol&gt; diisi dengan &lt;li&gt;.',
                            'B. Menggunakan kombinasi &lt;br&gt; berulang-ulang di dalam paragraf.',
                            'C. Menggunakan tag &lt;ul&gt; diisi dengan tag &lt;li&gt;.'
                        ],
                        'correct' => 2
                    ]
                ]
            ],
            [
                'step_number' => 2,
                'title' => 'CSS',
                'desc' => 'Mengatur tata letak halaman web dengan Box Model, Flexbox, CSS Grid, dan Media Queries.',
                'side' => 'left',
                'icon' => '03',
                'content_title' => 'Mempercantik Tampilan Halaman Web dengan CSS',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        CSS (Cascading Style Sheets) adalah bahasa desain yang digunakan untuk mempercantik antarmuka web. Dengan CSS, kita dapat memisahkan konten (HTML) dengan tampilan (warna, font, spacing, layout). Salah satu tantangan terbesar di CSS adalah merancang tata letak yang adaptif di berbagai ukuran perangkat (Responsive Web Design).
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Konsep Flexbox (Flexible Box Layout)
                    </h3>
                    <p class="text-slate-600 leading-relaxed mb-4 font-medium">
                        Flexbox mempermudah penyusunan elemen di dalam container satu dimensi (horizontal atau vertikal). Anda dapat memusatkan elemen secara horizontal dan vertikal hanya dengan beberapa baris kode CSS.
                    </p>

                    <!-- WIDGET INTERAKTIF 3 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interaktif: Flexbox Alignment Visualizer</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol untuk mengubah properti <code>justify-content</code> pada kontainer flex di bawah secara live!</p>
                        <div class="flex flex-wrap gap-2 mb-4">
                            <button type="button" onclick="changeFlexJustify(\'justify-start\')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg transition-all cursor-pointer font-medium">justify-start</button>
                            <button type="button" onclick="changeFlexJustify(\'justify-center\')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg transition-all cursor-pointer font-medium">justify-center</button>
                            <button type="button" onclick="changeFlexJustify(\'justify-end\')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg transition-all cursor-pointer font-medium">justify-end</button>
                            <button type="button" onclick="changeFlexJustify(\'justify-between\')" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg transition-all cursor-pointer font-medium">justify-between</button>
                        </div>
                        <div id="flex-visual-container" class="flex justify-start gap-4 p-4 bg-slate-200 border border-slate-300 rounded-xl h-24 items-center transition-all duration-300">
                            <div class="w-12 h-12 bg-blue-600 text-white text-[10px] font-bold rounded-lg flex items-center justify-center shadow-md">Kotak 1</div>
                            <div class="w-12 h-12 bg-emerald-500 text-white text-[10px] font-bold rounded-lg flex items-center justify-center shadow-md">Kotak 2</div>
                            <div class="w-12 h-12 bg-amber-500 text-white text-[10px] font-bold rounded-lg flex items-center justify-center shadow-md">Kotak 3</div>
                        </div>
                    </div>
                    <script>
                        window.changeFlexJustify = function(justifyClass) {
                            const container = document.getElementById(\'flex-visual-container\');
                            container.className = \'flex gap-4 p-4 bg-slate-200 border border-slate-300 rounded-xl h-24 items-center transition-all duration-300 \' + justifyClass;
                        }
                    </script>
                ',
                'quizzes' => [
                    [
                        'question' => 'Saat membangun antarmuka web, Anda menemukan konten overlap dengan border elemen. Konsep Box Model CSS manakah yang mengatur ruang di dalam border untuk menjauhkan konten dari tepi border?',
                        'options' => [
                            'A. margin',
                            'B. border-width',
                            'C. padding'
                        ],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Anda mendesain sebuah navbar yang harus tetap menempel di bagian paling atas layar komputer pengguna saat halaman di-scroll ke bawah. Properti position mana yang harus Anda gunakan?',
                        'options' => [
                            'A. position: absolute;',
                            'B. position: fixed;',
                            'C. position: relative;'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Desainer meminta Anda menyusun 3 buah kartu secara horizontal, dan secara otomatis bergeser menjadi vertikal ketika dibuka lewat smartphone. Teknik layout CSS modern manakah yang paling efisien?',
                        'options' => [
                            'A. Menggunakan table HTML manual.',
                            'B. Flexbox dengan properti flex-direction: row di desktop dan flex-direction: column menggunakan media query.',
                            'C. Menggunakan properti float: left di seluruh kartu.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Dalam membuat website responsif, developer menggunakan @media (max-width: 768px). Apa tujuan utama dari penulisan sintaks media query tersebut?',
                        'options' => [
                            'A. Membatasi resolusi layar agar tidak bisa lebih dari 768 pixel.',
                            'B. Menerapkan gaya CSS khusus hanya saat lebar viewport browser maksimal 768 pixel (ukuran tablet/HP).',
                            'C. Mengurangi ukuran file gambar agar hemat kuota internet.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Di CSS Grid, properti mana yang digunakan untuk menentukan ukuran kolom secara presisi dan dinamis (misalnya membagi Grid menjadi 3 kolom sama rata)?',
                        'options' => [
                            'A. grid-template-columns: repeat(3, 1fr);',
                            'B. grid-row-gap: 3px;',
                            'C. grid-template-rows: 3px 3px 3px;'
                        ],
                        'correct' => 0
                    ]
                ]
            ],
            [
                'step_number' => 3,
                'title' => 'JavaScript',
                'desc' => 'Menambahkan interaksi dinamis, mengelola event listener, manipulasi DOM, dan integrasi API.',
                'side' => 'right',
                'icon' => '04',
                'content_title' => 'Logika dan Interaksi Dinamis dengan JavaScript',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        JavaScript adalah otak di balik interaktivitas website. Tanpa JavaScript, halaman web Anda hanyalah dokumen statis yang tidak dapat menanggapi tindakan kompleks pengguna secara instan tanpa memuat ulang halaman.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Event Listener & Manipulasi DOM
                    </h3>
                    <p class="text-slate-600 leading-relaxed mb-4 font-medium">
                        DOM (Document Object Model) mempresentasikan struktur HTML sebagai pohon objek yang dapat dimanipulasi JavaScript. Dengan <code>document.getElementById()</code> atau <code>document.querySelector()</code>, Anda dapat mengubah isi teks, properti kelas CSS, atau menghapus elemen secara dinamis.
                    </p>

                    <!-- WIDGET INTERAKTIF 4 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interaktif: JavaScript Click Counter</h4>
                        <p class="text-xs text-slate-500 mb-3">Tombol ini menunjukkan manipulasi State sederhana menggunakan Event Listener di JavaScript.</p>
                        <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-slate-150">
                            <button type="button" onclick="incrementCounter()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl shadow-sm transition-all cursor-pointer">Klik Aku</button>
                            <span class="text-xs font-extrabold text-slate-700">Jumlah Klik: <span id="click-counter-val" class="text-blue-600 font-mono text-sm">0</span></span>
                        </div>
                    </div>
                    <script>
                        let counterVal = 0;
                        window.incrementCounter = function() {
                            counterVal++;
                            document.getElementById(\'click-counter-val\').innerText = counterVal;
                        }
                    </script>
                ',
                'quizzes' => [
                    [
                        'question' => 'Sebuah landing page memiliki tombol \'Mode Gelap\'. Ketika diklik, background berubah hitam. Di JavaScript, metode apa yang digunakan untuk mendengarkan aksi klik pengguna tersebut?',
                        'options' => [
                            'A. button.onClickListen()',
                            'B. button.addEventListener(\'click\', callbackFunction)',
                            'C. button.triggerClick()'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Anda ingin mengambil data daftar produk dari API /api/products secara asinkronus dan menampilkannya di halaman web tanpa memicu reload. Sintaks JS modern apa yang paling tepat digunakan?',
                        'options' => [
                            'A. Menggunakan Fetch API dengan async/await.',
                            'B. Menggunakan tag &lt;iframe&gt;.',
                            'C. Memanggil fungsi window.reload().'
                        ],
                        'correct' => 0
                    ],
                    [
                        'question' => 'Di JavaScript, jika Anda mendeklarasikan variabel yang menyimpan API URL dasar yang tidak boleh diubah oleh script lain selama aplikasi berjalan, kata kunci deklarasi apa yang harus Anda gunakan?',
                        'options' => [
                            'A. const',
                            'B. let',
                            'C. var'
                        ],
                        'correct' => 0
                    ],
                    [
                        'question' => 'Saat memeriksa console log, terdapat error \'TypeError: Cannot read properties of null (reading "innerHTML")\'. Apa kemungkinan penyebab utama dari error manipulasi DOM ini?',
                        'options' => [
                            'A. Browser Anda kehabisan memori RAM.',
                            'B. JavaScript dieksekusi sebelum elemen HTML terkait selesai dimuat di DOM tree.',
                            'C. Anda lupa menulis kode CSS untuk elemen tersebut.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Manakah dari tipe data JavaScript berikut yang paling tepat digunakan untuk menyimpan status \'sudah login\' (true) atau \'belum login\' (false) dari seorang user?',
                        'options' => [
                            'A. Boolean',
                            'B. Object',
                            'C. String'
                        ],
                        'correct' => 0
                    ]
                ]
            ],
            [
                'step_number' => 4,
                'title' => 'Framework dan Library Modern',
                'desc' => 'Belajar merancang Component-Based UI, Virtual DOM, dan SPA menggunakan React/Vue.',
                'side' => 'left',
                'icon' => '05',
                'content_title' => 'Mengenal Library & Framework Frontend Modern',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Mengembangkan aplikasi berskala besar menggunakan JavaScript murni (Vanilla JS) rentan menghasilkan kode yang sulit dipelihara (spaghetti code). Oleh karena itu, industri web modern saat ini didominasi oleh library dan framework seperti <strong>React.js</strong>, <strong>Vue.js</strong>, dan <strong>Angular</strong>.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Arsitektur Berbasis Komponen (Component-Based UI)
                    </h3>
                    <p class="text-slate-600 leading-relaxed mb-4 font-medium">
                        Dalam framework modern, antarmuka pengguna dibagi-bagi menjadi blok-blok kecil mandiri (components) yang menyimpan kode HTML, CSS, dan logika perilakunya sendiri. Komponen-komponen ini dapat digunakan kembali (reusable) di berbagai tempat, menghemat waktu penulisan kode secara signifikan.
                    </p>

                    <!-- WIDGET INTERAKTIF 5 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interaktif: React Component & State Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol untuk menyimulasikan perubahan State. Perhatikan bagaimana DOM RENDER otomatis terupdate secara reaktif!</p>
                        <div class="bg-white border border-slate-200 rounded-xl p-4 flex flex-col items-center shadow-sm">
                            <div class="flex gap-2 mb-3">
                                <button type="button" onclick="changeFrameworkState(\'React\')" class="px-3 py-1 bg-sky-100 hover:bg-sky-200 text-sky-700 text-xs font-bold rounded-lg transition-all cursor-pointer font-medium">React State</button>
                                <button type="button" onclick="changeFrameworkState(\'Vue\')" class="px-3 py-1 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-xs font-bold rounded-lg transition-all cursor-pointer font-medium">Vue Ref</button>
                            </div>
                            <div class="w-full max-w-xs border border-slate-100 rounded-lg p-3 text-center bg-slate-50">
                                <span class="text-[9px] font-mono text-slate-400 block mb-1">DOM RENDER OUT:</span>
                                <div id="framework-state-visual" class="text-xs font-bold text-sky-600 font-mono">React: useState("React")</div>
                            </div>
                        </div>
                    </div>
                    <script>
                        window.changeFrameworkState = function(framework) {
                            const visual = document.getElementById(\'framework-state-visual\');
                            if (framework === \'React\') {
                                visual.className = \'text-xs font-bold text-sky-600 font-mono\';
                                visual.innerText = \'React: useState("React")\';
                            } else {
                                visual.className = \'text-xs font-bold text-emerald-600 font-mono\';
                                visual.innerText = \'Vue: const state = ref("Vue")\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    [
                        'question' => 'Aplikasi e-commerce Anda memiliki halaman katalog dengan ratusan produk. Saat user memfilter kategori, UI terupdate instan tanpa lag. Mekanisme internal framework apa yang mengoptimalkan rendering DOM ini?',
                        'options' => [
                            'A. Garbage Collection',
                            'B. Virtual DOM yang mendeteksi perbedaan (diffing) sebelum merender ke DOM asli.',
                            'C. Relational Database Indexing'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Dalam framework modern seperti React, Anda membuat satu file tombol yang dapat dipanggil di puluhan halaman berbeda dengan gaya dan fungsi yang konsisten. Konsep arsitektur ini disebut?',
                        'options' => [
                            'A. Single Page Application',
                            'B. Component Reusability (Komponen Reusable)',
                            'C. State Management'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Sebuah dashboard SaaS memiliki data keranjang belanja yang harus diakses oleh header, halaman detail produk, dan halaman checkout. Pendekatan pengelolaan data apa yang paling tepat digunakan?',
                        'options' => [
                            'A. State Management Terpusat (seperti Redux, Zustand, atau Vuex).',
                            'B. Menyimpan data di file CSS.',
                            'C. Menyalin data manual ke file HTML masing-masing.'
                        ],
                        'correct' => 0
                    ],
                    [
                        'question' => 'Saat membangun Single Page Application (SPA), mengapa navigasi antar halaman terasa instan dan tidak ada loading layar putih seperti website konvensional?',
                        'options' => [
                            'A. Karena SPA tidak menggunakan file JavaScript.',
                            'B. Karena browser memuat seluruh halaman web dari cache internet secara lokal.',
                            'C. Karena JavaScript menangani routing secara client-side tanpa memicu reload dokumen HTML dari server.'
                        ],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Dalam Vue.js, jika kita ingin membuat variabel reaktif yang nilainya otomatis memicu pembaruan tampilan ketika diubah di dalam script, pembungkus (wrapper) apa yang digunakan?',
                        'options' => [
                            'A. ref() atau reactive()',
                            'B. document.write()',
                            'C. let'
                        ],
                        'correct' => 0
                    ]
                ]
            ],
            [
                'step_number' => 5,
                'title' => 'Alat dan Teknik Pengembangan',
                'desc' => 'Menggunakan Git, GitHub, package manager (NPM), dan Chrome DevTools.',
                'side' => 'right',
                'icon' => '06',
                'content_title' => 'Meningkatkan Produktivitas dengan DevTools & Git',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Frontend Developer profesional harus menguasai ekosistem peralatan pengembangan. Menulis kode hanyalah separuh jalan; mengelola ketergantungan (dependencies), melacak riwayat perubahan kode (Git), dan melakukan debugging adalah keterampilan krusial.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Version Control dengan Git
                    </h3>
                    <p class="text-slate-600 leading-relaxed mb-4 font-medium">
                        Git memungkinkan tim developer bekerja pada basis kode yang sama tanpa saling menimpa pekerjaan satu sama lain. Melalui branch, tim dapat membagi tugas pengembangan fitur secara paralel sebelum digabungkan (merge) ke branch utama.
                    </p>

                    <!-- WIDGET INTERAKTIF 6 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interaktif: Git Commit Visualizer</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol langkah di bawah untuk menyimulasikan alur kerja Git dasar secara visual!</p>
                        <div class="flex gap-2 mb-4">
                            <button type="button" onclick="stepGitFlow(1)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer font-medium">1. git add .</button>
                            <button type="button" onclick="stepGitFlow(2)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer font-medium">2. git commit</button>
                            <button type="button" onclick="stepGitFlow(3)" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer font-medium">3. git push</button>
                        </div>
                        <div class="bg-slate-900 text-emerald-400 font-mono text-[10px] p-4 rounded-xl min-h-[80px] shadow-inner">
                            <div id="git-cli-output">> Ketuk langkah 1 untuk memulai simulasi terminal...</div>
                        </div>
                    </div>
                    <script>
                        window.stepGitFlow = function(step) {
                            const out = document.getElementById(\'git-cli-output\');
                            if (step === 1) {
                                out.innerHTML = \'<span>$ git add .</span><br><span class="text-slate-400">Menambahkan semua perubahan file lokal ke Staging Area. File siap dicommit.</span>\';
                            } else if (step === 2) {
                                out.innerHTML = \'<span>$ git commit -m "feat: tambahkan fitur quiz"</span><br><span class="text-slate-400">[main 44dd0b1] feat: tambahkan fitur quiz<br> 1 file changed, 45 insertions(+)</span>\';
                            } else if (step === 3) {
                                out.innerHTML = \'<span>$ git push origin main</span><br><span class="text-slate-400">Mengunggah commit lokal ke repositori remote di GitHub... Selesai! Halaman web siap dideploy.</span>\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    [
                        'question' => 'Sebelum melakukan deploy, Anda ingin memastikan kode terbaru di laptop Anda terunggah dengan aman ke repositori cloud GitHub. Urutan perintah Git dasar yang benar adalah?',
                        'options' => [
                            'A. git pull -> git merge -> git clone',
                            'B. git add . -> git commit -m "pesan" -> git push',
                            'C. git push -> git add -> git commit'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Website klien mengalami bug tata letak di perangkat iPhone 13. Anda tidak memiliki perangkat fisik tersebut. Fitur Chrome DevTools mana yang dapat membantu Anda melakukan debug awal?',
                        'options' => [
                            'A. Tab Console untuk mematikan javascript.',
                            'B. Fitur Device Mode Simulator (Toggle Device Toolbar) untuk menyimulasikan resolusi layar iPhone 13.',
                            'C. Panel Network untuk mempercepat download.'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Dalam proyek kolaborasi tim, Anda tidak sengaja menimpa file rekan kerja. Untuk membatalkan perubahan lokal Anda dan mengambil versi terakhir dari server, perintah Git apa yang digunakan?',
                        'options' => [
                            'A. git clone --force',
                            'B. git checkout -- . (atau git restore . ) setelah melakukan git fetch.',
                            'C. git init'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Mengapa developer menggunakan package manager seperti NPM atau Yarn saat membangun aplikasi web modern?',
                        'options' => [
                            'A. Untuk mengamankan sistem operasi dari virus komputer.',
                            'B. Untuk mencari lowongan pekerjaan di internet.',
                            'C. Untuk mempermudah instalasi, update, dan manajemen dependensi library eksternal dalam proyek.'
                        ],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Di Chrome DevTools, di tab/panel mana Anda dapat memantau request API yang gagal atau melihat durasi respon dari server?',
                        'options' => [
                            'A. Tab Network',
                            'B. Tab Elements',
                            'C. Tab Application'
                        ],
                        'correct' => 0
                    ]
                ]
            ],
            [
                'step_number' => 6,
                'title' => 'Deployment & Hosting',
                'desc' => 'Menerbitkan proyek web ke internet menggunakan Vercel, Netlify, atau GitHub Pages.',
                'side' => 'left',
                'icon' => '07',
                'content_title' => 'Menerbitkan Proyek Web ke Internet',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Menulis kode web yang berjalan di komputer lokal Anda hanyalah langkah awal. Langkah terakhir adalah menerbitkannya (deployment) ke server hosting agar dapat diakses oleh jutaan orang di seluruh dunia.
                    </p>
                    <div class="h-px bg-slate-200 my-6"></div>
                    <h3 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-5 bg-blue-500 rounded-full inline-block"></span>
                        Platform Deployment Modern
                    </h3>
                    <p class="text-slate-600 leading-relaxed mb-4 font-medium">
                        Jalur hosting modern sangat mudah digunakan. Layanan seperti <strong>Vercel</strong>, <strong>Netlify</strong>, dan <strong>GitHub Pages</strong> terintegrasi langsung dengan akun GitHub Anda. Ketika Anda mendorong perubahan ke GitHub (git push), server hosting otomatis menarik kode terbaru dan mendeploy-nya secara instan.
                    </p>

                    <!-- WIDGET INTERAKTIF 7 -->
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interaktif: Instant Cloud Deployment Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol awan di bawah untuk menyimulasikan proses deploy website Anda secara otomatis!</p>
                        <div id="deploy-zone" class="border-2 border-dashed border-slate-300 rounded-xl p-6 text-center cursor-pointer hover:bg-white hover:border-blue-500 transition-all flex flex-col items-center justify-center bg-white" onclick="startSimulatedDeploy()">
                            <div id="deploy-icon" class="text-3xl mb-2">☁️</div>
                            <div id="deploy-text" class="text-xs font-bold text-slate-600">Klik di sini untuk Deploy ke Cloud</div>
                            <div id="deploy-status" class="text-[10px] text-slate-400 mt-1 font-mono">Status: Idle</div>
                        </div>
                    </div>
                    <script>
                        window.startSimulatedDeploy = function() {
                            const zone = document.getElementById(\'deploy-zone\');
                            const text = document.getElementById(\'deploy-text\');
                            const status = document.getElementById(\'deploy-status\');
                            const icon = document.getElementById(\'deploy-icon\');
                            
                            zone.style.pointerEvents = \'none\';
                            icon.innerText = \'⚙️\';
                            icon.className = \'text-3xl mb-2 animate-spin\';
                            text.innerText = \'Menganalisis aset statis web...\';
                            status.innerText = \'Status: Building...\';
                            
                            setTimeout(() => {
                                text.innerText = \'Mengunggah ke jaringan CDN global...\';
                                status.innerText = \'Status: Uploading assets (60%)...\';
                            }, 1000);
                            
                            setTimeout(() => {
                                text.innerText = \'Mengonfigurasi subdomain SSL gratis...\';
                                status.innerText = \'Status: Configuring Domain...\';
                            }, 2000);

                            setTimeout(() => {
                                icon.innerText = \'🚀\';
                                icon.className = \'text-3xl mb-2\';
                                text.innerHTML = \'<span class="text-emerald-600 font-bold">Deploy Berhasil!</span><br><span class="text-blue-600 underline text-xs">app-kamu.vercel.app</span>\';
                                status.innerText = \'Status: Live 🟢\';
                                zone.style.pointerEvents = \'auto\';
                            }, 3200);
                        }
                    </script>
                ',
                'quizzes' => [
                    [
                        'question' => 'Anda baru saja merampungkan landing page HTML/JS statis dan ingin mempublikasikannya secara online dalam 2 menit secara gratis. Platform hosting modern manakah yang paling sesuai untuk kebutuhan ini?',
                        'options' => [
                            'A. Vercel atau Netlify',
                            'B. Docker Registry',
                            'C. PostgreSQL Cloud Database'
                        ],
                        'correct' => 0
                    ],
                    [
                        'question' => 'Setiap kali developer melakukan push commit baru ke branch main, website live otomatis terupdate tanpa perlu upload manual. Konsep otomatisasi deployment ini dikenal sebagai?',
                        'options' => [
                            'A. Database Backup',
                            'B. CI/CD (Continuous Integration / Continuous Deployment)',
                            'C. Version Control System'
                        ],
                        'correct' => 1
                    ],
                    [
                        'question' => 'Untuk memudahkan pengguna mengakses website, Anda menghubungkan alamat server IP 192.168.1.1 dengan nama domain komersial seperti tokoku.com. Layanan internet apa yang menerjemahkan ini?',
                        'options' => [
                            'A. DNS (Domain Name System)',
                            'B. HTTPS Protocol',
                            'C. FTP Client'
                        ],
                        'correct' => 0
                    ],
                    [
                        'question' => 'Bagaimana cara terbaik untuk melindungi privasi pengiriman data form (seperti password) dari penyadapan saat ditransmisikan antara browser pengguna dan server hosting?',
                        'options' => [
                            'A. Menggunakan protokol transfer FTP biasa.',
                            'B. Menyembunyikan form di halaman rahasia.',
                            'C. Memasang sertifikat SSL dan menggunakan protokol HTTPS.'
                        ],
                        'correct' => 2
                    ],
                    [
                        'question' => 'Mengapa file robots.txt sangat penting dikonfigurasi saat mendeploy website bisnis ke internet?',
                        'options' => [
                            'A. Untuk memberi tahu robot pencari (seperti Google Bot) halaman mana yang boleh dan tidak boleh diindeks.',
                            'B. Untuk menangani request error dari server.',
                            'C. Untuk mengatur resolusi gambar.'
                        ],
                        'correct' => 0
                    ]
                ]
            ]
        ];

        // Seed Frontend Path Modules
        $fePath = $paths['frontend'];
        foreach ($frontendModules as $mod) {
            $createdMod = Module::updateOrCreate(
                [
                    'path_id' => $fePath->id,
                    'step_number' => $mod['step_number']
                ],
                [
                    'title' => $mod['title'],
                    'desc' => $mod['desc'],
                    'side' => $mod['side'],
                    'icon' => $mod['icon'],
                    'content_title' => $mod['content_title'],
                    'content_body' => $mod['content_body']
                ]
            );

            // Seed Quizzes for the module
            foreach ($mod['quizzes'] as $q) {
                Quiz::updateOrCreate(
                    [
                        'module_id' => $createdMod->id,
                        'question' => $q['question']
                    ],
                    [
                        'options' => $q['options'],
                        'correct' => $q['correct']
                    ]
                );
            }
        }

        // Seed basic placeholder modules for the other 4 paths so they are fully functional
        $otherPaths = ['backend', 'uiux', 'fullstack', 'project-manager'];
        foreach ($otherPaths as $slug) {
            $p = $paths[$slug];
            
            // Generate 7 modules for each path
            for ($step = 0; $step < 7; $step++) {
                $createdMod = Module::updateOrCreate(
                    [
                        'path_id' => $p->id,
                        'step_number' => $step
                    ],
                    [
                        'title' => 'Modul ' . ($step + 1) . ': ' . $this->getModulePlaceholderTitle($slug, $step),
                        'desc' => 'Deskripsi detail materi ke-' . ($step + 1) . ' pada kurikulum ' . $p->title,
                        'side' => ($step % 2 == 0) ? 'left' : 'right',
                        'icon' => sprintf('%02d', $step + 1),
                        'content_title' => 'Pembahasan: ' . $this->getModulePlaceholderTitle($slug, $step),
                        'content_body' => '
                            <p class="text-[15px] leading-relaxed text-slate-600 mb-6 font-medium">
                                Selamat datang di modul pembelajaran <strong>' . $p->title . '</strong>. Di sesi ini, kita akan mendalami secara teoritis dan praktis tentang kompetensi inti bidang ini.
                            </p>
                            <h3 class="text-xl font-bold text-slate-900 mb-4 border-l-4 border-blue-600 pl-3">Kenapa ini Penting?</h3>
                            <p class="text-[15px] leading-relaxed text-slate-600 mb-4 font-medium">
                                Pemahaman materi pada modul ini sangat dibutuhkan di industri kerja nyata untuk meningkatkan produktivitas serta kolaborasi tim.
                            </p>
                            <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-4 text-xs text-blue-800 mb-6 font-medium">
                                💡 <strong>Tips Karir:</strong> Pastikan Anda mencoba studi kasus yang diberikan di akhir kuis untuk melatih pemecahan masalah (problem solving).
                            </div>
                        '
                    ]
                );

                // Seed 5 standard quizzes related to the path type
                for ($qIdx = 0; $qIdx < 5; $qIdx++) {
                    Quiz::updateOrCreate(
                        [
                            'module_id' => $createdMod->id,
                            'question' => 'Studi Kasus ' . ($qIdx + 1) . ' di Bidang ' . $p->title . ': Bagaimana Anda menangani masalah performa atau manajemen rilis produk di dunia kerja?'
                        ],
                        [
                            'options' => [
                                'A. Melakukan evaluasi mendalam, koordinasi tim, dan menerapkan otomatisasi sesuai best practice.',
                                'B. Menghapus database utama untuk memulai ulang proyek.',
                                'C. Menunda pekerjaan dan menyalahkan tim lain.'
                            ],
                            'correct' => 0
                        ]
                    );
                }
            }
        }
    }

    private function getModulePlaceholderTitle(string $slug, int $step): string
    {
        $titles = [
            'backend' => [
                'Dasar-dasar Pemrograman Server',
                'Konsep HTTP, Routing & Controller',
                'Dasar Basis Data & SQL',
                'Implementasi Relasi Database',
                'Pembuatan RESTful API',
                'Keamanan API & JWT',
                'Deploy Backend & Cloud Computing'
            ],
            'uiux' => [
                'Pengenalan Desain Visual',
                'Memahami Layout & Tipografi',
                'Metode Design Thinking',
                'Riset Pengguna (User Research)',
                'Pembuatan Wireframe & User Flow',
                'Menguasai Figma & Komponen Reusable',
                'Usability Testing & Iterasi Desain'
            ],
            'fullstack' => [
                'HTML, CSS, JS Modern',
                'Responsive Design & UI Frameworks',
                'Version Control & Git Collaboration',
                'Frontend Libraries (React/Vue)',
                'Backend frameworks & REST API',
                'Integrasi Database & ORM',
                'Fullstack Deployment & CI/CD'
            ],
            'project-manager' => [
                'Pengenalan Manajemen Proyek',
                'Komunikasi & Kepemimpinan Tim',
                'Metode Agile & Scrum',
                'Requirements Gathering & User Stories',
                'Task Management & Timeline Planning',
                'Risk Management & Problem Solving',
                'Stakeholder Management & Quality Assurance'
            ]
        ];

        return $titles[$slug][$step] ?? 'Topik Lanjutan';
    }
}
