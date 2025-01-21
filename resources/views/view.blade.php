@extends("layouts.app")

@section("title", "View Post")
@section("content")

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container mt-4">
    <div class="mb-4">
        <h1 class="text-primary">View My Post</h1>
        <p class="text-muted">View and manage your posts here.</p><hr>
    </div>

    <div class="row">
        <div class="col-md-3 mt-3 mb-3 text-center">
            <div class="card text-center border-0">
                <div class="card-body">
                    <img src="{{ asset('assets/' . $post->feature) }}" alt="{{ $post->title }}" 
                        class="image img-fluid w-50 object-fit-contain" id="preview-image">
                </div>
                <div class="card-footer bg-transparent border-0">
                    <p class="text-center fst-italic mt-3 mb-3">
                        With Knowledge Comes Power, <br>
                        With Attitude Comes Character.
                    </p>
                </div>
            </div>
        </div>            
                 
        <div class="col-md-9">
            <div class="mb-3">
                <label for="name" class="form-label">Post Title:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $post->title }}" readonly>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Post Content:</label>
                <textarea class="form-control" id="description" name="description" rows="3" readonly>{{ $post->content }}</textarea>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Post Image:</label>
                @if ($post->image)
                    <div class="row mt-3 d-flex flex-wrap justify-content-center">
                        @foreach ($post->image as $image)
                            <div class="col-2 m-2 d-flex justify-content-center align-items-center">
                                <div class="position-relative" style="width: 100px; height: 100px;">
                                    <img src="{{ asset('assets/' . $image->image) }}" alt="Image" class="img-fluid" style="object-fit: cover; width: 100%; height: 100%;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>            
    </div>
</div>

@endsection