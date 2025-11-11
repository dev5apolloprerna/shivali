@extends('layouts.app')
@section('title', 'Products')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @include('common.alert')

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">Products</h4>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">Add Product</a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header">
                        <form class="row g-2 align-items-center" method="GET" action="{{ route('admin.products.index') }}">
                            <div class="col-md-3">
                                <input type="text" name="q" value="{{ $q }}" class="form-control"
                                    placeholder="Search name/slug/desc">
                            </div>
                            <div class="col-md-3">
                                <select name="category_id" class="form-select">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}" @selected($categoryId == $id)>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="subcategory_id" class="form-select">
                                    <option value="">All Subcategories</option>
                                    @foreach ($subcategories as $id => $name)
                                        <option value="{{ $id }}" @selected($subcatId == $id)>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 d-flex gap-2">
                                <button class="btn btn-secondary" type="submit">Filter</button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-light">Reset</a>
                            </div>
                        </form>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="10%">Image</th>
                                    <th width="45%">Name / Slug</th>
                                    <th width="10%">Category</th>
                                    <th width="15%">Priority</th>
                                    <th width="9%">Status</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($list as $i => $p)
                                    <tr>
                                        <td>{{ $list->firstItem() + $i }}</td>
                                        <td>
                                            @if ($p->product_image)
                                                <img src="{{ asset($p->product_image) }}"
                                                    style="width:70px;height:50px;object-fit:cover;border-radius:4px;">
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td>
                                            <div class="fw-semibold">{{ $p->product_name }}</div>
                                            <div class="text-muted small">{{ $p->slug }}</div>
                                        </td>
                                        <td class="small">
                                            {{ $p->category->strCategoryName ?? '—' }} /
                                            {{ $p->subcategory->strSubCategoryName ?? '—' }}
                                        </td>
                                        <td class="small px-3">
                                            <select name="priority" class="form-control priority-select"
                                                data-id="{{ $p->product_id }}">
                                                <option value="">Please Select</option>
                                                <option value="1" {{ $p->priority == 1 ? 'selected' : '' }}>1</option>
                                                <option value="2" {{ $p->priority == 2 ? 'selected' : '' }}>2</option>
                                                <option value="3" {{ $p->priority == 3 ? 'selected' : '' }}>3</option>
                                                <option value="1000" {{ $p->priority == 1000 ? 'selected' : '' }}>None
                                                </option>
                                            </select>
                                        </td>

                                        <td>
                                            <form method="POST"
                                                action="{{ route('admin.products.toggle-status', $p->product_id) }}">
                                                @csrf
                                                <button
                                                    class="btn btn-sm {{ $p->iStatus ? 'btn-success' : 'btn-outline-secondary' }}"
                                                    type="submit">
                                                    {{ $p->iStatus ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="d-flex gap-2">
                                            <a href="{{ route('admin.products.edit', $p->product_id) }}"
                                                class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>

                                            <a href="{{ route('admin.products.bestproduct', $p->product_id) }}"
                                                class="btn btn-sm btn-primary">
                                                {!! $p->best_product ? '<i class="fa-solid fa-crown"></i>' : '<i class="fa-solid fa-trophy"></i>' !!}
                                            </a>


                                            <a href="{{ route('admin.product-images.index', $p->product_id) }}"
                                                class="btn btn-sm btn-success" title="Add Images">
                                                <i class="fa fa-plus"></i>
                                            </a>

                                            <a href="{{ route('admin.product-videos.index', $p->product_id) }}"
                                                class="btn btn-sm btn-outline-primary" title="Add Videos"><i
                                                    class="fa fa-video"></i></a>


                                            <form method="POST"
                                                action="{{ route('admin.products.delete', $p->product_id) }}"
                                                onsubmit="return confirm('Delete this product?')" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No records.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">{{ $list->links() }}</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            let updatePriorityUrl = "{{ route('admin.products.updatePriority') }}";

            $('.priority-select').change(function() {

                let id = $(this).data('id');
                let priority = $(this).val();

                $.ajax({
                    url: updatePriorityUrl,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id,
                        priority: priority
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error("Failed to update priority.");
                        }
                    },
                    error: function() {
                        toastr.error("Something went wrong!");
                    }
                });
            });
        });
    </script>

@endsection
