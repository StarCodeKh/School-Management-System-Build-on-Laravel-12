@extends('layouts.error')
@section('content')
    <div class="main-wrapper">
        <div class="error-box">
            <h1>500</h1>
            <h3 class="h2 mb-3"><i class="fas fa-exclamation-triangle"></i> Internal Server Error</h3>
            <p class="h4 font-weight-normal">You do not have permission to view this resource</p>
            <a href="{{route('home')}}" class="btn btn-primary">Back to Home</a>
        </div>
    </div>
@endsection