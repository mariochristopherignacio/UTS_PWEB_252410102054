
@extends('layouts.app')

@section('title', 'My Library - SONORA')

@section('showNavbar', 'true')
@section('showFooter', 'true')

@section('content')

    @if ($selectedPlaylist)

        @php
            $songCovers = [
                'Blue' => 'https://images.genius.com/96fab843dc59f3be9ec6e577de8552fa.1000x1000x1.png',
                'Snooze' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRncyZTS63oegy_31kUvzZ-v8-6fiuIPIKpGDlZQms6Yg&s=10',
                'About You' => 'https://images.genius.com/60ba63411598b6a0f4c140fdfe0e63e2.1000x1000x1.png',
                'Die For You' => 'https://images.genius.com/48384980900a8fd748758ae951567ff6.1000x1000x1.png'
            ];

            $songAudio = [
                'Blue' => 'audio/blue.mp3',
                'Snooze' => 'audio/snooze.mp3',
                'About You' => 'audio/about-you.mp3',
                'Die For You' => 'audio/die-for-you.mp3'
            ];
        @endphp

        <!-- buat halaman detail playlist -->
        <div class="library-detail">

            <a href="/pengelolaan?username={{ urlencode($username) }}"
               class="back-link">
                <span>←</span> Kembali ke My Library
            </a>

            <!-- buat informasi playlist -->
            <div class="playlist-hero">

                <div class="playlist-hero-cover">

                    @if ($selectedPlaylist['slug'] === 'favorite-songs')
                        <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=700"
                             alt="Favorite Songs">

                    @elseif ($selectedPlaylist['slug'] === 'chill-vibes')
                        <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=700"
                             alt="Chill Vibes">

                    @else
                        <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=700"
                             alt="Daily Mix">
                    @endif

                </div>

                <div class="playlist-hero-info">

                    <span class="welcome-label">SONORA PLAYLIST</span>

                    <h1>{{ $selectedPlaylist['name'] }}</h1>

                    <p>{{ $selectedPlaylist['description'] }}</p>

                    <span class="playlist-total">
                        {{ count($selectedPlaylist['songs']) }} lagu
                    </span>

                    <button type="button"
                            class="playlist-play-all"
                            id="playAllSongs">
                        <span>▶</span> Putar Semua
                    </button>

                </div>

            </div>

            <!-- buat daftar lagu -->
            <div class="library-song-section">

                <div class="section-heading">
                    <span class="section-label">PLAYLIST CONTENT</span>
                    <h2>Daftar Lagu</h2>
                    <p>Pilih lagu dan nikmati musik favoritmu.</p>
                </div>

                <div class="library-song-list">

                    @foreach ($selectedPlaylist['songs'] as $index => $song)

                        @php
                            $cover = $songCovers[$song['title']] ?? '';
                            $audioFile = $songAudio[$song['title']] ?? '';
                        @endphp

                        <button type="button"
                                class="library-song-item song-play-button"
                                data-title="{{ $song['title'] }}"
                                data-artist="{{ $song['artist'] }}"
                                data-cover="{{ $cover }}"
                                data-audio="{{ asset($audioFile) }}">

                            <span class="library-song-number">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>

                            <div class="library-song-cover">
                                <img src="{{ $cover }}"
                                     alt="{{ $song['title'] }} Cover">
                            </div>

                            <div class="library-song-info">
                                <h3>{{ $song['title'] }}</h3>
                                <p>{{ $song['artist'] }}</p>
                            </div>

                            <span class="library-song-play">▶</span>

                        </button>

                    @endforeach

                </div>

            </div>

        </div>

    @else

        <!-- buat halaman utama my library -->
        <div class="welcome">
            <span class="welcome-label">YOUR MUSIC COLLECTION</span>
            <h1>My Library</h1>
            <p>Semua musik dan playlist favoritmu ada di sini.</p>
        </div>

        <div class="section-heading">
            <span class="section-label">YOUR COLLECTION</span>
            <h2>Your Playlists</h2>
            <p>Kumpulan playlist untuk berbagai suasana.</p>
        </div>

        <!-- buat kartu playlist -->
        <div class="playlist-list">

            @foreach ($playlists as $playlist)

                <a href="/pengelolaan?username={{ urlencode($username) }}&playlist={{ $playlist['slug'] }}"
                   class="playlist-card">

                    <div class="album-cover">

                        @if ($playlist['slug'] === 'favorite-songs')
                            <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600"
                                 alt="Favorite Songs Cover">

                        @elseif ($playlist['slug'] === 'chill-vibes')
                            <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?w=600"
                                 alt="Chill Vibes Cover">

                        @else
                            <img src="https://images.unsplash.com/photo-1516280440614-37939bbacd81?w=600"
                                 alt="Daily Mix Cover">
                        @endif

                    </div>

                    <h3>{{ $playlist['name'] }}</h3>
                    <p>{{ $playlist['description'] }}</p>

                    <span class="playlist-open">
                        Lihat Playlist →
                    </span>

                </a>

            @endforeach

        </div>

    @endif

    @if ($selectedPlaylist)

        <!-- buat pemutar musik -->
        <div class="music-player" id="music-player" style="display: none;">

            <div class="player-song">

                <img id="player-cover" src="" alt="Cover lagu">

                <div>
                    <h4 id="player-title">Belum ada lagu</h4>
                    <p id="player-artist">Pilih lagu untuk diputar</p>
                </div>

            </div>

            <div class="player-controls">

                <button type="button"
                        id="play-button"
                        aria-label="Putar lagu">
                    ▶
                </button>

                <div class="player-progress">

                    <span id="current-time">0:00</span>

                    <input type="range"
                           id="progress-bar"
                           min="0"
                           max="100"
                           value="0">

                    <span id="duration">0:00</span>

                </div>

            </div>

            <button type="button"
                    id="close-player"
                    class="player-close">
                &times;
            </button>

            <audio id="audio-element"></audio>

        </div>

        <!-- buat fungsi pemutar musik -->
        <script>
            const audio = document.getElementById('audio-element');
            const player = document.getElementById('music-player');

            const playButton = document.getElementById('play-button');
            const progressBar = document.getElementById('progress-bar');

            const currentTime = document.getElementById('current-time');
            const duration = document.getElementById('duration');

            const playerCover = document.getElementById('player-cover');
            const playerTitle = document.getElementById('player-title');
            const playerArtist = document.getElementById('player-artist');

            const librarySongs = Array.from(
                document.querySelectorAll('.song-play-button')
            );

            let currentSongIndex = 0;

            // buat format waktu lagu
            function formatTime(seconds) {
                if (!Number.isFinite(seconds)) {
                    return '0:00';
                }

                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);

                return minutes + ':' +
                    String(remainingSeconds).padStart(2, '0');
            }

            // buat memilih dan memutar lagu
            function playLibrarySong(index) {
                const song = librarySongs[index];

                if (!song) {
                    return;
                }

                currentSongIndex = index;

                const title = song.dataset.title;
                const artist = song.dataset.artist;
                const cover = song.dataset.cover;
                const audioSource = song.dataset.audio;

                playerTitle.textContent = title;
                playerArtist.textContent = artist;
                playerCover.src = cover;

                player.style.display = 'flex';

                if (!audioSource || audioSource.endsWith('/')) {
                    alert('File musik belum tersedia.');
                    return;
                }

                if (audio.src !== audioSource) {
                    audio.src = audioSource;
                    audio.load();

                    progressBar.value = 0;
                    currentTime.textContent = '0:00';
                    duration.textContent = '0:00';
                }

                // buat memutar lagu
                audio.play().catch(() => {
                    alert('File musik tidak dapat diputar. Periksa file audio.');
                });
            }

            // buat memilih lagu dari daftar
            librarySongs.forEach((song, index) => {
                song.addEventListener('click', function () {
                    playLibrarySong(index);
                });
            });

            // buat memutar semua lagu
            document.getElementById('playAllSongs')
                .addEventListener('click', function () {
                    playLibrarySong(0);
                });

            // buat tombol play dan pause
            playButton.addEventListener('click', function () {

                if (!audio.src) {
                    return;
                }

                if (audio.paused) {
                    audio.play().catch(() => {
                        alert('Musik tidak dapat diputar.');
                    });
                } else {
                    audio.pause();
                }

            });

            // buat memperbarui durasi lagu
            audio.addEventListener('loadedmetadata', function () {
                duration.textContent = formatTime(audio.duration);
            });

            // buat memperbarui progress lagu
            audio.addEventListener('timeupdate', function () {

                if (audio.duration) {
                    progressBar.value =
                        (audio.currentTime / audio.duration) * 100;
                }

                currentTime.textContent = formatTime(audio.currentTime);

            });

            // buat mengatur posisi lagu
            progressBar.addEventListener('input', function () {

                if (audio.duration) {
                    audio.currentTime =
                        (progressBar.value / 100) * audio.duration;
                }

            });

            // buat mengubah tombol saat lagu diputar
            audio.addEventListener('play', function () {
                playButton.textContent = '❚❚';
            });

            // buat mengubah tombol saat lagu dijeda
            audio.addEventListener('pause', function () {
                playButton.textContent = '▶';
            });

            // buat memutar lagu berikutnya
            audio.addEventListener('ended', function () {

                if (currentSongIndex < librarySongs.length - 1) {
                    playLibrarySong(currentSongIndex + 1);
                } else {
                    playButton.textContent = '▶';
                    progressBar.value = 0;
                }

            });

            // buat menutup pemutar musik
            document.getElementById('close-player')
                .addEventListener('click', function () {

                    audio.pause();
                    audio.removeAttribute('src');
                    audio.load();

                    player.style.display = 'none';

                    playerCover.src = '';
                    playerTitle.textContent = 'Belum ada lagu';
                    playerArtist.textContent = 'Pilih lagu untuk diputar';

                    progressBar.value = 0;
                    currentTime.textContent = '0:00';
                    duration.textContent = '0:00';

                });
        </script>

    @endif

@endsection
