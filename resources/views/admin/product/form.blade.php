@extends('layouts.app')
@section('title', isset($row) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                {{-- Alert Messages --}}
                @include('common.alert')

                {{--  @if ($errors->any())
                    <h5 style="color:red">Following errors exists in your excel file</h5>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                @endif  --}}

                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Add Product</h4>
                            <div class="page-title-right">
                                <a href="{{ route('admin.products.index') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="live-preview">

          <form method="POST"
                action="{{ isset($row) ? route('admin.products.update',$row->product_id) : route('admin.products.store') }}"
                enctype="multipart/form-data">
            @csrf
            @if(isset($row)) @method('PUT') @endif

          {{-- Row 1: Category + Subcategory --}}
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                  <option value="">-- Select Category --</option>
                  @foreach($categories as $id => $name)
                    <option value="{{ $id }}" @selected(old('category_id', $row->category_id ?? '') == $id)>
                      {{ $name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-md-6 mb-3">
                <label class="form-label">Subcategory <span class="text-danger">*</span></label>
                <select name="subcategory_id" class="form-select @error('subcategory_id') is-invalid @enderror">
                  <option value="">-- Select Subcategory --</option>
                  @foreach($subcategories as $id => $name)
                    <option value="{{ $id }}" @selected(old('subcategory_id', $row->subcategory_id ?? '') == $id)>
                      {{ $name }}
                    </option>
                  @endforeach
                </select>
                @error('subcategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            {{-- Row 1: Product Name + Description --}}
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="form-label">Product Name <span class="text-danger">*</span></label>
                <input type="text"
                       name="product_name"
                       value="{{ old('product_name', $row->product_name ?? '') }}"
                       class="form-control @error('product_name') is-invalid @enderror"
                       placeholder="Enter product name"
                       id="jsProductName">
                @error('product_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <div class="form-text">
                  Slug: <span class="fw-semibold" id="jsSlugPreview">
                    @if(isset($row) && $row->slug) {{ $row->slug }} @else <span class="text-muted">Generated on save</span> @endif
                  </span>
                </div>
              </div>

             
              <div class="col-md-6 mb-3">
                <label class="form-label">
                  Product Image {{ isset($row) ? '(leave blank to keep)' : '' }}
                </label>
                <input type="file"
                       name="product_image" 
                       accept=".jpg,.jpeg,.png,.webp"
                       class="form-control @error('product_image') is-invalid @enderror">
                @error('product_image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                @if(!empty($row?->product_image))
                  <div class="mt-2">
                    <img src="{{ asset($row->product_image) }}" alt="image" style="max-height: 90px;">
                  </div>
                @endif
              </div>

            </div>

            

            {{-- Row 3: Product Image + Status --}}
            <div class="row">
                 <div class="col-md-12 mb-3">
                <label class="form-label">Description</label>
                 <textarea class="form-control ckeditor" name="description" id="description" rows="6">{{ old('description', $row->description ?? '') }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              </div>
            </div>


            <div class="card-footer mt-5" style="float: right;">
              @if(!isset($row))
                <button type="submit"  class="btn btn-primary btn-user float-right mb-3 mx-2">Save</button>
                <button class="btn btn-light float-right mr-3 mb-3 mx-2" type="reset">Clear</a>
                @else
                <button type="submit"  class="btn btn-primary btn-user float-right mb-3 mx-2">Update</button>
                <a class="btn btn-light float-right mr-3 mb-3 mx-2" href="{{ route('admin.products.index') }}">Cancel</a>

                @endif
            </div>

          </form>
        </div>
      </div>
</div>

    </div> {{-- container-fluid --}}
  </div>
</div>
</div>
</div>

@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>

<script>
(function () {
  const nameInput = document.getElementById('jsProductName');
  const preview   = document.getElementById('jsSlugPreview');
  if (!nameInput || !preview) return;

  function slugify(str) {
    return String(str || '')
      .toLowerCase()
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/(^-|-$)+/g, '')
      .substring(0, 190);
  }

  nameInput.addEventListener('input', function () {
    const v = this.value.trim();
    preview.textContent = v ? slugify(v) : 'Generated on save';
    if (!v) preview.classList.add('text-muted'); else preview.classList.remove('text-muted');
  });
})();
</script>

@endsection
