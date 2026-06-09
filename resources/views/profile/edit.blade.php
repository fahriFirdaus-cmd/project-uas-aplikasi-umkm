@extends('layouts.app')

@section('content')

<div class="mb-10">

    <h1 class="text-6xl font-bold text-slate-800">
        {{ __('Profile') }}
    </h1>

    <p class="text-2xl text-gray-500 mt-2">
        Kelola informasi akun Anda dan password keamanan
    </p>

</div>

<div class="space-y-8 max-w-4xl">

    <!-- UPDATE PROFILE INFORMATION -->
    <div class="bg-white p-8 sm:p-10 rounded-3xl shadow">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    <!-- UPDATE PASSWORD -->
    <div class="bg-white p-8 sm:p-10 rounded-3xl shadow">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    <!-- DELETE USER ACCOUNT -->
    <div class="bg-white p-8 sm:p-10 rounded-3xl shadow border-red-100 border">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>

@endsection
