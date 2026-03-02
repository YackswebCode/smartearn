@extends('layouts.app')

@section('title', 'Reset Password – SmartEarn')

@section('content')
<section class="hero d-flex align-items-center" style="min-height: 80vh; background: var(--gradient-green);">
    <!-- ... your existing design ... -->
    <div class="container">
        <div class="auth-card">
            <!-- ... header ... -->

            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert" style="border-radius: 16px; background: rgba(6,87,84,0.1); color: var(--primary-green); border: none;">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert" style="border-radius: 16px; background: rgba(220,53,69,0.1); color: #dc3545; border: none;">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <!-- email field ... -->
            </form>
        </div>
    </div>
</section>
@endsection