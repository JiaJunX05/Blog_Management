@extends("layouts.app")

@section("title", "Guest Panel")
@section("content")

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container text-center mt-5">
    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Welcome Section -->
    <div class="mb-5">
        <h1 class="display-4 text-primary font-weight-bold">Welcome to Blog Tracks</h1>
        <p class="lead text-muted">Sharing the little moments, big experiences, and everything in between.</p>
    </div>       

    @if($posts->isEmpty())
        <p>No Posts available</p>
    @else
    <div class="d-flex flex-wrap gap-4">
        @foreach($posts as $post)
            <div class="card shadow-sm" style="width: 18rem; border: 1px solid #ddd; border-radius: 8px; position: relative;">
                <!-- Card Header -->
                <div class="card-header bg-light d-flex flex-column align-items-start p-3" style="border-bottom: 2px solid #007bff;">
                    <h5 class="card-title mb-1" style="font-weight: bold; color: #333;">{{$post->title}}</h5>
                    <p class="card-text text-muted small mb-0">Created on : {{ date('M j, Y', strtotime($post->created_at)) }}</p>
                </div>
    
                <!-- Card Body -->
                <div class="card-body">
                    <p class="card-text text-muted" style="font-size: 14px; line-height: 1.6; text-align: justify;">
                        {{ Str::limit($post->content, 30) }}
                    </p>                     
    
                    <!-- Image Section -->
                    @if($post->feature)
                    <div class="position-relative text-center mb-3" style="width: 150px; height: 180px; margin: auto; overflow: hidden; position: relative;">
                        <img src="{{ asset('assets/' . $post->feature) }}" 
                            alt="Post Feature" style="width: 120px; object-position: center;">
                    </div>
                    @endif

                    <!-- Author Name -->
                    <p style="background: rgba(0, 0, 0, 0.6); color: #fff; font-size: 12px; padding: 2px 5px; border-radius: 4px;">
                        By : {{ $post->user->name }}
                    </p>
                    
                    <!-- Card Footer -->
                    <div class="card-footer text-body-secondary mt-3 p-0">
                        <a href="{{ route('gurst.view', $post->id) }}" class="btn btn-success w-100" style="border-radius: 0 0 8px 8px;">Read More</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>    
@endif
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
@endsection
