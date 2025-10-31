@extends('layouts.app')
@section('title','Product Images')

@section('content')
<div class="main-content">
  <div class="page-content">
    <div class="container-fluid">
      @include('common.alert')

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Images: {{ $product->product_name }}</h4>
        <a href="{{ route('admin.products.index') }}" class="btn btn-light">Back</a>
      </div>

      <div class="card mb-3">
        <div class="card-header"><h5>Upload Images</h5></div>
        <div class="card-body">
         <form method="POST" action="{{ route('admin.product-images.store', $product->product_id) }}" enctype="multipart/form-data">
       @csrf
        <input type="file" name="images[]" multiple class="form-control mb-3" accept="image/*">
        <button type="submit" class="btn btn-success">Upload</button>
    </form>

        </div>
      </div>

      <div class="card">
        <div class="card-header"><h5>Existing Images</h5></div>
        <div class="card-body">

          @if($images->isEmpty())
            <p class="text-muted">No images uploaded yet.</p>
          @else
          <form method="POST" action="{{ route('admin.product-images.delete', $product->product_id) }}" onsubmit="return confirm('Delete all images?')">
                        @csrf
                        <button class="btn btn-danger btn-sm">Delete All</button>
                    </form>
            <div class="row g-3">
              @foreach($images as $img)
              <div class="col-6 col-sm-3 col-md-2">
                <div class="border rounded p-2 text-center">
                  <img src="{{ asset($img->image) }}" alt="img" class="img-fluid rounded mb-2" style="height:100px;object-fit:cover;">
                  <form method="POST" action="{{ route('admin.product-images.deleteOne', $img->pimage_id) }}" onsubmit="return confirm('Delete this image?')">
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
