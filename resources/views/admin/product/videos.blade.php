@extends('layouts.app')
@section('title','Product Videos')

@section('content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      @include('common.alert')

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Videos: {{ $product->product_name }}</h4>
        <a href="{{ route('admin.products.index') }}" class="btn btn-light">Back</a>
      </div>

      <div class="card mb-3">
        <div class="card-header"><h5>Add Video Link</h5></div>
        <div class="card-body">
          <form method="POST" action="{{ route('admin.product-videos.store', $product->product_id) }}">
            @csrf
            <div class="row g-3">
              <div class="col-md-8">
                <input type="text" name="video_link" value="{{ old('video_link') }}"
                       class="form-control @error('video_link') is-invalid @enderror"
                       placeholder="Enter YouTube or Vimeo link">
                @error('video_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="col-md-4 d-grid">
                <button type="submit" class="btn btn-primary">Add Video</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <div class="card-header"><h5>Video List</h5></div>
        <div class="card-body">
          @if($videos->isEmpty())
            <p class="text-muted">No videos added yet.</p>
          @else
            <div class="row g-3">
              @foreach($videos as $vid)
              <div class="col-md-6 col-lg-4">
                <div class="border rounded p-2 h-100">
                  <!-- <div class="ratio ratio-16x9 mb-2"> -->
                    <a href="{{ $vid->video_link }}"  target="_blank">{{ $vid->video_link }}</a>
                  <!-- </div> -->
                  <form method="POST" action="{{ route('admin.product-videos.deleteOne', $vid->pvideo_id) }}" onsubmit="return confirm('Delete this video?')">
                    @csrf
                    <button class="btn btn-sm btn-danger w-100">Delete</button>
                  </form>
                </div>
              </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>

    </div>
  </div>
</div>
@endsection
