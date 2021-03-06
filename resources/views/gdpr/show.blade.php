@extends('layouts.app')

{{-- link to styles --}}
@section('custom-style')
{{-- custom style goes here --}}

@endsection

{{-- for web view --}}
@section('web-content')
<div class="d-flex flex-column min-vh-100">
    @include('partials.web.header')
    <div class="flex-grow-1">
        <div class="container py-3 col-8 lead">
            @include('gdpr.partials.dpa')
        </div>
    </div>
    <div>
        <div class="mb-5"></div>
        @include('partials.web.footer')
    </div>
</div>
@endsection

{{-- for mobile view --}}
@section('content')
<section>
    <div class="container py-3 lead mb-5">
        <a href="{{ url()->previous() }}" class="">
            <img src="{{ asset('/frontend/img/svg/back_blue.svg') }}" alt="go back">
        </a>
        @include('gdpr.partials.dpa')
    </div>
</section>
@endsection
@section('footer')
@include('partials.mobile.footer.footer')
@endsection

{{-- scripts --}}
@section('script')

@endsection
