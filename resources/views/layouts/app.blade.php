
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SONORA')</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- buat navbar -->
    @if (trim($__env->yieldContent('showNavbar')) === 'true')
        <x-navbar />
    @endif

    <!-- buat konten halaman -->
    <main>
        @yield('content')
    </main>

    <!-- buat footer -->
    @if (trim($__env->yieldContent('showFooter')) === 'true')
        @include('components.footer')
    @endif

</body>

</html>
