
@extends('layouts.app')

@section('title', 'Profile - SONORA')

@section('showNavbar', 'true')
@section('showFooter', 'true')

@section('content')

    <!-- buat judul halaman -->
    <div class="welcome">
        <span class="welcome-label">YOUR ACCOUNT</span>

        <h1>My Profile</h1>

        <p>Informasi akun SONORA kamu.</p>
    </div>

    <!-- buat kartu profile -->
    <div class="profile-card">

        <div class="profile-header">

            <div class="profile-avatar">
                {{ strtoupper(substr($username ?? 'U', 0, 1)) }}
            </div>

            <div>
                <h2>{{ $username }}</h2>
                <p>SONORA Member</p>
            </div>

        </div>

        <div class="profile-divider"></div>

        <h3>Account Information</h3>

        <div class="profile-detail">
            <p>Username</p>
            <strong>{{ $username }}</strong>
        </div>

        <div class="profile-detail">
            <p>Membership</p>
            <strong>SONORA Member</strong>
        </div>

        <div class="profile-detail">
            <p>Account Status</p>
            <strong class="active-status">Active</strong>
        </div>

    </div>

@endsection
