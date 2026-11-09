<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    // buat nampilin halaman login
    public function login()
    {
        return view('login');
    }

    // buat proses login
    public function processLogin(Request $request)
    {
        $username = $request->input('username');

        return redirect('/dashboard?username=' . urlencode($username));
    }

    // buat nampilin dashboard
    public function dashboard(Request $request)
    {
        $username = $request->query('username');

        $songs = [
            [
                'title' => 'Blue',
                'artist' => 'Yung Kai',
                'genre' => 'Pop',
                'cover' => 'https://images.genius.com/96fab843dc59f3be9ec6e577de8552fa.1000x1000x1.png',
                'audio' => 'audio/blue.mp3'
            ],
            [
                'title' => 'Snooze',
                'artist' => 'SZA',
                'genre' => 'R&B',
                'cover' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRncyZTS63oegy_31kUvzZ-v8-6fiuIPIKpGDlZQms6Yg&s=10',
                'audio' => 'audio/snooze.mp3'
            ],
            [
                'title' => 'About You',
                'artist' => 'The 1975',
                'genre' => 'Alternative',
                'cover' => 'https://images.genius.com/60ba63411598b6a0f4c140fdfe0e63e2.1000x1000x1.png',
                'audio' => 'audio/about-you.mp3'
            ],
            [
                'title' => 'Die For You',
                'artist' => 'The Weeknd',
                'genre' => 'R&B',
                'cover' => 'https://images.genius.com/48384980900a8fd748758ae951567ff6.1000x1000x1.png',
                'audio' => 'audio/die-for-you.mp3'
            ]
        ];

        return view('dashboard', compact('username', 'songs'));
    }



    // buat nampilin halaman pengelolaan
    public function pengelolaan(Request $request)
    {
        $username = $request->query('username');
        $playlistSlug = $request->query('playlist');

        $playlists = [
            [
                'slug' => 'favorite-songs',
                'name' => 'Favorite Songs',
                'description' => 'Kumpulan lagu favoritmu',
                'songs' => [
                    [
                        'title' => 'Blue',
                        'artist' => 'Yung Kai',
                        'audio' => 'audio/blue.mp3'
                    ],
                    [
                        'title' => 'Snooze',
                        'artist' => 'SZA',
                        'audio' => 'audio/snooze.mp3'
                    ],
                    [
                        'title' => 'About You',
                        'artist' => 'The 1975',
                        'audio' => 'audio/about-you.mp3'
                    ],
                    [
                        'title' => 'Die For You',
                        'artist' => 'The Weeknd',
                        'audio' => 'audio/die-for-you.mp3'
                    ],
                ]
            ],

            [
                'slug' => 'chill-vibes',
                'name' => 'Chill Vibes',
                'description' => 'Musik untuk menemani waktu santai',
                'songs' => [
                    [
                        'title' => 'Snooze',
                        'artist' => 'SZA',
                        'audio' => 'audio/snooze.mp3'
                    ],
                    [
                        'title' => 'Blue',
                        'artist' => 'Yung Kai',
                        'audio' => 'audio/blue.mp3'
                    ],
                ]
            ],

            [
                'slug' => 'daily-mix',
                'name' => 'Daily Mix',
                'description' => 'Musik untuk menemani aktivitas sehari-hari',
                'songs' => [
                    [
                        'title' => 'About You',
                        'artist' => 'The 1975',
                        'audio' => 'audio/about-you.mp3'
                    ],
                    [
                        'title' => 'Die For You',
                        'artist' => 'The Weeknd',
                        'audio' => 'audio/die-for-you.mp3'
                    ],
                ]
            ]
        ];

        $selectedPlaylist = null;

        foreach ($playlists as $playlist) {
            if ($playlist['slug'] === $playlistSlug) {
                $selectedPlaylist = $playlist;
                break;
            }
        }

        return view('pengelolaan', compact(
            'username',
            'playlists',
            'selectedPlaylist'
        ));
    }

    // buat nampilin halaman profile
    public function profile(Request $request)
    {
        $username = $request->query('username');

        return view('profile', compact('username'));
    }
}
