
@extends('layouts.app')

@section('title', 'Dashboard - SONORA')

@section('showNavbar', 'true')
@section('showFooter', 'true')

@section('content')

    <!-- buat bagian sambutan -->
    <div class="welcome">
        <div>
            <span class="welcome-label">YOUR PERSONAL MUSIC SPACE</span>
            <h1>Welcome back, {{ $username }}!</h1>
            <p>Temukan musik yang menemani setiap suasana hatimu.</p>
        </div>
    </div>

    <!-- buat judul rekomendasi -->
    <div class="section-heading">
        <div>
            <span class="section-label">DISCOVER YOUR SOUND</span>
            <h2>Recommended Songs</h2>
            <p>Pilihan musik untuk menemani harimu.</p>
        </div>
    </div>

    <!-- buat pencarian lagu -->
    <div class="search-container">
        <span class="search-icon">⌕</span>
        <input
            type="text"
            id="song-search"
            placeholder="Cari judul lagu atau nama penyanyi..."
            autocomplete="off"
        >
    </div>

    <!-- buat kategori musik -->
    <div class="music-categories">
        <button type="button" class="category-active" data-filter="All">All</button>
        <button type="button" data-filter="Pop">Pop</button>
        <button type="button" data-filter="R&B">R&B</button>
        <button type="button" data-filter="Alternative">Alternative</button>
    </div>

    <!-- buat jumlah hasil pencarian -->
    <p id="song-count" class="song-count"></p>

    <!-- buat daftar lagu -->
    <div class="song-list">
        @foreach ($songs as $song)
            <div
                class="song-card"
                data-genre="{{ $song['genre'] }}"
                data-title="{{ strtolower($song['title']) }}"
                data-artist="{{ strtolower($song['artist']) }}"
                data-cover="{{ $song['cover'] }}"
                data-audio="{{ asset($song['audio']) }}"
                data-song-title="{{ $song['title'] }}"
                data-song-artist="{{ $song['artist'] }}"
            >
                <div class="album-cover">
                    <img
                        src="{{ $song['cover'] }}"
                        alt="Cover {{ $song['title'] }}"
                        loading="lazy"
                    >
                </div>

                <h3>{{ $song['title'] }}</h3>
                <p>{{ $song['artist'] }}</p>
                <small>{{ $song['genre'] }}</small>

                <span class="card-detail">Lihat detail →</span>
            </div>
        @endforeach
    </div>

    <!-- buat pesan jika lagu tidak ditemukan -->
    <p id="no-results" class="no-results" style="display: none;">
        Lagu yang kamu cari tidak ditemukan.
    </p>

    <!-- buat detail lagu -->
    <div class="song-modal" id="song-modal">
        <div class="song-modal-content">

            <button type="button" class="modal-close" id="close-modal">
                &times;
            </button>

            <img id="detail-cover" src="" alt="Cover lagu">

            <span class="section-label">SONG INFORMATION</span>

            <h2 id="detail-title">Judul Lagu</h2>
            <p id="detail-artist">Nama Penyanyi</p>
            <small id="detail-genre">Genre</small>

            <button type="button" class="detail-play" id="detail-play">
                ▶ Putar Lagu
            </button>

        </div>
    </div>

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
            <button type="button" id="play-button" aria-label="Putar lagu">
                ▶
            </button>

            <div class="player-progress">
                <span id="current-time">0:00</span>

                <input
                    type="range"
                    id="progress-bar"
                    min="0"
                    max="100"
                    value="0"
                >

                <span id="duration">0:00</span>
            </div>
        </div>

        <button type="button" id="close-player" class="player-close">
            &times;
        </button>

        <audio id="audio-element"></audio>

    </div>

    <!-- buat fungsi pencarian, filter, dan pemutar musik -->
    <script>
        const searchInput = document.getElementById('song-search');
        const filterButtons = document.querySelectorAll('.music-categories button');
        const songCards = document.querySelectorAll('.song-card');
        const noResults = document.getElementById('no-results');
        const songCount = document.getElementById('song-count');

        const modal = document.getElementById('song-modal');
        const closeModal = document.getElementById('close-modal');

        const audio = document.getElementById('audio-element');
        const player = document.getElementById('music-player');
        const playButton = document.getElementById('play-button');
        const progressBar = document.getElementById('progress-bar');

        const currentTime = document.getElementById('current-time');
        const duration = document.getElementById('duration');

        let selectedGenre = 'All';
        let currentSong = null;

        // buat format waktu lagu
        function formatTime(seconds) {
            if (!Number.isFinite(seconds)) {
                return '0:00';
            }

            const minutes = Math.floor(seconds / 60);
            const remainingSeconds = Math.floor(seconds % 60);

            return minutes + ':' + String(remainingSeconds).padStart(2, '0');
        }

        // buat fungsi pencarian dan filter
        function filterSongs() {
            const keyword = searchInput.value.toLowerCase().trim();
            let visibleSongs = 0;

            songCards.forEach(card => {
                const matchesSearch =
                    card.dataset.title.includes(keyword) ||
                    card.dataset.artist.includes(keyword);

                const matchesGenre =
                    selectedGenre === 'All' ||
                    card.dataset.genre === selectedGenre;

                if (matchesSearch && matchesGenre) {
                    card.style.display = 'block';
                    visibleSongs++;
                } else {
                    card.style.display = 'none';
                }
            });

            songCount.textContent = visibleSongs + ' lagu ditemukan';

            noResults.style.display =
                visibleSongs === 0 ? 'block' : 'none';
        }

        // buat fungsi pencarian
        searchInput.addEventListener('input', filterSongs);

        // buat fungsi filter kategori
        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                selectedGenre = this.dataset.filter;

                filterButtons.forEach(item => {
                    item.classList.remove('category-active');
                });

                this.classList.add('category-active');

                filterSongs();
            });
        });

        // buat memilih lagu
        function selectSong(card, autoplay = false) {
            currentSong = card;

            const title = card.dataset.songTitle;
            const artist = card.dataset.songArtist;
            const cover = card.dataset.cover;
            const audioSource = card.dataset.audio;
            const genre = card.dataset.genre;

            document.getElementById('detail-cover').src = cover;
            document.getElementById('detail-title').textContent = title;
            document.getElementById('detail-artist').textContent = artist;
            document.getElementById('detail-genre').textContent = genre;

            document.getElementById('player-cover').src = cover;
            document.getElementById('player-title').textContent = title;
            document.getElementById('player-artist').textContent = artist;

            player.style.display = 'flex';

            if (audio.src !== audioSource) {
                audio.src = audioSource;
                audio.load();

                progressBar.value = 0;
                currentTime.textContent = '0:00';
                duration.textContent = '0:00';
            }

            if (autoplay) {
                playSong();
            }
        }

        // buat membuka detail lagu
        songCards.forEach(card => {
            card.addEventListener('click', function () {
                selectSong(this);
                modal.classList.add('show');
            });
        });

        // buat menutup detail lagu
        closeModal.addEventListener('click', function () {
            modal.classList.remove('show');
        });

        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                modal.classList.remove('show');
            }
        });

        // buat memutar lagu
        function playSong() {
            if (!currentSong) {
                return;
            }

            audio.play()
                .then(() => {
                    playButton.textContent = '❚❚';
                })
                .catch(() => {
                    alert('File musik belum tersedia atau tidak dapat diputar.');
                });
        }

        // buat tombol play dan pause
        playButton.addEventListener('click', function () {
            if (!currentSong) {
                return;
            }

            if (audio.paused) {
                playSong();
            } else {
                audio.pause();
                playButton.textContent = '▶';
            }
        });

        // buat tombol putar dari detail lagu
        document.getElementById('detail-play').addEventListener('click', function () {
            playSong();
            modal.classList.remove('show');
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

        // buat mengubah tombol saat lagu selesai
        audio.addEventListener('ended', function () {
            playButton.textContent = '▶';
            progressBar.value = 0;
        });

        // buat mengubah tombol saat audio dijeda
        audio.addEventListener('pause', function () {
            playButton.textContent = '▶';
        });

        // buat mengubah tombol saat audio diputar
        audio.addEventListener('play', function () {
            playButton.textContent = '❚❚';
        });

        // buat menutup pemutar musik
        document.getElementById('close-player').addEventListener('click', function () {
            audio.pause();
            audio.removeAttribute('src');
            audio.load();

            player.style.display = 'none';
            currentSong = null;
        });

        // buat tampilan awal
        filterSongs();
    </script>

@endsection
