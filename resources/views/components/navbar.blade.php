
<nav class="navbar">
    <h2 class="logo">SONORA</h2>

    <ul>
        <li>
            <a href="/dashboard?username={{ urlencode(request()->query('username')) }}"
               class="{{ request()->is('dashboard') ? 'active' : '' }}">
                Home
            </a>
        </li>

        <li>
            <a href="/pengelolaan?username={{ urlencode(request()->query('username')) }}"
               class="{{ request()->is('pengelolaan') ? 'active' : '' }}">
                My Library
            </a>
        </li>

        <li>
            <a href="/profile?username={{ urlencode(request()->query('username')) }}"
               class="{{ request()->is('profile') ? 'active' : '' }}">
                Profile
            </a>
        </li>
    </ul>
</nav>
