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

        $userName = auth()->check() ? (auth()->user()->nama ?? auth()->user()->name ?? 'Student') : 'Guest';

        return view('explore-path', compact('paths', 'userName'));
    }
}
