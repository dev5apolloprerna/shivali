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
            
             @php
                      $selectedCategory    = old('category_id', $row->category_id ?? '');
                      $selectedSubcategory = old('subcategory_id', $row->subcategory_id ?? '');
                    @endphp
                    
                    <div class="row">
                      <div class="col-md-6 mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select id="jsCategory"
                                name="category_id"
                                class="form-select @error('category_id') is-invalid @enderror"
                                data-selected="{{ $selectedCategory }}">
                          <option value="">-- Select Category --</option>
                          @foreach($categories as $id => $name)
                            <option value="{{ $id }}" @selected($selectedCategory == $id)>{{ $name }}</option>
                          @endforeach
                        </select>
                        @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                      </div>
                    
                      <div class="col-md-6 mb-3">
                        <label class="form-label">Subcategory <span class="text-danger">*</span></label>
                        <select id="jsSubcategory"
                                name="subcategory_id"
                                class="form-select @error('subcategory_id') is-invalid @enderror"
                                data-selected="{{ $selectedSubcategory }}"
                                {{ $selectedCategory ? '' : 'disabled' }}>
                          <option value="">-- Select Subcategory --</option>
                          {{-- options injected by JS --}}
                        </select>
                        @error('subcategory_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text" id="jsSubcatHelp" style="display:none;">Loading subcategories…</div>
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


(function () {
  const catSel  = document.getElementById('jsCategory');
  const subSel  = document.getElementById('jsSubcategory');
  const helpTxt = document.getElementById('jsSubcatHelp');
  if (!catSel || !subSel) return;

  // Build route URL from your named route, replacing placeholder
  const ROUTE_TEMPLATE = @json(route('admin.fetch-subcategories', ['category' => '__ID__']));

  async function loadSubcategories(categoryId, preselectId) {
    // reset
    subSel.innerHTML = '<option value="">-- Select Subcategory --</option>';
    subSel.disabled = true;
    if (helpTxt) { helpTxt.style.display = 'inline'; helpTxt.textContent = 'Loading subcategories…'; }

    if (!categoryId) { if (helpTxt) helpTxt.style.display = 'none'; return; }

    const url = ROUTE_TEMPLATE.replace('__ID__', encodeURIComponent(categoryId));

    try {
      const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
      if (!res.ok) throw new Error('Bad response');
      const list = await res.json(); // [{iSubCategoryId, strSubCategoryName}, ...]

      for (const it of list) {
        const opt = document.createElement('option');
        opt.value = String(it.iSubCategoryId);
        opt.textContent = it.strSubCategoryName;
        if (preselectId && String(preselectId) === String(it.iSubCategoryId)) {
          opt.selected = true;
        }
        subSel.appendChild(opt);
      }

      subSel.disabled = false;
      if (helpTxt) helpTxt.style.display = 'none';
    } catch (err) {
      console.error(err);
      if (helpTxt) {
        helpTxt.style.display = 'inline';
        helpTxt.textContent = 'Failed to load subcategories. Please try again.';
      }
    }
  }

  // On first load (covers Edit + validation errors)
  const initialCategoryId    = catSel.getAttribute('data-selected') || catSel.value || '';
  const initialSubcategoryId = subSel.getAttribute('data-selected') || '';
  if (initialCategoryId) {
    loadSubcategories(initialCategoryId, initialSubcategoryId);
  }

  // On Category change
  catSel.addEventListener('change', function () {
    subSel.setAttribute('data-selected', ''); // clear previous
    loadSubcategories(this.value, '');
  });
})();

</script>

@endsection
