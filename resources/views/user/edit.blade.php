@extends("user.layouts.app")

@section("title", "Edit Post")
@section("content")

<!-- JQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<div class="container mt-4">
    <div class="text-center">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Error Alert -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="mb-4">
        <h1 class="text-primary">Edit My Post</h1>
        <p class="text-muted">Edit the details of your existing post here.</p><hr>
    </div>

    <form action="{{ route('user.edit.submit', $post->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
                    <label for="feature" class="form-label">Post Feature Image:</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="feature" name="feature">
                        <label class="input-group-text" for="feature">Upload</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Post Title:</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $post->title}}" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Post Content:</label>
                    <textarea class="form-control" id="content" name="content" placeholder="Enter Your Content" rows="3">{{ $post->content }}</textarea>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Post Images:</label>
            <div class="input-group">
                <input type="file" class="form-control" id="image" name="image[]" multiple accept="image/*">
                <label class="input-group-text" for="image">Upload</label>
            </div>
            <small class="text-muted">You can upload up to 10 images.</small>
        </div>
        <div id="image-preview-container" class="d-flex flex-wrap mt-3"></div>

        @if($post->image)
            <div class="row mt-5">
                @foreach($post->image as $index => $image)
                    @if($index % 3 == 0 && $index != 0)
                        </div><div class="row"> <!-- Creates a new row every 3 images -->
                    @endif
    
                    <div class="col-4 mb-3">
                        <div class="position-relative d-flex gap-3">
                            <input type="checkbox" name="remove_image[]" value="{{ $image->id }}" id="remove_image_{{ $image->id }}" class="form-check-input">
                            <img src="{{ asset('assets/' . $image->image) }}" alt="post image" class="img-fluid" style="width: 100px;">
                            <label for="remove_image_{{ $image->id }}" class="position-absolute btn btn-danger btn-sm" style="bottom: 5px; right: 5px; cursor: pointer;"> Remove Image</label>
                        </div>
                    </div>
        
                @endforeach
            </div>
        @endif

        <button type="submit" class="btn btn-primary w-100 mt-3 mb-3">Submit</button>
    </form>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/edit.js') }}"></script>
@endsection