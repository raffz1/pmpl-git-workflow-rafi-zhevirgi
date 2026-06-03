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

        // 3. Seed Front End Modules
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
                            'A. Vercel or Netlify',
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

        // 4. Seed Backend Modules (Rich & Interactive)
        $backendModules = [
            [
                'step_number' => 0,
                'title' => 'Dasar Pemrograman Server',
                'desc' => 'Konsep Client-Server, bahasa pemrograman backend, dan manajemen request.',
                'side' => 'left',
                'icon' => '01',
                'content_title' => 'Pengenalan Pemrograman Server & Backend',
                'content_body' => '
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-6 font-medium">
                        Backend Development berfokus pada logika di balik layar yang menggerakkan website. Ketika pengguna melakukan login, melakukan pencarian, atau berbelanja, browser (client) mengirimkan <strong>HTTP Request</strong> ke komputer server. Server memproses data tersebut, berinteraksi dengan database, dan mengembalikan <strong>HTTP Response</strong>.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">HTTP Request/Response Simulator</h4>
                        <p class="text-xs text-slate-500 mb-4">Simulasikan pengiriman HTTP request ke server backend dengan mengklik tombol di bawah!</p>
                        <button type="button" onclick="sendSimulatedRequest()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition-all cursor-pointer">Kirim GET Request</button>
                        <div id="request-preview-box" class="mt-4 p-4 bg-slate-900 text-emerald-400 font-mono text-[10px] rounded-xl hidden min-h-[80px]"></div>
                    </div>
                    <script>
                        window.sendSimulatedRequest = function() {
                            const box = document.getElementById(\'request-preview-box\');
                            box.classList.remove(\'hidden\');
                            box.innerHTML = \'<span class="text-blue-400">> GET /api/v1/user HTTP/1.1</span><br><span class="text-blue-400">> Host: api.pathdeck.com</span><br><span class="text-slate-400">Loading server response...</span>\';
                            
                            setTimeout(() => {
                                box.innerHTML = \'<span class="text-blue-400">> GET /api/v1/user HTTP/1.1</span><br><span class="text-blue-400">> Host: api.pathdeck.com</span><br><br><span class="text-emerald-400">&lt; HTTP/1.1 200 OK</span><br><span class="text-emerald-400">&lt; Content-Type: application/json</span><br><span class="text-yellow-400">&lt; JSON Data: { "status": "success", "user": { "id": 101, "name": "Budi" } }</span>\';
                            }, 1200);
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Manakah dari pernyataan berikut yang menjelaskan perbedaan utama arsitektur Client-Server?', 'options' => ['A. Client merender antarmuka pengguna sedangkan Server menyimpan database dan memproses data bisnis.', 'B. Client menyimpan database sedangkan Server merender HTML saja.', 'C. Client dan Server adalah komponen yang sama dalam sirkuit CPU.'], 'correct' => 0],
                    ['question' => 'Ketika pengguna menekan tombol \'Beli Sekarang\', data dikirimkan menggunakan protokol HTTP. Metode HTTP mana yang paling tepat digunakan untuk mengirimkan data pemesanan baru?', 'options' => ['A. GET', 'B. POST', 'C. DELETE'], 'correct' => 1],
                    ['question' => 'Komponen server manakah yang secara langsung bertugas mendengarkan port HTTP (seperti port 80 atau 443) dan meneruskan request ke aplikasi backend?', 'options' => ['A. Web Server (seperti Nginx atau Apache)', 'B. Database Client', 'C. Cache Driver'], 'correct' => 0],
                    ['question' => 'Di industri, mengapa penting merancang backend dengan arsitektur non-blocking I/O pada sistem real-time chat?', 'options' => ['A. Agar server dapat menangani ribuan koneksi bersamaan tanpa memblokir proses lainnya.', 'B. Untuk menghemat ruang Hard Disk.', 'C. Agar CSS browser dapat dirender lebih cepat.'], 'correct' => 0],
                    ['question' => 'Manakah di bawah ini yang merupakan bahasa pemrograman yang umum digunakan untuk menulis program sisi server (Backend)?', 'options' => ['A. HTML dan CSS', 'B. PHP, Node.js, Python, dan Go', 'C. Swift dan Kotlin saja'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 1,
                'title' => 'HTTP, Routing & Controller',
                'desc' => 'Memahami REST Methods, penanganan URL routing, dan pemrosesan logika controller.',
                'side' => 'right',
                'icon' => '02',
                'content_title' => 'HTTP Methods, Routing, dan MVC Controller',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Untuk menghubungkan URL dengan logika server, kita menggunakan konsep <strong>Routing</strong>. Di Laravel atau Node.js, router akan mengarahkan request ke file <strong>Controller</strong> yang sesuai untuk memproses data.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interactive: HTTP Route Method Mapper</h4>
                        <p class="text-xs text-slate-500 mb-3">Pilih HTTP Method di bawah ini untuk melihat contoh URL dan peran controller!</p>
                        <select id="route-method-select" onchange="showRouteInfo()" class="w-full px-4 py-2 border border-slate-200 rounded-xl text-xs bg-white focus:outline-none focus:border-blue-500 mb-3">
                            <option value="">-- Pilih Method --</option>
                            <option value="get">GET /posts</option>
                            <option value="post">POST /posts</option>
                            <option value="put">PUT /posts/{id}</option>
                            <option value="delete">DELETE /posts/{id}</option>
                        </select>
                        <div id="route-info-desc" class="p-4 bg-white border border-slate-150 rounded-xl text-xs text-slate-600 leading-relaxed font-mono min-h-[50px] shadow-sm">
                            Pilih method untuk simulasi kode routing...
                        </div>
                    </div>
                    <script>
                        window.showRouteInfo = function() {
                            const val = document.getElementById(\'route-method-select\').value;
                            const desc = document.getElementById(\'route-info-desc\');
                            if (val === \'get\') {
                                desc.innerHTML = \'<strong>Route::get("/posts", [PostController::class, "index"]);</strong><br><span class="text-slate-500">Aksi: Menampilkan daftar postingan dari database ke pengguna.</span>\';
                            } else if (val === \'post\') {
                                desc.innerHTML = \'<strong>Route::post("/posts", [PostController::class, "store"]);</strong><br><span class="text-slate-500">Aksi: Membuat postingan baru dengan data request dari form body.</span>\';
                            } else if (val === \'put\') {
                                desc.innerHTML = \'<strong>Route::put("/posts/{id}", [PostController::class, "update"]);</strong><br><span class="text-slate-500">Aksi: Mengubah/memperbarui data postingan spesifik berdasarkan ID.</span>\';
                            } else if (val === \'delete\') {
                                desc.innerHTML = \'<strong>Route::delete("/posts/{id}", [PostController::class, "destroy"]);</strong><br><span class="text-slate-500">Aksi: Menghapus postingan spesifik dari database.</span>\';
                            } else {
                                desc.innerText = \'Pilih method untuk simulasi kode routing...\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Protokol HTTP mendefinisikan beberapa metode request. Manakah yang bersifat idempotent (artinya request berkali-kali memberikan hasil state server yang sama)?', 'options' => ['A. POST', 'B. GET dan PUT', 'C. PATCH saja'], 'correct' => 1],
                    ['question' => 'Sebuah endpoint API dirancang untuk memperbarui alamat email user secara parsial. Metode HTTP manakah yang paling sesuai?', 'options' => ['A. PATCH', 'B. GET', 'C. POST'], 'correct' => 0],
                    ['question' => 'Di framework Model-View-Controller (MVC), komponen manakah yang bertanggung jawab mengambil data dari database dan menyerahkannya ke View?', 'options' => ['A. Controller', 'B. Model', 'C. Web Server'], 'correct' => 0],
                    ['question' => 'Mengapa routing parameter seperti /users/{id} harus diverifikasi tipenya (misal regex numeric) di level router?', 'options' => ['A. Untuk mencegah serangan SQL Injection awal dan membatasi request sampah.', 'B. Agar tampilan CSS CSS Grid tidak pecah.', 'C. Karena browser tidak dapat memproses URL non-numeric.'], 'correct' => 0],
                    ['question' => 'Jika controller mengembalikan respon berupa JSON untuk integrasi mobile apps, status code HTTP manakah yang menandakan data berhasil dibuat (created)?', 'options' => ['A. 200 OK', 'B. 201 Created', 'C. 404 Not Found'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 2,
                'title' => 'Dasar Basis Data & SQL',
                'desc' => 'Menguasai tipe data database, struktur tabel, SQL queries (SELECT, INSERT, UPDATE, DELETE).',
                'side' => 'left',
                'icon' => '03',
                'content_title' => 'Query Data dengan Structured Query Language (SQL)',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Database adalah tempat penyimpanan permanen data aplikasi. Relational Database Management System (RDBMS) seperti MySQL, PostgreSQL, dan SQLite menggunakan bahasa SQL untuk memanipulasi data.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Live SQL Editor Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Pilih query SQL di bawah ini untuk melihat simulasi output data tabelnya secara instan!</p>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <button type="button" onclick="runSqlSim(\'select\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">SELECT * FROM users</button>
                            <button type="button" onclick="runSqlSim(\'where\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">SELECT ... WHERE role = \'admin\'</button>
                        </div>
                        <div id="sql-sim-output" class="p-4 bg-slate-900 text-emerald-400 font-mono text-[10px] rounded-xl min-h-[60px] shadow-inner">
                            Klik salah satu query di atas untuk memuat data simulasi database...
                        </div>
                    </div>
                    <script>
                        window.runSqlSim = function(queryType) {
                            const out = document.getElementById(\'sql-sim-output\');
                            if (queryType === \'select\') {
                                out.innerHTML = \'<table class="w-full text-left"><thead><tr><th>id</th><th>name</th><th>role</th></tr></thead><tbody><tr><td>1</td><td>Budi</td><td>student</td></tr><tr><td>2</td><td>Ani</td><td>admin</td></tr></tbody></table>\';
                            } else {
                                out.innerHTML = \'<table class="w-full text-left"><thead><tr><th>id</th><th>name</th><th>role</th></tr></thead><tbody><tr><td>2</td><td>Ani</td><td>admin</td></tr></tbody></table>\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Dalam SQL, klausa mana yang digunakan untuk memfilter baris hasil berdasarkan kriteria tertentu?', 'options' => ['A. GROUP BY', 'B. WHERE', 'C. ORDER BY'], 'correct' => 1],
                    ['question' => 'Kita ingin mengurutkan daftar produk dari yang paling mahal ke paling murah. Perintah SQL mana yang benar?', 'options' => ['A. ORDER BY price DESC', 'B. ORDER BY price ASC', 'C. SORT BY price HIGHEST'], 'correct' => 0],
                    ['question' => 'Atribut tabel manakah yang memastikan bahwa tidak boleh ada dua baris data dengan nilai kolom yang sama (misal alamat email)?', 'options' => ['A. UNIQUE CONSTRAINT', 'B. FOREIGN KEY', 'C. NOT NULL'], 'correct' => 0],
                    ['question' => 'Sebagai Backend Engineer, Anda menemukan bahwa kueri SELECT pada tabel orders dengan 10 juta data memakan waktu 5 detik. Optimasi dasar apa yang wajib Anda lakukan?', 'options' => ['A. Membuat Index pada kolom pencarian (seperti customer_id).', 'B. Menghapus data orders yang lama.', 'C. Mengonversi database ke file excel.'], 'correct' => 0],
                    ['question' => 'Fungsi agregasi SQL manakah yang digunakan untuk menghitung jumlah total baris dalam sebuah tabel?', 'options' => ['A. SUM()', 'B. COUNT()', 'C. TOTAL()'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 3,
                'title' => 'Implementasi Relasi Database',
                'desc' => 'Merancang relasi One-to-One, One-to-Many, Many-to-Many, dan foreign key constraints.',
                'side' => 'right',
                'icon' => '04',
                'content_title' => 'Merancang Relasi Data yang Optimal',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Data di dunia nyata saling berhubungan. RDBMS memungkinkan kita menghubungkan tabel dengan <strong>Foreign Key</strong>. Tiga jenis relasi utama adalah: One-to-One, One-to-Many, dan Many-to-Many.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Relational DB Visualizer</h4>
                        <p class="text-xs text-slate-500 mb-4">Visualisasi hubungan One-to-Many antara tabel Users dan tabel Posts.</p>
                        <div class="flex justify-between items-center gap-4 bg-white p-4 rounded-xl border border-slate-150 text-xs">
                            <div class="border border-blue-200 p-3 rounded-lg bg-blue-50/50">
                                <strong>users Table</strong><br>
                                <span class="text-slate-400">id (PK): 1</span><br>
                                <span>name: Budi</span>
                            </div>
                            <div class="text-slate-400 text-lg">🔗 1 ke N</div>
                            <div class="border border-emerald-200 p-3 rounded-lg bg-emerald-50/50">
                                <strong>posts Table</strong><br>
                                <span class="text-slate-400">id (PK): 50</span><br>
                                <span class="text-blue-500 font-bold">user_id (FK): 1</span><br>
                                <span>title: Belajar SQL</span>
                            </div>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Dalam merancang database e-commerce, satu user dapat memiliki banyak transaksi belanja (orders), namun satu transaksi belanja hanya dimiliki oleh satu user. Jenis relasi apakah ini?', 'options' => ['A. One-to-One', 'B. One-to-Many', 'C. Many-to-Many'], 'correct' => 1],
                    ['question' => 'Untuk menghubungkan relasi Many-to-Many antara tabel mahasiswa (students) dan mata kuliah (courses), apa langkah wajib yang harus dilakukan desainer database?', 'options' => ['A. Menambahkan kolom array di tabel students.', 'B. Membuat tabel perantara (pivot/junction table) yang berisi foreign key students_id dan courses_id.', 'C. Menghapus database dan menjadikannya NoSQL.'], 'correct' => 1],
                    ['question' => 'Apa kegunaan dari opsi "ON DELETE CASCADE" pada definisi foreign key?', 'options' => ['A. Mencegah user menghapus data induk.', 'B. Otomatis menghapus data anak (child rows) saat data induk (parent row) dihapus.', 'C. Mempercepat query SELECT.'], 'correct' => 1],
                    ['question' => 'Dalam kasus pencatatan profil tambahan user (seperti alamat lengkap detail) yang hanya ada maksimal 1 per user, jenis relasi mana yang paling tepat?', 'options' => ['A. One-to-One', 'B. Many-to-Many', 'C. Polymorphic relation'], 'correct' => 0],
                    ['question' => 'Perintah SQL JOIN manakah yang mengembalikan seluruh data dari tabel sebelah kiri meskipun tidak ada data yang cocok di tabel sebelah kanan?', 'options' => ['A. INNER JOIN', 'B. LEFT JOIN', 'C. RIGHT JOIN'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 4,
                'title' => 'Pembuatan RESTful API',
                'desc' => 'Format JSON, status codes, REST architecture standards, dan request validation.',
                'side' => 'left',
                'icon' => '05',
                'content_title' => 'Arsitektur RESTful API',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        API (Application Programming Interface) menjembatani pertukaran data antar aplikasi berbeda. RESTful API menggunakan metode HTTP standard dan mengembalikan data dalam format <strong>JSON</strong>.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">API Response Code Tester</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol untuk melihat simulasi output status code REST API!</p>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <button type="button" onclick="testApiResponse(200)" class="px-2 py-1 bg-green-50 text-green-700 text-[10px] font-bold rounded-lg cursor-pointer">200 OK</button>
                            <button type="button" onclick="testApiResponse(400)" class="px-2 py-1 bg-amber-50 text-amber-700 text-[10px] font-bold rounded-lg cursor-pointer">400 Bad Request</button>
                            <button type="button" onclick="testApiResponse(404)" class="px-2 py-1 bg-rose-50 text-rose-700 text-[10px] font-bold rounded-lg cursor-pointer">404 Not Found</button>
                        </div>
                        <div id="api-response-val" class="p-3 bg-white border border-slate-200 rounded-xl text-xs leading-relaxed font-mono min-h-[50px]">
                            Pilih status code untuk melihat response...
                        </div>
                    </div>
                    <script>
                        window.testApiResponse = function(code) {
                            const val = document.getElementById(\'api-response-val\');
                            if (code === 200) {
                                val.innerHTML = \'<span class="text-green-600 font-bold">Status: 200 OK</span><br>{ "success": true, "data": [] }\';
                            } else if (code === 400) {
                                val.innerHTML = \'<span class="text-amber-600 font-bold">Status: 400 Bad Request</span><br>{ "success": false, "error": "Email wajib diisi" }\';
                            } else if (code === 404) {
                                val.innerHTML = \'<span class="text-rose-600 font-bold">Status: 404 Not Found</span><br>{ "success": false, "error": "Resource tidak ditemukan" }\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Format standar apa yang paling umum digunakan dalam pertukaran data RESTful API saat ini karena ringan dan mudah dibaca oleh JavaScript?', 'options' => ['A. XML', 'B. JSON', 'C. YAML'], 'correct' => 1],
                    ['question' => 'Jika request data dari mobile browser tidak lolos validasi (misal password kurang dari 8 karakter), status code mana yang harus dikirimkan oleh server?', 'options' => ['A. 200 OK', 'B. 422 Unprocessable Entity (atau 400 Bad Request)', 'C. 500 Internal Server Error'], 'correct' => 1],
                    ['question' => 'Bagaimanakah format URL endpoint RESTful API yang baik untuk mengambil data buku (books) dengan ID spesifik 12?', 'options' => ['A. GET /get-books-by-id?id=12', 'B. GET /books/12', 'C. POST /books/detail/12'], 'correct' => 1],
                    ['question' => 'Untuk mengamankan API dari penyalahgunaan (misal spam request spam bot), teknik pembatasan jumlah request dalam kurun waktu tertentu disebut?', 'options' => ['A. CORS', 'B. Rate Limiting', 'C. Hashing'], 'correct' => 1],
                    ['question' => 'Header HTTP mana yang dikirimkan oleh client untuk memberi tahu server bahwa tipe konten yang dikirimkan adalah JSON?', 'options' => ['A. Accept: application/json', 'B. Content-Type: application/json', 'C. Authorization: Bearer token'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 5,
                'title' => 'Keamanan API & JWT',
                'desc' => 'Menerapkan Authentication, Hashing password, dan otentikasi JWT (JSON Web Token).',
                'side' => 'right',
                'icon' => '06',
                'content_title' => 'Otentikasi API Menggunakan JSON Web Token',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Keamanan adalah prioritas utama backend. Jangan pernah menyimpan password berupa teks biasa (plain text), melainkan lakukan <strong>Hashing</strong> (seperti bcrypt). Untuk otentikasi API stateless, kita menggunakan <strong>JWT (JSON Web Token)</strong>.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">JWT Token Decoder Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Visualisasi 3 bagian utama JWT: Header, Payload (Data), dan Signature.</p>
                        <div class="bg-white border border-slate-150 rounded-xl p-4 text-xs font-mono leading-relaxed space-y-2">
                            <div><span class="text-red-500 font-bold">eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9</span>.<span class="text-sky-500 font-bold">eyJ1c2VyX2lkIjoxMDEsIm5hbWUiOiJCdWRpIn0</span>.<span class="text-emerald-500 font-bold">signature_secret</span></div>
                            <div class="h-px bg-slate-100 my-2"></div>
                            <div class="text-[10px] text-slate-500">
                                <span class="text-red-500">■ Header:</span> Menentukan algoritma enkripsi (HS256)<br>
                                <span class="text-sky-500">■ Payload:</span> Data user { "user_id": 101, "name": "Budi" }<br>
                                <span class="text-emerald-500">■ Signature:</span> Kode verifikasi keamanan server
                            </div>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Mengapa backend developer dilarang keras menyimpan password dalam bentuk teks biasa (plain text) di database?', 'options' => ['A. Karena database tidak mendukung karakter khusus password.', 'B. Agar jika database bocor, penyerang tidak dapat langsung mengetahui password asli user.', 'C. Untuk menghemat memori penyimpanan database.'], 'correct' => 1],
                    ['question' => 'Manakah dari algoritma berikut yang dirancang khusus untuk satu arah (one-way hashing) password secara aman?', 'options' => ['A. Base64', 'B. bcrypt (atau Argon2)', 'C. AES-256'], 'correct' => 1],
                    ['question' => 'Struktur JSON Web Token (JWT) terdiri dari 3 bagian yang dipisahkan oleh tanda titik. Urutan bagian tersebut adalah?', 'options' => ['A. Header, Payload, Signature', 'B. Signature, Header, Payload', 'C. Payload, Signature, Secret'], 'correct' => 0],
                    ['question' => 'Saat frontend memanggil API terproteksi, di manakah token JWT tersebut biasanya disematkan dalam HTTP request?', 'options' => ['A. Atribut class tag HTML', 'B. HTTP Header dengan format "Authorization: Bearer <token>"', 'C. URL Query parameter saja'], 'correct' => 1],
                    ['question' => 'Jenis serangan web di mana penyerang menyelipkan script SQL berbahaya ke kolom input form login disebut?', 'options' => ['A. Cross-Site Scripting (XSS)', 'B. SQL Injection', 'C. Brute Force Attack'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 6,
                'title' => 'Deploy Backend & Cloud',
                'desc' => 'Mengunggah API ke VPS/Cloud, load balancing, SSL HTTPS, dan basis pemantauan log.',
                'side' => 'left',
                'icon' => '07',
                'content_title' => 'Deployment & Server Scaling',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Tahap akhir Backend Development adalah mendeploy aplikasi ke VPS (Virtual Private Server) atau Platform Cloud (seperti AWS, GCP, Heroku). Kita juga harus memasang <strong>SSL Certificate</strong> untuk HTTPS agar semua transmisi data terenkripsi.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Load Balancer Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol untuk menyimulasikan pembagian beban traffic server menggunakan Round Robin!</p>
                        <button type="button" onclick="simulateLoadBalancer()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl cursor-pointer mb-3">Kirim Request Traffic</button>
                        <div class="grid grid-cols-3 gap-2 text-center text-[10px] font-bold">
                            <div id="srv-1" class="border border-slate-200 p-2 rounded-xl bg-white">Server A<br><span id="srv-1-hits" class="text-blue-600">0 hits</span></div>
                            <div id="srv-2" class="border border-slate-200 p-2 rounded-xl bg-white">Server B<br><span id="srv-2-hits" class="text-blue-600">0 hits</span></div>
                            <div id="srv-3" class="border border-slate-200 p-2 rounded-xl bg-white">Server C<br><span id="srv-3-hits" class="text-blue-600">0 hits</span></div>
                        </div>
                    </div>
                    <script>
                        let activeSrv = 0;
                        const hits = [0, 0, 0];
                        window.simulateLoadBalancer = function() {
                            hits[activeSrv]++;
                            document.getElementById(\'srv-\' + (activeSrv + 1) + \'-hits\').innerText = hits[activeSrv] + \' hits\';
                            
                            // Visual feedback
                            const boxes = [document.getElementById(\'srv-1\'), document.getElementById(\'srv-2\'), document.getElementById(\'srv-3\')];
                            boxes.forEach(b => b.className = \'border border-slate-200 p-2 rounded-xl bg-white\');
                            boxes[activeSrv].className = \'border-2 border-emerald-500 p-2 rounded-xl bg-emerald-50/50 transition-all scale-105\';
                            
                            activeSrv = (activeSrv + 1) % 3;
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Saat traffic aplikasi melonjak tinggi, Anda mendistribusikan beban request ke 3 server backend berbeda secara merata. Komponen infrastruktur apa yang melakukan tugas ini?', 'options' => ['A. Load Balancer', 'B. CDN (Content Delivery Network)', 'C. Database Replica'], 'correct' => 0],
                    ['question' => 'Untuk memastikan file kode server tidak perlu disetup manual satu per satu di server cloud baru, teknologi containerization mana yang paling banyak digunakan saat ini?', 'options' => ['A. Kubernetes', 'B. Docker', 'C. VirtualBox'], 'correct' => 1],
                    ['question' => 'Aplikasi Anda sering kali macet karena RAM server penuh. Saat dicek, terdapat ribuan query database lambat yang dipanggil berulang-ulang. Metode optimasi caching memori apa yang paling tepat?', 'options' => ['A. Menggunakan Redis atau Memcached untuk menyimpan query response.', 'B. Menambah kapasitas SSD server.', 'C. Menghapus index tabel.'], 'correct' => 0],
                    ['question' => 'Log server Anda mencatat error HTTP status 502 Bad Gateway. Apakah arti dari error tersebut?', 'options' => ['A. Server proxy (seperti Nginx) gagal mendapatkan respon dari aplikasi backend server asal (seperti PHP-FPM).', 'B. Username dan password database salah.', 'C. Token login kedaluwarsa.'], 'correct' => 0],
                    ['question' => 'Port standard manakah yang digunakan untuk memproses request terenkripsi aman SSL/TLS (HTTPS)?', 'options' => ['A. Port 80', 'B. Port 443', 'C. Port 8080'], 'correct' => 1]
                ]
            ]
        ];

        // Seed Backend Path Modules
        $bePath = $paths['backend'];
        foreach ($backendModules as $mod) {
            $createdMod = Module::updateOrCreate(
                [
                    'path_id' => $bePath->id,
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

        // 5. Seed UI/UX Modules (Rich & Interactive)
        $uiuxModules = [
            [
                'step_number' => 0,
                'title' => 'Pengenalan Desain Visual',
                'desc' => 'Memahami teori warna, kontras, whitespace, dan prinsip dasar UI design.',
                'side' => 'left',
                'icon' => '01',
                'content_title' => 'Dasar Estetika dan Desain Visual UI',
                'content_body' => '
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-6 font-medium">
                        UI (User Interface) berfokus pada keindahan estetika digital. Sebagai perancang, Anda wajib memahami <strong>Contrast Ratio</strong> agar semua teks mudah dibaca oleh siapa saja, termasuk mereka yang memiliki gangguan penglihatan.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Contrast Ratio Checker</h4>
                        <p class="text-xs text-slate-500 mb-3">Ubah warna teks di bawah menggunakan slider untuk menguji kelayakan kontras visual (WCAG AA)!</p>
                        <input type="range" id="contrast-slider" min="0" max="255" value="180" oninput="updateContrastVisual()" class="w-full mb-3 cursor-pointer">
                        <div id="contrast-preview" class="p-4 rounded-xl text-center font-bold text-xs bg-white border border-slate-200" style="color: rgb(180, 180, 180);">
                            TEKS CONTOH DESAIN
                        </div>
                        <div id="contrast-status" class="text-[10px] text-slate-400 mt-2 font-mono">Status: Kontras Rendah (Gagal) ❌</div>
                    </div>
                    <script>
                        window.updateContrastVisual = function() {
                            const val = document.getElementById(\'contrast-slider\').value;
                            const preview = document.getElementById(\'contrast-preview\');
                            const status = document.getElementById(\'contrast-status\');
                            
                            preview.style.color = `rgb(${val}, ${val}, ${val})`;
                            
                            // Lower RGB values = darker = higher contrast against white background
                            if (val < 100) {
                                status.innerHTML = \'Status: Kontras Tinggi (Lolos WCAG AA) ✅\';
                            } else {
                                status.innerHTML = \'Status: Kontras Rendah (Gagal) ❌\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Mengapa konsep Whitespace (ruang kosong) sangat penting dalam tata letak desain UI mobile apps?', 'options' => ['A. Untuk menaruh iklan sebanyak mungkin.', 'B. Memberi ruang napas bagi mata pengguna dan memisahkan antar informasi penting agar tidak sumpek.', 'C. Karena server mewajibkan file gambar berukuran kecil.'], 'correct' => 1],
                    ['question' => 'Saat mendesain tombol utama (Primary Action Button) transaksi e-commerce, warna apa yang sebaiknya dihindari secara umum?', 'options' => ['A. Warna mencolok kontras tinggi (seperti biru/hijau/orange).', 'B. Warna abu-abu pucat (yang menyerupai status tombol disabled).', 'C. Warna putih bersih.'], 'correct' => 1],
                    ['question' => 'Prinsip desain visual yang mengatur urutan kepentingan elemen agar mata pengguna terarah ke informasi utama terlebih dahulu disebut?', 'options' => ['A. Visual Hierarchy', 'B. Grid System', 'C. Proximity'], 'correct' => 0],
                    ['question' => 'Menurut pedoman WCAG 2.1 AA, berapa rasio kontras minimum antara teks biasa dan latar belakangnya agar mudah dibaca?', 'options' => ['A. 1.5:1', 'B. 4.5:1', 'C. 10:1'], 'correct' => 1],
                    ['question' => 'Jenis tipografi font manakah yang memiliki dekorasi kait kecil di ujung karakter dan cocok digunakan untuk tema portal berita formal klasik?', 'options' => ['A. Serif', 'B. Sans-Serif', 'C. Monospace'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 1,
                'title' => 'Memahami Layout & Tipografi',
                'desc' => 'Prinsip Grid system, penyelarasan, kontras font, dan sistem ukuran tipografi.',
                'side' => 'right',
                'icon' => '02',
                'content_title' => 'Grid System dan Tata Letak Tipografi',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Tata letak yang terstruktur rapi memudahkan mata pengguna memindai konten (scanning). Kita menggunakan <strong>Grid System</strong> untuk konsistensi di berbagai ukuran layar.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Font Pairing Visualizer</h4>
                        <p class="text-xs text-slate-500 mb-3">Pilih tipe font di bawah untuk melihat perbedaan visual gaya layout!</p>
                        <div class="flex gap-2 mb-3">
                            <button type="button" onclick="changeFontPair(\'serif\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">Serif Style</button>
                            <button type="button" onclick="changeFontPair(\'sans\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">Sans-Serif Style</button>
                        </div>
                        <div id="font-preview-box" class="p-4 bg-white border border-slate-200 rounded-xl min-h-[60px] font-sans">
                            <h5 class="text-base font-bold mb-1">Judul Utama Modul</h5>
                            <p class="text-xs text-slate-500">Paragraf penjelas modul pembelajaran.</p>
                        </div>
                    </div>
                    <script>
                        window.changeFontPair = function(style) {
                            const box = document.getElementById(\'font-preview-box\');
                            if (style === \'serif\') {
                                box.style.fontFamily = \'Georgia, serif\';
                            } else {
                                box.style.fontFamily = \'system-ui, sans-serif\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Untuk mendesain antarmuka mobile apps, sistem grid kolom berapakah yang paling umum digunakan sebagai standar layout dasar?', 'options' => ['A. 12 Kolom', 'B. 4 Kolom', 'C. 1 Kolom saja'], 'correct' => 1],
                    ['question' => 'Bagaimana Anda mengatur kontras tipografi jika ingin membedakan antara sub-judul dan paragraf isi?', 'options' => ['A. Mengubah seluruh teks menjadi huruf besar.', 'B. Menggunakan ukuran font dan ketebalan (font-weight) yang berbeda secara terukur.', 'C. Mengganti jenis font di setiap baris.'], 'correct' => 1],
                    ['question' => 'Jarak vertikal antara baris-baris teks di dalam satu paragraf agar mudah dibaca disebut dengan istilah?', 'options' => ['A. Tracking', 'B. Leading (atau Line Height)', 'C. Kerning'], 'correct' => 1],
                    ['question' => 'Dalam menyusun kartu informasi produk, mengapa elemen foto, judul, dan harga diletakkan saling berdekatan (proximity)?', 'options' => ['A. Agar menghemat tempat.', 'B. Menyatakan secara visual bahwa elemen-elemen tersebut saling berhubungan erat sebagai satu kesatuan.', 'C. Karena template HTML mewajibkan demikian.'], 'correct' => 1],
                    ['question' => 'Manakah sistem grid responsif yang ideal untuk tata letak desktop?', 'options' => ['A. 12 Kolom', 'B. 8 Kolom', 'C. 4 Kolom'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 2,
                'title' => 'Metode Design Thinking',
                'desc' => 'Tahapan Empathize, Define, Ideate, Prototype, dan Test.',
                'side' => 'left',
                'icon' => '03',
                'content_title' => 'Design Thinking Framework',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Design Thinking adalah metode penyelesaian masalah yang berfokus pada empati terhadap pengguna. Kita harus memahami apa yang dipikirkan, dirasakan, dikatakan, dan dilakukan oleh pengguna.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interactive Empathy Map</h4>
                        <p class="text-xs text-slate-500 mb-3">Ketuk area di bawah untuk memahami isi Empathy Map!</p>
                        <div class="grid grid-cols-2 gap-2 text-center text-[10px] font-bold">
                            <div onclick="showEmpathyDesc(\'says\')" class="p-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-pink-50">SAYS (Katakan)</div>
                            <div onclick="showEmpathyDesc(\'thinks\')" class="p-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-pink-50">THINKS (Pikirkan)</div>
                            <div onclick="showEmpathyDesc(\'does\')" class="p-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-pink-50">DOES (Lakukan)</div>
                            <div onclick="showEmpathyDesc(\'feels\')" class="p-3 bg-white border border-slate-200 rounded-xl cursor-pointer hover:bg-pink-50">FEELS (Rasakan)</div>
                        </div>
                        <div id="empathy-desc-box" class="mt-3 p-3 bg-white border border-slate-150 rounded-xl text-xs text-slate-600 font-medium min-h-[40px]">
                            Ketuk quadrant untuk penjelasan detail...
                        </div>
                    </div>
                    <script>
                        window.showEmpathyDesc = function(q) {
                            const box = document.getElementById(\'empathy-desc-box\');
                            if (q === \'says\') {
                                box.innerText = \'SAYS: Teks wawancara langsung pengguna. Kutipan verbal yang jujur mengenai masalah aplikasi.\';
                            } else if (q === \'thinks\') {
                                box.innerText = \'THINKS: Apa yang dipikirkan pengguna diam-diam. Kekhawatiran tersembunyi mengenai keamanan data.\';
                            } else if (q === \'does\') {
                                box.innerText = \'DOES: Tindakan nyata pengguna saat menghadapi bug. Contoh: merefresh browser berulang kali.\';
                            } else if (q === \'feels\') {
                                box.innerText = \'FEELS: Emosi emosional pengguna. Contoh: Frustasi karena antarmuka checkout membingungkan.\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Tahapan pertama dalam metode Design Thinking yang mewajibkan desainer turun langsung ke lapangan mengamati perilaku target pengguna disebut?', 'options' => ['A. Define', 'B. Empathize', 'C. Ideate'], 'correct' => 1],
                    ['question' => 'Dalam proses Define, desainer merumuskan pernyataan masalah utama yang menggambarkan keluhan spesifik pengguna. Dokumen formulasi ini dinamakan?',
                     'options' => ['A. User Journey Map', 'B. Problem Statement (atau Point of View - POV)', 'C. User Story Card'], 'correct' => 1],
                    ['question' => 'Sebagai UX Designer, Anda mengumpulkan tim lintas bidang untuk melakukan brainstorming kilat dan menempelkan ide secara bebas di papan tulis. Tahap ini dinamakan?', 'options' => ['A. Define', 'B. Ideate', 'C. Test'], 'correct' => 1],
                    ['question' => 'Apa tujuan utama dari membuat Prototype sebelum menyerahkan desain akhir ke tim developer?', 'options' => ['A. Untuk menguji alur navigasi desain secara interaktif dengan biaya rendah tanpa menulis baris kode program.', 'B. Agar tim QA bisa langsung mendeploy software ke server.', 'C. Menghitung estimasi gaji tim designer.'], 'correct' => 0],
                    ['question' => 'Apakah proses Design Thinking bersifat linier sekali jalan selesai?', 'options' => ['A. Ya, setelah tahap Test semua siklus selesai.', 'B. Tidak, proses ini bersifat iteratif (bisa kembali ke tahap awal berdasarkan masukan pengujian user).', 'C. Ya, proses ini tidak boleh diulang.'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 3,
                'title' => 'Riset Pengguna (User Research)',
                'desc' => 'Menerapkan wawancara pengguna, kuesioner, pembuatan persona, dan pemetaan perjalanan pengguna.',
                'side' => 'right',
                'icon' => '04',
                'content_title' => 'Metodologi User Research',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Riset pengguna memastikan kita tidak merancang berdasarkan asumsi pribadi. Kita membuat <strong>User Persona</strong> sebagai representasi fiktif dari profil target pengguna utama kita.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">User Persona Cards Creator</h4>
                        <p class="text-xs text-slate-500 mb-3">Pilih tipe persona di bawah ini untuk memvisualisasikan data demografis riset!</p>
                        <div class="flex gap-2 mb-3">
                            <button type="button" onclick="showUserPersona(\'budi\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">Budi (Mahasiswa)</button>
                            <button type="button" onclick="showUserPersona(\'siti\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">Siti (Pekerja)</button>
                        </div>
                        <div id="persona-display-box" class="p-4 bg-white border border-slate-200 rounded-xl text-xs leading-relaxed text-slate-600">
                            Pilih tombol persona untuk memuat data riset...
                        </div>
                    </div>
                    <script>
                        window.showUserPersona = function(p) {
                            const box = document.getElementById(\'persona-display-box\');
                            if (p === \'budi\') {
                                box.innerHTML = \'<strong>Budi, 21 Tahun (Mahasiswa)</strong><br><span class="text-slate-400">Goals:</span> Belajar coding dengan cepat secara online.<br><span class="text-rose-500">Pain Point:</span> Website sering lag dan navigasi membingungkan.\';
                            } else {
                                box.innerHTML = \'<strong>Siti, 32 Tahun (Pekerja Kantoran)</strong><br><span class="text-slate-400">Goals:</span> Mengatur jadwal harian lewat aplikasi seluler.<br><span class="text-rose-500">Pain Point:</span> Pengisian form terlalu panjang dan melelahkan.\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'UX Researcher ingin mendapatkan data kuantitatif berupa rasio kepuasan pengguna terhadap checkout versi baru. Metode riset manakah yang paling sesuai?', 'options' => ['A. Wawancara mendalam tatap muka', 'B. Kuesioner Survey Online skala likert ke 500 pengguna', 'C. Focus Group Discussion (FGD)'], 'correct' => 1],
                    ['question' => 'Dokumen visual yang menggambarkan perjalanan langkah-langkah pengguna dari awal membuka aplikasi hingga berhasil membeli barang disebut?', 'options' => ['A. Wireframe Blueprint', 'B. User Journey Map (Peta Perjalanan Pengguna)', 'C. Database ER Diagram'], 'correct' => 1],
                    ['question' => 'Sebelum merancang, Anda mengelompokkan karakteristik fiktif dari profil target pengguna asli berdasarkan hasil riset lapangan. Kartu profil ini dinamakan?', 'options' => ['A. Customer Profiler', 'B. User Persona', 'C. Site Map'], 'correct' => 1],
                    ['question' => 'Metode riset di mana Anda mengamati langsung reaksi dan hambatan fisik pengguna saat mencoba menggunakan prototype desain Anda disebut?', 'options' => ['A. User Testing / Usability Observation', 'B. Desk Research', 'C. Market Analysis'], 'correct' => 0],
                    ['question' => 'Mengapa riset pengguna wajib dilakukan sebelum merancang layout aplikasi?', 'options' => ['A. Agar desain yang dibuat benar-benar menyelesaikan masalah nyata pengguna dan bukan asumsi desainer.', 'B. Agar biaya gaji developer lebih murah.', 'C. Karena browser membutuhkan file riset untuk compile CSS.'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 4,
                'title' => 'Wireframe & User Flow',
                'desc' => 'Membuat sketsa desain kasar (low-fidelity) dan memetakan alur navigasi aplikasi.',
                'side' => 'left',
                'icon' => '05',
                'content_title' => 'Pembuatan Wireframe dan Alur Pengguna',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Sebelum menggambar desain detail (High Fidelity), desainer harus membuat **Wireframe** (Low Fidelity) untuk memetakan tata letak informasi dan **User Flow** untuk memetakan alur navigasi layar demi layar.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interactive User Flow Builder</h4>
                        <p class="text-xs text-slate-500 mb-4">Urutan navigasi standar alur pembelian di web e-commerce.</p>
                        <div class="flex flex-col sm:flex-row justify-between items-center gap-3 bg-white p-4 rounded-xl border border-slate-150 text-[10px] font-bold">
                            <div class="p-2 border border-slate-200 rounded-lg bg-slate-50">1. Home Page</div>
                            <div class="text-slate-400">➜</div>
                            <div class="p-2 border border-blue-200 rounded-lg bg-blue-50 text-blue-600">2. Detail Produk</div>
                            <div class="text-slate-400">➜</div>
                            <div class="p-2 border border-emerald-200 rounded-lg bg-emerald-50 text-emerald-600">3. Checkout</div>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Mengapa desainer disarankan membuat sketsa hitam-putih (Low-Fidelity Wireframe) terlebih dahulu sebelum membuat mockup berwarna?', 'options' => ['A. Karena menggambar warna di komputer sangat lambat.', 'B. Agar tim fokus mengevaluasi struktur informasi dan alur navigasi tanpa terganggu oleh warna dan estetika visual.', 'C. Karena mesin cetak hanya mendukung warna hitam putih.'], 'correct' => 1],
                    ['question' => 'Sebuah diagram alur yang memetakan rentetan klik layar demi layar yang harus dilewati pengguna untuk mencapai satu tujuan (misal transfer uang) disebut?', 'options' => ['A. User Flow', 'B. Wireframe Layout', 'C. Gantt Chart'], 'correct' => 0],
                    ['question' => 'Simbol visual berupa tanda silang besar di dalam kotak pada gambar sketsa wireframe biasanya mempresentasikan elemen?', 'options' => ['A. Tombol submit', 'B. Gambar / Foto (Image Placeholder)', 'C. Paragraf teks'], 'correct' => 1],
                    ['question' => 'Bagaimanakah alur pengguna (User Flow) yang buruk bagi proses pendaftaran anggota baru?', 'options' => ['A. Pengisian formulir dibagi menjadi 3 tahap sederhana.', 'B. Pengguna dipaksa mengisi 30 kolom input di satu halaman panjang tanpa indikator progres.', 'C. Mengaktifkan fitur verifikasi OTP instan via WhatsApp.'], 'correct' => 1],
                    ['question' => 'Manakah alat yang paling populer untuk membuat wireframe digital interaktif?', 'options' => ['A. Figma', 'B. Microsoft Excel', 'C. Notepad++'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 5,
                'title' => 'Menguasai Figma & Prototyping',
                'desc' => 'Belajar menggunakan Autolayout, Component, Variant, dan transisi Smart Animate di Figma.',
                'side' => 'right',
                'icon' => '06',
                'content_title' => 'High Fidelity UI Mockup dan Prototyping di Figma',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Figma adalah alat desain standar industri. Untuk membuat desain yang konsisten dan mudah diintegrasikan oleh developer, desainer wajib menguasai fitur <strong>Component & Variants</strong>.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interactive UI Button State Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol untuk menyimulasikan status tombol (variants) di Figma!</p>
                        <div class="flex gap-2 mb-4">
                            <button type="button" onclick="setBtnState(\'default\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">Default State</button>
                            <button type="button" onclick="setBtnState(\'hover\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">Hover State</button>
                            <button type="button" onclick="setBtnState(\'disabled\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">Disabled State</button>
                        </div>
                        <div class="flex justify-center p-6 bg-white border border-slate-150 rounded-xl min-h-[60px]">
                            <button type="button" id="figma-btn-sim" class="px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-bold rounded-xl text-xs transition-all shadow-md cursor-pointer border-0">Variant: Default</button>
                        </div>
                    </div>
                    <script>
                        window.setBtnState = function(state) {
                            const btn = document.getElementById(\'figma-btn-sim\');
                            if (state === \'default\') {
                                btn.className = \'px-6 py-3 bg-pink-600 hover:bg-pink-700 text-white font-bold rounded-xl text-xs transition-all shadow-md cursor-pointer border-0\';
                                btn.innerText = \'Variant: Default\';
                            } else if (state === \'hover\') {
                                btn.className = \'px-6 py-3 bg-pink-700 text-white font-bold rounded-xl text-xs transition-all shadow-lg scale-105 cursor-pointer border-0\';
                                btn.innerText = \'Variant: Hover\';
                            } else {
                                btn.className = \'px-6 py-3 bg-slate-200 text-slate-400 font-bold rounded-xl text-xs transition-all cursor-not-allowed border-0\';
                                btn.innerText = \'Variant: Disabled\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Fitur di Figma yang secara otomatis mengatur jarak padding dan penataan dinamis tombol/kartu saat isi teksnya berubah disebut?', 'options' => ['A. Auto Layout', 'B. Smart Animate', 'C. Component Set'], 'correct' => 0],
                    ['question' => 'Anda mendesain ikon panah kembali yang akan digunakan di 50 halaman berbeda. Apa langkah terbaik agar ketika ikon diubah, seluruh 50 halaman terupdate otomatis?', 'options' => ['A. Membuat ikon tersebut menjadi Master Component.', 'B. Menduplikasi manual ikon tersebut di setiap halaman.', 'C. Menjadikannya gambar eksternal berekstensi JPEG.'], 'correct' => 0],
                    ['question' => 'Jenis transisi prototyping di Figma yang mendeteksi elemen serupa dan memberikan efek gerak transisi secara otomatis nan mulus disebut?', 'options' => ['A. Smart Animate', 'B. Instant Dissolve', 'C. Move In'], 'correct' => 0],
                    ['question' => 'Apakah peran Variants pada System Design di Figma?', 'options' => ['A. Mengelompokkan versi alternatif dari satu komponen yang sama (seperti status tombol: default, hover, active).', 'B. Mempersulit developer menulis kode CSS.', 'C. Menghitung jumlah layer desain.'], 'correct' => 0],
                    ['question' => 'Untuk mengekspor aset visual (seperti icon) agar ketajamannya tetap presisi di layar retina resolusi tinggi, format ekspor apa yang disarankan?', 'options' => ['A. SVG', 'B. JPEG', 'C. BMP'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 6,
                'title' => 'Usability Testing & Iterasi Desain',
                'desc' => 'Menguji coba prototype ke target pengguna asli, mengumpulkan feedback, dan perbaikan desain.',
                'side' => 'left',
                'icon' => '07',
                'content_title' => 'Usability Testing & Refinement',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Tahap akhir dari siklus UI/UX adalah **Usability Testing (UT)**. Kita meminta pengguna mencoba prototype dan mengamati pola klik mereka. Data UT ini digunakan untuk melakukan perbaikan tata letak desain secara berkala.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interactive UI Click Heatmap Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik di area mana saja pada box di bawah untuk menyimulasikan heatmap titik klik pengguna!</p>
                        <div id="heatmap-area" onclick="triggerHeatmapDot(event)" class="relative h-24 border border-slate-350 rounded-xl bg-slate-100 overflow-hidden cursor-crosshair flex items-center justify-center text-[10px] font-bold text-slate-400">
                            Klik di dalam box untuk menyebarkan data heatmap...
                        </div>
                    </div>
                    <script>
                        window.triggerHeatmapDot = function(e) {
                            const area = document.getElementById(\'heatmap-area\');
                            area.innerText = \'\';
                            const rect = area.getBoundingClientRect();
                            const x = e.clientX - rect.left;
                            const y = e.clientY - rect.top;
                            
                            const dot = document.createElement(\'div\');
                            dot.style.position = \'absolute\';
                            dot.style.left = (x - 6) + \'px\';
                            dot.style.top = (y - 6) + \'px\';
                            dot.style.width = \'12px\';
                            dot.style.height = \'12px\';
                            dot.style.backgroundColor = \'red\';
                            dot.style.borderRadius = \'50%\';
                            dot.style.opacity = \'0.7\';
                            dot.style.boxShadow = \'0 0 10px red\';
                            area.appendChild(dot);
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Saat melakukan Usability Testing, fasilitator memberikan serangkaian instruksi tugas tanpa menuntun klik user. Skenario petunjuk ini disebut?', 'options' => ['A. User Persona Story', 'B. Scenario-Based Task', 'C. Design Brief'], 'correct' => 1],
                    ['question' => 'Setelah UT selesai, Anda menemukan 8 dari 10 pengguna salah mengklik menu profil saat diminta mencari halaman keranjang belanja. Hasil temuan ini dikelompokkan sebagai?', 'options' => ['A. Usability Issue (Masalah Kebergunaan)', 'B. Bug Coding Server', 'C. Layout Estetika Biasa'], 'correct' => 0],
                    ['question' => 'Metode membandingkan 2 alternatif desain antarmuka (Desain A vs Desain B) ke 2 kelompok user berbeda secara live untuk melihat versi mana yang menghasilkan konversi pembelian tertinggi disebut?', 'options' => ['A. Usability Testing', 'B. A/B Testing', 'C. User Interview'], 'correct' => 1],
                    ['question' => 'Metrik UT yang mengukur persentase jumlah tugas yang berhasil diselesaikan secara mandiri oleh pengguna secara sukses dinamakan?', 'options' => ['A. Completion Rate (atau Task Success Rate)', 'B. Error Rate', 'C. Time-on-Task'], 'correct' => 0],
                    ['question' => 'Apakah tugas desainer UI/UX selesai sepenuhnya setelah aplikasi dideploy oleh developer?', 'options' => ['A. Ya, siklus desain berakhir.', 'B. Tidak, desainer terus memantau metrik perilaku user pasca-rilis untuk melakukan iterasi perbaikan desain berkelanjutan.', 'C. Ya, karena kode program sudah paten.'], 'correct' => 1]
                ]
            ]
        ];

        // Seed UI/UX Path Modules
        $uiuxPath = $paths['uiux'];
        foreach ($uiuxModules as $mod) {
            $createdMod = Module::updateOrCreate(
                [
                    'path_id' => $uiuxPath->id,
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

        // 6. Seed Full Stack Modules (Rich & Interactive)
        $fullstackModules = [
            [
                'step_number' => 0,
                'title' => 'HTML, CSS, JS Modern',
                'desc' => 'Menguasai sintaks ES6+, manipulasi data array, serta kerangka dasar integrasi DOM.',
                'side' => 'left',
                'icon' => '01',
                'content_title' => 'Sintaks ES6+ dan Pemrograman JavaScript Modern',
                'content_body' => '
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-6 font-medium">
                        Full Stack Developer harus menguasai bahasa Javascript di sisi client (browser) maupun server (Node.js). Memahami sintaks ES6+ seperti **Arrow Functions**, **Destructuring**, dan **Template Literals** sangat penting.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">ES5 vs ES6 Translator Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol untuk melihat simplifikasi penulisan kode JavaScript di versi ES6!</p>
                        <div class="flex gap-2 mb-3">
                            <button type="button" onclick="showEsDiff(\'es5\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">Gaya ES5 Lama</button>
                            <button type="button" onclick="showEsDiff(\'es6\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">Gaya ES6 Baru</button>
                        </div>
                        <pre id="es-code-box" class="p-4 bg-slate-900 text-sky-400 font-mono text-[10px] rounded-xl min-h-[50px] overflow-x-auto">
var kali = function(x, y) { return x * y; };
                        </pre>
                    </div>
                    <script>
                        window.showEsDiff = function(ver) {
                            const code = document.getElementById(\'es-code-box\');
                            if (ver === \'es5\') {
                                code.innerText = \'var kali = function(x, y) { return x * y; };\';
                            } else {
                                code.innerText = \'const kali = (x, y) => x * y;\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Manakah cara pendeklarasian variabel JavaScript ES6 yang nilainya tidak dapat di-reassign (diubah nilainya) selama program berjalan?', 'options' => ['A. var', 'B. const', 'C. let'], 'correct' => 1],
                    ['question' => 'Metode manipulasi array bawaan JS modern manakah yang paling tepat untuk menghasilkan array baru berisi data yang sudah difilter berdasarkan kriteria tertentu?', 'options' => ['A. array.map()', 'B. array.filter()', 'C. array.reduce()'], 'correct' => 1],
                    ['question' => 'Bagaimanakah cara menulis string concatenation menggunakan Template Literals di ES6 secara benar?', 'options' => ['A. `Hallo ${nama}`', 'B. "Hallo " + nama', "C. 'Hallo ' . \$nama"], 'correct' => 0],
                    ['question' => 'Untuk mengekstrak properti user_id dan username dari objek user secara ringkas di ES6, kita menggunakan teknik?', 'options' => ['A. Object Destructuring (seperti const { user_id, username } = user;)', 'B. JSON.stringify()', 'C. Object.keys()'], 'correct' => 0],
                    ['question' => 'Fungsi asynchronous JavaScript yang digunakan untuk menjeda eksekusi kode hingga Promise selesai diselesaikan adalah?', 'options' => ['A. await', 'B. defer', 'C. pause'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 1,
                'title' => 'Responsive Design & Frameworks',
                'desc' => 'Merancang grid responsif dengan CSS Vanilla, Flexbox, dan implementasi UI Kit.',
                'side' => 'right',
                'icon' => '02',
                'content_title' => 'Responsive Web Layout dan CSS Framework',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Aplikasi web harus dapat diakses dengan nyaman di HP, Tablet, maupun PC Desktop. Kita menggunakan **Viewport Media Queries** dan framework utilitas CSS.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Viewport Size Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol perangkat untuk menyimulasikan lebar container responsif!</p>
                        <div class="flex gap-2 mb-4">
                            <button type="button" onclick="setDeviceView(\'mobile\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">Mobile (360px)</button>
                            <button type="button" onclick="setDeviceView(\'tablet\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">Tablet (768px)</button>
                            <button type="button" onclick="setDeviceView(\'desktop\')" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold rounded-lg cursor-pointer">Desktop (1200px)</button>
                        </div>
                        <div id="device-container-sim" class="mx-auto bg-slate-200 border border-slate-300 rounded-xl p-4 text-center font-bold text-[10px] text-slate-600 transition-all duration-300 w-[100%] max-w-[100%]">
                            Layout Desktop Penuh (3 Kolom Berdampingan)
                        </div>
                    </div>
                    <script>
                        window.setDeviceView = function(device) {
                            const container = document.getElementById(\'device-container-sim\');
                            if (device === \'mobile\') {
                                container.className = \'mx-auto bg-slate-200 border border-slate-300 rounded-xl p-4 text-center font-bold text-[10px] text-slate-600 transition-all duration-300 w-[50%] max-w-[320px]\';
                                container.innerText = \'Layout Mobile (1 Kolom Vertikal Stack)\';
                            } else if (device === \'tablet\') {
                                container.className = \'mx-auto bg-slate-200 border border-slate-300 rounded-xl p-4 text-center font-bold text-[10px] text-slate-600 transition-all duration-300 w-[70%] max-w-[500px]\';
                                container.innerText = \'Layout Tablet (2 Kolom Grid)\';
                            } else {
                                container.className = \'mx-auto bg-slate-200 border border-slate-300 rounded-xl p-4 text-center font-bold text-[10px] text-slate-600 transition-all duration-300 w-[100%] max-w-[100%]\';
                                container.innerText = \'Layout Desktop Penuh (3 Kolom Berdampingan)\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Untuk membuat gambar bersifat responsif (mengikuti lebar kontainer induknya secara otomatis), CSS mana yang paling tepat disematkan?', 'options' => ['A. width: 100px; height: 100px;', 'B. max-width: 100%; height: auto;', 'C. object-fit: scale-down;'], 'correct' => 1],
                    ['question' => 'Mengapa konsep Mobile-First Design (merancang layout untuk mobile dulu baru scaling ke desktop) menjadi standar industri saat ini?', 'options' => ['A. Karena mayoritas traffic internet global saat ini diakses melalui perangkat smartphone.', 'B. Karena compiler JavaScript hanya mendukung file HTML versi mobile.', 'C. Menurunkan biaya sewa server.'], 'correct' => 0],
                    ['question' => 'Framework CSS yang terkenal dengan filosofi Utility-First (menyediakan class utilitas siap pakai seperti flex, pt-4, bg-red-500) adalah?', 'options' => ['A. Bootstrap', 'B. Tailwind CSS', 'C. Bulma'], 'correct' => 1],
                    ['question' => 'Tag meta viewport apa yang wajib disematkan di dalam tag &lt;head&gt; HTML agar browser mobile tidak memperkecil (zoom-out) halaman secara otomatis?', 'options' => ['A. &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;', 'B. &lt;meta content="no-zoom"&gt;', 'C. &lt;meta screen="responsive"&gt;'], 'correct' => 0],
                    ['question' => 'Bagaimanakah penulisan media query CSS untuk menerapkan warna background hitam hanya pada layar dengan lebar minimal 1024px (desktop)?', 'options' => ['A. @media (min-width: 1024px) { body { background: black; } }', 'B. @screen-desktop { body { background: black; } }', 'C. @media-only-desktop { background: black; }'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 2,
                'title' => 'Version Control & Git Collaboration',
                'desc' => 'Mengatasi merge conflicts, pull requests, git branch flow, dan kolaborasi tim.',
                'side' => 'left',
                'icon' => '03',
                'content_title' => 'Manajemen Cabang dan Kolaborasi Git',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Kolaborasi tim yang baik memerlukan pemahaman alur kerja Git (Git Branching Flow). Saat dua developer mengedit baris yang sama di file yang sama secara bersamaan, terjadilah **Merge Conflict**.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Merge Conflict Visualizer</h4>
                        <p class="text-xs text-slate-500 mb-4">Melihat tampilan penanda konflik di dalam file teks saat terjadi tabrakan baris kode.</p>
                        <pre class="p-4 bg-slate-900 text-rose-400 font-mono text-[9px] rounded-xl overflow-x-auto leading-relaxed">
<<<<<<< HEAD
const databaseURL = "http://localhost:3306";
=======
const databaseURL = "https://db.pathdeck.com";
>>>>>>> feature-prod-db
                        </pre>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Saat melakukan git merge, terminal menampilkan tulisan "CONFLICT (content): Merge conflict in server.js". Apa langkah pertama yang wajib Anda lakukan sebagai developer?', 'options' => ['A. Menghapus folder .git dan melakukan git init ulang.', 'B. Membuka file server.js, berdiskusi dengan rekan kerja untuk memilih baris kode yang benar, menghapus penanda konflik (<<<<<<<, =======, >>>>>>>), lakukan commit.', 'C. Mematikan laptop dan membiarkan project terbengkalai.'], 'correct' => 1],
                    ['question' => 'Untuk membuat cabang (branch) baru bernama "feature-login" sekaligus langsung berpindah ke branch tersebut, perintah Git mana yang digunakan?', 'options' => ['A. git switch -c feature-login (atau git checkout -b feature-login)', 'B. git branch feature-login', 'C. git merge feature-login'], 'correct' => 0],
                    ['question' => 'Setelah menyelesaikan fitur di branch lokal, fitur tersebut harus ditinjau (review) oleh lead engineer sebelum digabungkan ke server utama. Dokumen tinjauan ini di GitHub dinamakan?', 'options' => ['A. Merge Request / Pull Request', 'B. Issue Ticket', 'C. Release tag'], 'correct' => 0],
                    ['question' => 'Perintah Git mana yang digunakan untuk mengunduh kode terbaru dari repositori remote dan langsung menggabungkannya (auto-merge) dengan branch lokal Anda?', 'options' => ['A. git pull', 'B. git fetch', 'C. git status'], 'correct' => 0],
                    ['question' => 'Untuk melihat riwayat commit beserta deskripsi pesan commit yang pernah dibuat sebelumnya di repositori lokal, perintahnya adalah?', 'options' => ['A. git status', 'B. git log', 'C. git diff'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 3,
                'title' => 'Frontend Libraries (React/Vue)',
                'desc' => 'Menguasai component state, client-side routing, virtual DOM, dan siklus hidup komponen.',
                'side' => 'right',
                'icon' => '04',
                'content_title' => 'Stateful Components dan Library Frontend Modern',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Frontend modern didorong oleh arsitektur berbasis komponen reaktif. React menggunakan **Virtual DOM** untuk mempercepat rendering visual dengan cara membandingkan status rendering di memori sebelum memanipulasi DOM browser yang lambat.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">React Counter Hook Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Simulasikan state React dinamis yang reaktif!</p>
                        <div class="flex items-center gap-4 bg-white p-4 rounded-xl border border-slate-150">
                            <button type="button" onclick="reactIncrement()" class="px-4 py-2 bg-sky-500 hover:bg-sky-600 text-white text-xs font-bold rounded-xl border-0 cursor-pointer">setCount(count + 1)</button>
                            <span class="text-xs font-bold text-slate-700">count: <span id="react-counter-val" class="font-mono text-sm text-sky-500">0</span></span>
                        </div>
                    </div>
                    <script>
                        let count = 0;
                        window.reactIncrement = function() {
                            count++;
                            document.getElementById(\'react-counter-val\').innerText = count;
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Di React, hook manakah yang paling tepat digunakan untuk mendeklarasikan variable state lokal yang reaktif?', 'options' => ['A. useEffect', 'B. useState', 'C. useContext'], 'correct' => 1],
                    ['question' => 'Hook React manakah yang digunakan untuk menangani side-effects seperti memanggil data dari API (fetching data) saat komponen selesai dimuat (mounted)?', 'options' => ['A. useState', 'B. useEffect', 'C. useRef'], 'correct' => 1],
                    ['question' => 'Mengapa memodifikasi DOM browser secara langsung (seperti document.getElementById) tidak direkomendasikan saat bekerja dengan React?', 'options' => ['A. Karena hal itu mengabaikan Virtual DOM dan dapat merusak siklus sinkronisasi state UI React.', 'B. Karena browser memblokir perintah tersebut otomatis.', 'C. Karena CSS tidak mendukung selector ID di React.'], 'correct' => 0],
                    ['question' => 'Dalam arsitektur React, bagaimana cara mengirimkan data (variabel/fungsi) dari Komponen Induk (Parent) ke Komponen Anak (Child)?', 'options' => ['A. Menggunakan params routing.', 'B. Menggunakan properti (Props).', 'C. Menuliskannya di localstorage.'], 'correct' => 1],
                    ['question' => 'Format sintaks penulisan kode di React yang memungkinkan kita menulis kode HTML langsung di dalam JavaScript dinamakan?', 'options' => ['A. JSX', 'B. XML', 'C. JSON'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 4,
                'title' => 'Backend frameworks & REST API',
                'desc' => 'Membangun route API, validasi data request, koneksi database, dan handling request.',
                'side' => 'left',
                'icon' => '05',
                'content_title' => 'Membangun REST API dengan Framework Backend',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Backend frameworks seperti **Laravel** (PHP) atau **Express.js** (Node.js) mempercepat pembuatan API yang aman. MVC (Model View Controller) membantu memisahkan data (Model), logika bisnis (Controller), dan routing.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Model-View-Controller Interactions</h4>
                        <p class="text-xs text-slate-500 mb-3">Hubungan interaksi data pada pola MVC.</p>
                        <div class="bg-white border border-slate-150 p-4 rounded-xl text-[10px] text-slate-600 leading-relaxed font-mono">
                            <span class="text-blue-500">1. Client Request</span> ➜ Router ➜ <span class="text-emerald-500 font-bold">Controller</span><br>
                            <span class="text-emerald-500">2. Controller</span> memanggil ➜ <span class="text-purple-500 font-bold">Model (Database)</span><br>
                            <span class="text-purple-500">3. Model</span> mengembalikan data ke ➜ <span class="text-emerald-500">Controller</span><br>
                            <span class="text-emerald-500">4. Controller</span> merender respon ➜ <span class="text-orange-500 font-bold">View (JSON/HTML)</span>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Dalam framework MVC, komponen manakah yang berhubungan langsung dengan tabel basis data dan merepresentasikan struktur data?', 'options' => ['A. Controller', 'B. Model', 'C. View'], 'correct' => 1],
                    ['question' => 'Saat membangun endpoint REST API untuk membuat data transaksi baru, bagaimana cara mengamankan parameter agar tidak disabotase penyerang?', 'options' => ['A. Mengirimkan parameter melalui URL Query string.', 'B. Menerapkan skema validasi data request di sisi server sebelum diproses database.', 'C. Menghapus data transaksi lama.'], 'correct' => 1],
                    ['question' => 'Status Code HTTP manakah yang paling tepat dikirimkan server untuk memberi tahu client bahwa kredensial login (email/password) yang dimasukkan salah?', 'options' => ['A. 200 OK', 'B. 401 Unauthorized', 'C. 403 Forbidden'], 'correct' => 1],
                    ['question' => 'Untuk mencegah web API dari serangan brute force login, teknik middleware apa yang wajib diaktifkan?', 'options' => ['A. CORS Header filter', 'B. Rate Limiting (Throttle Middleware)', 'C. Hashing Token'], 'correct' => 1],
                    ['question' => 'Dalam Laravel, apa sebutan untuk class perantara yang dieksekusi sebelum request masuk ke controller (contoh: memverifikasi otentikasi login)?', 'options' => ['A. Seeder', 'B. Middleware', 'C. Controller Action'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 5,
                'title' => 'Integrasi Database & ORM',
                'desc' => 'Memahami ORM (Object Relational Mapping) untuk query basis data yang aman dan cepat.',
                'side' => 'right',
                'icon' => '06',
                'content_title' => 'Object Relational Mapping (ORM)',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        **ORM (Object Relational Mapping)** memungkinkan kita berinteraksi dengan database menggunakan objek bahasa pemrograman biasa tanpa perlu menulis query SQL mentah secara manual. Laravel menggunakan ORM **Eloquent**, sedangkan Node.js sering menggunakan **Sequelize** atau **Prisma**.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">SQL vs Eloquent ORM Translator</h4>
                        <p class="text-xs text-slate-500 mb-3">Pilih tipe query di bawah untuk melihat kemudahan penulisan ORM dibanding SQL biasa!</p>
                        <div class="flex gap-2 mb-3">
                            <button type="button" onclick="showOrmDiff(\'sql\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">SQL Query Mentah</button>
                            <button type="button" onclick="showOrmDiff(\'orm\')" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-lg cursor-pointer">Eloquent ORM (Laravel)</button>
                        </div>
                        <pre id="orm-code-box" class="p-4 bg-slate-900 text-emerald-400 font-mono text-[10px] rounded-xl min-h-[50px] overflow-x-auto">
SELECT * FROM users WHERE status = \'active\';
                        </pre>
                    </div>
                    <script>
                        window.showOrmDiff = function(type) {
                            const code = document.getElementById(\'orm-code-box\');
                            if (type === \'sql\') {
                                code.innerText = "SELECT * FROM users WHERE status = \'active\';";
                            } else {
                                code.innerText = "User::where(\'status\', \'active\')->get();";
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Mengapa ORM dinilai membantu mencegah kerentanan keamanan SQL Injection secara default dibanding SQL Query mentah yang ditulis manual dengan string concatenation?', 'options' => ['A. Karena ORM menyembunyikan database.', 'B. Karena ORM secara otomatis menggunakan parameter binding/prepared statement untuk memisahkan data dengan perintah SQL.', 'C. Karena ORM mematikan port database.'], 'correct' => 1],
                    ['question' => 'Dalam Laravel Eloquent, perintah mana yang digunakan untuk mendapatkan seluruh data dari tabel users?', 'options' => ['A. User::all()', 'B. User::get()', 'C. Keduanya benar'], 'correct' => 2],
                    ['question' => 'Dalam merancang migrasi database (migrations), apa manfaat utama dari memisahkan deklarasi schema tabel ke dalam file kode program?', 'options' => ['A. Agar database berjalan lebih cepat.', 'B. Memudahkan tim melakukan kolaborasi version control pada struktur database (database versioning).', 'C. Menghapus database otomatis saat error.'], 'correct' => 1],
                    ['question' => 'Untuk menghubungkan relasi model User ke model Post di mana satu user memiliki banyak postingan, metode relasi Eloquent mana yang dideklarasikan di User?', 'options' => ['A. belongsTo()', 'B. hasMany()', 'C. belongsToMany()'], 'correct' => 1],
                    ['question' => 'Di industri, masalah N+1 query sering memperlambat aplikasi. Teknik pengambilan data relasi mana yang wajib digunakan untuk meminimalisir kueri database (Eager Loading)?', 'options' => ['A. User::with(\'posts\')->get()', 'B. User::get() lalu loop post manual', 'C. User::all()'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 6,
                'title' => 'Fullstack Deployment & CI/CD',
                'desc' => 'Mengatur siklus integrasi otomatis, build script, hosting frontend, dan setup VPS server API.',
                'side' => 'left',
                'icon' => '07',
                'content_title' => 'Deployment & Continuous Integration / Deployment',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Full Stack Developer bertanggung jawab mendeploy seluruh aplikasi. Frontend dideploy ke CDN statis (seperti Vercel), sedangkan Backend API dideploy ke VPS/Cloud Server. Alur **CI/CD** mengotomatiskan pengujian dan perilisan.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">CI/CD Pipeline Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Klik tombol untuk menyimulasikan jalannya otomatisasi rilis pipeline!</p>
                        <button type="button" onclick="startPipelineSim()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-xl cursor-pointer mb-3">Jalankan Pipeline</button>
                        <div class="grid grid-cols-4 gap-1 text-center text-[8px] font-bold">
                            <div id="pipe-1" class="border border-slate-200 p-2 rounded-lg bg-white">1. LINT</div>
                            <div id="pipe-2" class="border border-slate-200 p-2 rounded-lg bg-white">2. TEST</div>
                            <div id="pipe-3" class="border border-slate-200 p-2 rounded-lg bg-white">3. BUILD</div>
                            <div id="pipe-4" class="border border-slate-200 p-2 rounded-lg bg-white">4. DEPLOY</div>
                        </div>
                    </div>
                    <script>
                        window.startPipelineSim = function() {
                            const p1 = document.getElementById(\'pipe-1\');
                            const p2 = document.getElementById(\'pipe-2\');
                            const p3 = document.getElementById(\'pipe-3\');
                            const p4 = document.getElementById(\'pipe-4\');
                            
                            p1.className = \'border border-slate-200 p-2 rounded-lg bg-white\';
                            p2.className = \'border border-slate-200 p-2 rounded-lg bg-white\';
                            p3.className = \'border border-slate-200 p-2 rounded-lg bg-white\';
                            p4.className = \'border border-slate-200 p-2 rounded-lg bg-white\';
                            
                            p1.className = \'border border-amber-500 p-2 rounded-lg bg-amber-50 animate-pulse\';
                            
                            setTimeout(() => {
                                p1.className = \'border border-emerald-500 p-2 rounded-lg bg-emerald-50 text-emerald-700\';
                                p2.className = \'border border-amber-500 p-2 rounded-lg bg-amber-50 animate-pulse\';
                            }, 1000);
                            
                            setTimeout(() => {
                                p2.className = \'border border-emerald-500 p-2 rounded-lg bg-emerald-50 text-emerald-700\';
                                p3.className = \'border border-amber-500 p-2 rounded-lg bg-amber-50 animate-pulse\';
                            }, 2000);
                            
                            setTimeout(() => {
                                p3.className = \'border border-emerald-500 p-2 rounded-lg bg-emerald-50 text-emerald-700\';
                                p4.className = \'border border-amber-500 p-2 rounded-lg bg-amber-50 animate-pulse\';
                            }, 3000);
                            
                            setTimeout(() => {
                                p4.className = \'border border-emerald-500 p-2 rounded-lg bg-emerald-50 text-emerald-700\';
                                alert(\'Pipeline Selesai! Aplikasi sukses live di server produksi.\');
                            }, 4200);
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Dalam proses rilis aplikasi, apa kepanjangan dari konsep CI/CD yang mengotomatiskan pengujian dan perilisan aplikasi?', 'options' => ['A. Code Integration / Code Development', 'B. Continuous Integration / Continuous Deployment', 'C. Control Index / Center Domain'], 'correct' => 1],
                    ['question' => 'Sebuah startup mengunggah file HTML/CSS statis ke layanan AWS S3, sedangkan backend API dijalankan di server VPS AWS EC2 terpisah. Keuntungan utama pemisahan ini adalah?', 'options' => ['A. Tidak memerlukan database lagi.', 'B. Hemat biaya hosting, meningkatkan keamanan rilis frontend, dan skalabilitas backend yang mandiri.', 'C. Menghilangkan bug coding CSS.'], 'correct' => 1],
                    ['question' => 'Untuk mencegah rahasia sensitif (seperti token API pihak ketiga atau database password) bocor ke repositori publik GitHub, di manakah variabel tersebut disimpan?', 'options' => ['A. Di dalam file .env (environment variables) yang didaftarkan ke .gitignore.', 'B. Ditulis langsung di file HTML.', 'C. Disimpan di cache browser.'], 'correct' => 0],
                    ['question' => 'Protokol enkripsi standar industri manakah yang wajib dikonfigurasi di server agar komunikasi data sensitif pengguna (seperti kartu kredit) aman dari penyadapan man-in-the-middle?', 'options' => ['A. FTP', 'B. SSL/TLS (HTTPS)', 'C. SMTP'], 'correct' => 1],
                    ['question' => 'Perintah CLI Docker mana yang digunakan untuk membangun file Blueprint container (Docker Image) dari instruksi Dockerfile?', 'options' => ['A. docker build', 'B. docker run', 'C. docker pull'], 'correct' => 0]
                ]
            ]
        ];

        // Seed Full Stack Path Modules
        $fsPath = $paths['fullstack'];
        foreach ($fullstackModules as $mod) {
            $createdMod = Module::updateOrCreate(
                [
                    'path_id' => $fsPath->id,
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

        // 7. Seed Project Manager Modules (Rich & Interactive)
        $pmModules = [
            [
                'step_number' => 0,
                'title' => 'Pengenalan Manajemen Proyek',
                'desc' => 'Memahami peran Project Manager, siklus proyek, dan triple constraints.',
                'side' => 'left',
                'icon' => '01',
                'content_title' => 'Konsep Triple Constraints Manajemen Proyek',
                'content_body' => '
                    <p class="text-[15px] leading-relaxed text-slate-600 mb-6 font-medium">
                        Project Manager bertanggung jawab mengawal proyek dari inisiasi hingga serah terima. Tiga kendala utama yang saling membatasi kesuksesan proyek adalah **Scope (Ruang Lingkup)**, **Time (Waktu)**, dan **Cost (Biaya)**.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Project Constraint Triangle Simulator</h4>
                        <p class="text-xs text-slate-500 mb-3">Geser slider di bawah untuk melihat bagaimana memperluas Ruang Lingkup (Scope) akan memaksa Biaya atau Waktu bertambah!</p>
                        <input type="range" id="scope-slider" min="1" max="3" value="1" oninput="updateConstraintSim()" class="w-full mb-3 cursor-pointer">
                        <div id="constraint-output" class="p-4 bg-white border border-slate-200 rounded-xl text-center text-xs font-bold text-slate-600">
                            Fitur Biasa (Scope Kecil) ➜ Waktu: Cepat (2 Minggu) | Biaya: Rendah
                        </div>
                    </div>
                    <script>
                        window.updateConstraintSim = function() {
                            const val = document.getElementById(\'scope-slider\').value;
                            const out = document.getElementById(\'constraint-output\');
                            if (val == 1) {
                                out.innerHTML = \'Fitur Biasa (Scope Kecil) ➜ Waktu: Cepat (2 Minggu) | Biaya: Rendah\';
                            } else if (val == 2) {
                                out.innerHTML = \'Tambah Fitur Sedang (Scope Medium) ➜ Waktu: Sedang (1 Bulan) | Biaya: Sedang\';
                            } else {
                                out.innerHTML = \'<span class="text-rose-600 font-extrabold">Aplikasi Kompleks (Scope Besar) ➜ Waktu: Lama (3 Bulan) | Biaya: Tinggi</span>\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Manakah di bawah ini yang mempresentasikan elemen dari konsep "Triple Constraints" dalam manajemen proyek?', 'options' => ['A. Scope, Time, dan Cost', 'B. Design, Code, dan Test', 'C. Salary, Office, dan Hardware'], 'correct' => 0],
                    ['question' => 'Di tengah jalan proyek, klien mendadak meminta tambahan 5 fitur besar tanpa mau menambah waktu tenggat rilis. Fenomena perluasan ruang lingkup tak terkontrol ini disebut?', 'options' => ['A. Gold Plating', 'B. Scope Creep', 'C. Risk Assessment'], 'correct' => 1],
                    ['question' => 'Dokumen resmi yang ditandatangani di awal proyek yang menyatakan proyek resmi dimulai, merinci ringkasan tujuan, dan menunjuk Project Manager disebut?', 'options' => ['A. Project Charter', 'B. Gantt Chart', 'C. WBS (Work Breakdown Structure)'], 'correct' => 0],
                    ['question' => 'Jika Anda memotong anggaran proyek (Cost Constraint) sebanyak 50% secara sepihak, manakah konsekuensi logis yang paling mungkin terjadi?', 'options' => ['A. Kualitas produk menurun atau waktu penyelesaian menjadi lebih lama.', 'B. Ruang lingkup (Scope) otomatis bertambah.', 'C. Developer bekerja lebih cepat.'], 'correct' => 0],
                    ['question' => 'Tahapan pertama dalam siklus hidup manajemen proyek sebelum perencanaan (Planning) dimulai adalah?', 'options' => ['A. Execution', 'B. Initiation', 'C. Closure'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 1,
                'title' => 'Komunikasi & Kepemimpinan Tim',
                'desc' => 'Manajemen stakeholder, matriks RACI, dan penyelesaian konflik dalam tim.',
                'side' => 'right',
                'icon' => '02',
                'content_title' => 'Komunikasi Stakeholder dan Matriks RACI',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Lebih dari 90% waktu Project Manager dihabiskan untuk berkomunikasi. Kita menggunakan **Matriks RACI** untuk memperjelas peran setiap anggota tim dalam tugas proyek.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interactive RACI Matrix Explanation</h4>
                        <p class="text-xs text-slate-500 mb-3">Pilih huruf RACI untuk melihat peran tanggung jawab dalam matriks kerja!</p>
                        <div class="flex justify-between gap-1 mb-3 text-center text-[10px] font-bold">
                            <div onclick="showRaci(\'R\')" class="p-2 border border-slate-200 bg-white rounded-lg cursor-pointer hover:bg-yellow-50">R (Responsible)</div>
                            <div onclick="showRaci(\'A\')" class="p-2 border border-slate-200 bg-white rounded-lg cursor-pointer hover:bg-yellow-50">A (Accountable)</div>
                            <div onclick="showRaci(\'C\')" class="p-2 border border-slate-200 bg-white rounded-lg cursor-pointer hover:bg-yellow-50">C (Consulted)</div>
                            <div onclick="showRaci(\'I\')" class="p-2 border border-slate-200 bg-white rounded-lg cursor-pointer hover:bg-yellow-50">I (Informed)</div>
                        </div>
                        <div id="raci-desc-box" class="p-4 bg-white border border-slate-150 rounded-xl text-xs text-slate-600 font-medium min-h-[40px]">
                            Ketuk tombol RACI di atas...
                        </div>
                    </div>
                    <script>
                        window.showRaci = function(type) {
                            const box = document.getElementById(\'raci-desc-box\');
                            if (type === \'R\') {
                                box.innerText = \'R - Responsible: Orang yang mengerjakan tugas secara fisik (cth: Programmer menulis kode).\';
                            } else if (type === \'A\') {
                                box.innerText = \'A - Accountable: Pengambil keputusan akhir yang memikul tanggung jawab penuh atas hasil tugas (cth: Project Manager).\';
                            } else if (type === \'C\') {
                                box.innerText = \'C - Consulted: Tenaga ahli yang dimintai pendapat/saran sebelum tugas diselesaikan (cth: UI/UX Expert).\';
                            } else if (type === \'I\') {
                                box.innerText = \'I - Informed: Stakeholder yang diberi tahu perkembangan hasil tugas (cth: Direktur / Client).\';
                            }
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Dalam matriks RACI, siapakah satu-satunya peran yang memegang wewenang pengambil keputusan akhir dan bertanggung jawab penuh atas hasil tugas tersebut?', 'options' => ['A. Responsible', 'B. Accountable', 'C. Informed'], 'correct' => 1],
                    ['question' => 'Dua orang senior developer berdebat keras tentang pemilihan bahasa backend (PHP vs Node.js). Apa langkah terbaik PM untuk meredam konflik ini?', 'options' => ['A. Memecat salah satu programmer.', 'B. Memediasi diskusi netral, membandingkan dampak bisnis (efisiensi, resource tim, resiko), dan mengambil keputusan objektif bersama.', 'C. Membiarkan mereka bertengkar sampai selesai.'], 'correct' => 1],
                    ['question' => 'Dalam rapat mingguan, tim QA melaporkan rilis tertunda karena server mati. Di matriks RACI, tim QA bertindak sebagai pihak yang melakukan pengujian. Peran QA dalam tugas pengujian ini adalah?', 'options' => ['A. Informed', 'B. Responsible', 'C. Accountable'], 'correct' => 1],
                    ['question' => 'Bagaimanakah cara terbaik untuk menjaga hubungan (stakeholder management) dengan klien yang sangat cerewet dan sering menuntut update harian?', 'options' => ['A. Tidak menjawab telepon klien.', 'B. Membuat laporan status berkala terstruktur secara transparan dan menyepakati jadwal meeting rutin di awal proyek.', 'C. Menuruti semua kemauan klien tanpa diskusi.'], 'correct' => 1],
                    ['question' => 'Berapa banyak orang yang boleh memegang peran Accountable (A) untuk satu tugas spesifik di matriks RACI agar tidak terjadi kekacauan tanggung jawab?', 'options' => ['A. Tepat 1 Orang', 'B. Minimal 2 Orang', 'C. Seluruh anggota tim'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 2,
                'title' => 'Metode Agile & Scrum',
                'desc' => 'Konsep Agile manifesto, alur kerja Scrum, sprint planning, daily standup, dan backlog.',
                'side' => 'left',
                'icon' => '03',
                'content_title' => 'Implementasi Agile dan Scrum Framework',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Agile adalah metodologi pengembangan berulang yang mengutamakan kolaborasi. **Scrum** adalah framework Agile yang membagi pekerjaan menjadi siklus waktu tetap (biasanya 2-4 minggu) disebut **Sprint**.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Scrum Velocity Calculator</h4>
                        <p class="text-xs text-slate-500 mb-3">Masukkan rata-rata poin sprint tim Anda untuk memperkirakan jumlah sprint yang dibutuhkan!</p>
                        <div class="flex gap-2 mb-3">
                            <input type="number" id="velocity-val" value="30" class="w-24 px-3 py-1.5 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500" placeholder="Poin/Sprint">
                            <button type="button" onclick="calcSprintEst()" class="px-4 py-1.5 bg-blue-600 hover:bg-blue-750 text-white text-xs font-bold rounded-lg cursor-pointer">Hitung Estimasi</button>
                        </div>
                        <div id="velocity-result" class="p-3 bg-white border border-slate-200 rounded-xl text-xs text-slate-600 font-medium">
                            Estimasi untuk backlog total 90 poin: 3 Sprint (Sekitar 6 Minggu)
                        </div>
                    </div>
                    <script>
                        window.calcSprintEst = function() {
                            const vel = parseInt(document.getElementById(\'velocity-val\').value) || 1;
                            const result = document.getElementById(\'velocity-result\');
                            const totalBacklog = 90;
                            const est = Math.ceil(totalBacklog / vel);
                            result.innerHTML = `Estimasi untuk backlog total 90 poin: <strong>${est} Sprint</strong> (Sekitar ${est * 2} Minggu)`;
                        }
                    </script>
                ',
                'quizzes' => [
                    ['question' => 'Rapat harian kilat berdurasi maksimal 15 menit di mana tim developer melaporkan apa yang dikerjakan kemarin, apa yang dikerjakan hari ini, dan kendala yang dihadapi disebut?', 'options' => ['A. Sprint Planning', 'B. Daily Standup Meeting', 'C. Retrospective'], 'correct' => 1],
                    ['question' => 'Siapakah anggota Scrum Team yang bertanggung jawab mengelola produk backlog, menyusun prioritas fitur berdasarkan nilai bisnis, dan memastikan tim membangun produk yang tepat?', 'options' => ['A. Scrum Master', 'B. Product Owner', 'C. Tech Lead'], 'correct' => 1],
                    ['question' => 'Pada akhir siklus Sprint, seluruh tim berkumpul untuk mengevaluasi internal proses kerja mereka: mencari tahu apa yang berjalan baik dan apa hambatan yang harus diperbaiki di sprint berikutnya. Rapat ini dinamakan?', 'options' => ['A. Sprint Review', 'B. Sprint Retrospective', 'C. Backlog Refinement'], 'correct' => 1],
                    ['question' => 'Dalam Agile, satuan estimasi tingkat kerumitan suatu tugas yang disepakati oleh tim developer saat planning disebut?', 'options' => ['A. Jam Kerja (Man-Hours)', 'B. Story Points', 'C. Kilobytes'], 'correct' => 1],
                    ['question' => 'Apakah tujuan utama dari diadakannya Sprint Planning di hari pertama siklus sprint?', 'options' => ['A. Membayar gaji tim.', 'B. Menentukan tujuan sprint (Sprint Goal) dan memilih daftar backlog yang berkomitmen diselesaikan dalam sprint tersebut.', 'C. Menghukum tim yang kerjanya lambat.'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 3,
                'title' => 'Requirements Gathering & User Stories',
                'desc' => 'Menulis user stories, kriteria penerimaan (acceptance criteria), dan memetakan requirement.',
                'side' => 'right',
                'icon' => '04',
                'content_title' => 'Dokumentasi Requirement dan User Stories',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Untuk meminimalisir salah paham antara klien dan tim developer, PM harus mendokumentasikan spesifikasi kebutuhan dalam bentuk **User Stories** yang dilengkapi dengan **Acceptance Criteria**.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">User Story Builder Template</h4>
                        <div class="bg-white border border-slate-150 p-4 rounded-xl text-xs font-mono leading-relaxed space-y-2">
                            <div><strong>Sebagai:</strong> <span class="text-blue-600">Pelanggan E-commerce</span></div>
                            <div><strong>Saya ingin:</strong> <span class="text-emerald-600">Membayar menggunakan e-wallet</span></div>
                            <div><strong>Agar:</strong> <span class="text-purple-600">Proses transaksi belanja lebih instan dan tidak perlu transfer manual</span></div>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Manakah dari opsi berikut yang mempresentasikan format penulisan User Story yang benar dan standar industri?', 'options' => ['A. Sebagai [Peran], Saya ingin [Tindakan], Agar [Manfaat]', 'B. Tolong buatkan fitur login dengan framework React.', 'C. Aplikasi harus berjalan lancar tanpa error di database.'], 'correct' => 0],
                    ['question' => 'Kondisi spesifik terukur yang wajib dipenuhi oleh developer agar fitur tersebut dinilai berhasil diselesaikan secara benar dan lolos pengujian disebut?', 'options' => ['A. Code Quality Check', 'B. Acceptance Criteria (Kriteria Penerimaan)', 'C. User Flow Diagram'], 'correct' => 1],
                    ['question' => 'Dalam kriteria penerimaan (Acceptance Criteria), format "Given-When-Then" sering digunakan. "Given" merepresentasikan?', 'options' => ['A. Prasyarat awal atau kondisi sebelum aksi dilakukan.', 'B. Hasil akhir yang diharapkan.', 'C. Tindakan yang memicu reaksi.'], 'correct' => 0],
                    ['question' => 'Klien meminta Anda membuat menu pencarian produk. Di mana Anda mencatat kriteria pencarian (misal: pencarian berdasarkan nama produk, kategori, dan brand)?', 'options' => ['A. Di dalam file konfigurasi database.', 'B. Di dalam lembar Acceptance Criteria pada User Story pencarian.', 'C. Di file CSS layout.'], 'correct' => 1],
                    ['question' => 'Karakteristik User Story yang baik disingkat dengan istilah INVEST. Huruf "E" dalam INVEST mewakili?', 'options' => ['A. Estimable (Dapat diperkirakan tingkat kerumitannya oleh tim developer)', 'B. Expensive', 'C. Easy'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 4,
                'title' => 'Task Management & Timeline Planning',
                'desc' => 'Membuat struktur WBS, menjadwalkan milestone, membuat Gantt chart, dan estimasi resource.',
                'side' => 'left',
                'icon' => '05',
                'content_title' => 'Struktur WBS dan Penjadwalan Proyek',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Untuk menyusun jadwal proyek, PM menggunakan **Work Breakdown Structure (WBS)** untuk memecah proyek besar menjadi unit-unit tugas kecil yang dapat dikelola. Jadwal divisualisasikan menggunakan **Gantt Chart**.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Interactive Gantt Chart Preview</h4>
                        <p class="text-xs text-slate-500 mb-4">Garis waktu (timeline) sederhana estimasi pengerjaan rilis produk.</p>
                        <div class="space-y-2 text-[10px] font-bold">
                            <div class="flex items-center gap-2">
                                <div class="w-16">Desain UI:</div>
                                <div class="flex-1 bg-pink-200 text-pink-700 p-1 rounded w-[40%]">Minggu 1-2</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-16">Coding:</div>
                                <div class="flex-1 bg-blue-200 text-blue-700 p-1 rounded w-[60%]" style="margin-left: 20%;">Minggu 2-4</div>
                            </div>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Struktur hierarki pemecahan proyek besar menjadi blok-blok tugas kecil yang mandiri dan terukur agar dapat ditugaskan ke personil tertentu disebut?', 'options' => ['A. Gantt Chart', 'B. Work Breakdown Structure (WBS)', 'C. Network Diagram'], 'correct' => 1],
                    ['question' => 'Garis waktu horizontal berupa diagram batang yang memvisualisasikan durasi pengerjaan tugas, hubungan ketergantungan antar tugas, dan milestone proyek dinamakan?', 'options' => ['A. Gantt Chart', 'B. Burndown Chart', 'C. Control Chart'], 'correct' => 0],
                    ['question' => 'Urutan tugas-tugas kritis di mana jika salah satu tugas di jalur ini terlambat 1 hari saja, maka seluruh tanggal rilis proyek otomatis mundur disebut?', 'options' => ['A. Fast Tracking', 'B. Critical Path (Jalur Kritis)', 'C. Slack Path'], 'correct' => 1],
                    ['question' => 'Sebelum coding dimulai, UI desainer harus menyelesaikan mockup. Hubungan ketergantungan tugas (dependency) ini dikategorikan sebagai?', 'options' => ['A. Finish-to-Start (FS)', 'B. Start-to-Start (SS)', 'C. Finish-to-Finish (FF)'], 'correct' => 0],
                    ['question' => 'Untuk melacak sisa pekerjaan yang harus diselesaikan dalam sprint berjalan di papan Kanban, grafik mana yang paling umum digunakan?', 'options' => ['A. Bar Chart', 'B. Burndown Chart', 'C. Pie Chart'], 'correct' => 1]
                ]
            ],
            [
                'step_number' => 5,
                'title' => 'Risk Management & Problem Solving',
                'desc' => 'Mengidentifikasi risiko proyek, membuat rencana mitigasi, dan problem solving.',
                'side' => 'right',
                'icon' => '06',
                'content_title' => 'Manajemen Risiko Proyek',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Risiko adalah ketidakpastian yang dapat berdampak buruk pada proyek. PM yang andal harus membuat **Daftar Risiko (Risk Register)** dan merencanakan **Mitigasi Risiko** sebelum masalah terjadi.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">Risk Matrix Planner</h4>
                        <p class="text-xs text-slate-500 mb-4">Pemetaan risiko berdasarkan Dampak (Impact) dan Probabilitas (Probability).</p>
                        <div class="grid grid-cols-2 gap-2 text-center text-[10px] font-bold">
                            <div class="p-3 bg-red-100 text-red-700 rounded-xl">Dampak Tinggi / Probabilitas Tinggi<br>❌ Mitigasi: Hindari / Atasi Segera</div>
                            <div class="p-3 bg-yellow-100 text-yellow-700 rounded-xl">Dampak Rendah / Probabilitas Rendah<br>ℹ️ Mitigasi: Pantau / Terima</div>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Dokumen hidup (living document) yang mencatat daftar semua risiko proyek, tingkat keparahan dampak, probabilitas kejadian, rencana mitigasi, dan pemilik risiko disebut?', 'options' => ['A. Risk Register', 'B. Project Charter', 'C. WBS Ledger'], 'correct' => 0],
                    ['question' => 'Server hosting utama memiliki resiko kebakaran 0.1%. Anda memutuskan untuk membeli cadangan server otomatis di cloud AWS (Backup). Strategi mitigasi resiko ini dikategorikan sebagai?', 'options' => ['A. Avoidance (Menghindari)', 'B. Mitigation / Transfer (Mengurangi / Mentransfer dampak)', 'C. Acceptance (Menerima apa adanya)'], 'correct' => 1],
                    ['question' => 'Di tengah jalan, programmer senior mengundurkan diri secara mendadak. Hambatan proyek yang sudah terjadi secara nyata ini bukan lagi disebut risiko (risk), melainkan?', 'options' => ['A. Constraint', 'B. Issue (Masalah Nyata)', 'C. Eventuality'], 'correct' => 1],
                    ['question' => 'Bagaimanakah cara terbaik untuk memitigasi risiko "Keterlambatan integrasi API pihak ketiga karena dokumentasi mereka kurang jelas"?', 'options' => ['A. Menulis API sendiri.', 'B. Melakukan uji coba integrasi (Spike Task) di awal proyek dan mengalokasikan waktu cadangan buffer di jadwal.', 'C. Menyalahkan pihak ketiga.'], 'correct' => 1],
                    ['question' => 'Metode analisis risiko yang mengalikan skor Dampak (Impact) dengan skor Probabilitas (Probability) untuk menentukan tingkat prioritas risiko disebut?', 'options' => ['A. Kuantitatif / Kualitatif Risk Analysis', 'B. Cost-Benefit Analysis', 'C. SWIFT Analysis'], 'correct' => 0]
                ]
            ],
            [
                'step_number' => 6,
                'title' => 'Stakeholder & Quality Assurance',
                'desc' => 'Mengelola ekspektasi klien, standar kualitas, rilis produk, dan User Acceptance Testing.',
                'side' => 'left',
                'icon' => '07',
                'content_title' => 'Quality Assurance dan User Acceptance Testing (UAT)',
                'content_body' => '
                    <p class="text-slate-600 leading-relaxed mb-6 font-medium">
                        Sebelum rilis ke pasar, produk harus melewati tahap **Quality Assurance (QA)** dan **User Acceptance Testing (UAT)**. UAT memverifikasi secara langsung bersama klien/pengguna akhir apakah produk telah sesuai dengan kebutuhan bisnis.
                    </p>
                    <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 my-6">
                        <h4 class="text-sm font-bold text-slate-800 mb-3">UAT Status Board</h4>
                        <p class="text-xs text-slate-500 mb-4">Board status penerimaan fitur oleh pengguna akhir.</p>
                        <div class="flex justify-between items-center gap-4 bg-white p-4 rounded-xl border border-slate-150 text-xs">
                            <div>Fitur Checkout E-Wallet:</div>
                            <div class="px-3 py-1 bg-emerald-500 text-white font-bold rounded-lg text-[10px]">Lolos UAT / Diterima (Signed-off)</div>
                        </div>
                    </div>
                ',
                'quizzes' => [
                    ['question' => 'Tahapan pengujian akhir di mana pengguna asli atau perwakilan klien mencoba menggunakan sistem secara langsung untuk memastikan kesesuaian kebutuhan bisnis sebelum rilis ditandatangani dinamakan?', 'options' => ['A. Unit Testing', 'B. User Acceptance Testing (UAT)', 'C. Integration Testing'], 'correct' => 1],
                    ['question' => 'Dokumen resmi yang menyatakan bahwa klien menerima rilis produk secara hukum dan menyatakan proyek selesai dideploy dinamakan?', 'options' => ['A. WBS Approval', 'B. Project Sign-off Document', 'C. Risk Mitigation Form'], 'correct' => 1],
                    ['question' => 'Siapakah pihak yang paling berwenang menandatangani surat persetujuan lolos UAT (UAT sign-off)?', 'options' => ['A. Lead Programmer', 'B. Stakeholder Utama / Klien pemilik proyek', 'C. Sistem Administrator'], 'correct' => 1],
                    ['question' => 'Proses audit internal untuk memastikan seluruh alur pengerjaan proyek telah mengikuti standard operation procedure (SOP) perusahaan dinamakan?', 'options' => ['A. Quality Control', 'B. Quality Assurance (QA)', 'C. Scope Verification'], 'correct' => 1],
                    ['question' => 'Di akhir proyek, PM mengadakan meeting penutupan untuk merangkum pelajaran berharga (lessons learned) demi perbaikan proyek di masa depan. Kegiatan ini disebut?', 'options' => ['A. Retrospective / Post-Mortem Meeting', 'B. Kick-off Meeting', 'C. Daily Standup'], 'correct' => 0]
                ]
            ]
        ];

        // Seed Project Manager Path Modules
        $pmPath = $paths['project-manager'];
        foreach ($pmModules as $mod) {
            $createdMod = Module::updateOrCreate(
                [
                    'path_id' => $pmPath->id,
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
    }
}
