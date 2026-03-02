@extends('layouts.affiliate')

@section('title', $track->name)

@section('content')
<div class="container-fluid py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('affiliate.skill_garage') }}">Digital University</a></li>
            <li class="breadcrumb-item"><a href="{{ route('affiliate.skill_garage.faculty', $track->faculty->id) }}">{{ $track->faculty->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $track->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <h2 class="fw-bold">{{ $track->name }}</h2>
                @if($track->is_diploma)
                    <span class="badge bg-success mb-3">Diploma Program ({{ $track->duration_months }}+ months)</span>
                @endif
                <div class="mb-4">
                    <h5>Description</h5>
                    <p>{{ $track->description }}</p>
                </div>
                <div class="mb-4">
                    <h5>What you'll learn</h5>
                    <p>{{ $track->detailed_explanation }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 sticky-top" style="top: 20px;">
                <h4 class="fw-bold mb-3">Tuition Plans</h4>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <form method="POST" action="{{ route('affiliate.skill_garage.enroll', $track->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Choose your plan</label>
                        @foreach($prices as $plan => $price)
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="plan" id="plan_{{ $plan }}" value="{{ $plan }}" required>
                            <label class="form-check-label w-100 d-flex justify-content-between" for="plan_{{ $plan }}">
                                <span>{{ ucfirst($plan) }}</span>
                                <span class="fw-bold">{{ $price['formatted'] }}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="alert alert-info small">
                        Your wallet balance: <strong>{{ $symbols[$userCurrency] }}{{ number_format(Auth::user()->wallet_balance / $toNGN[$userCurrency], 2) }}</strong>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2">Enroll Now</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection