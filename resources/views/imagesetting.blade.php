@extends('layouts.app')

@section('title', 'Image Size Settings')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4 border-bottom">
                    <h1 class="h3 mb-0 text-gray-800">Image Size Settings</h1>
                </div>

                <!-- Card -->
                <div class="card shadow-sm">
                    {{-- <div class="card-header bg-secondary text-white">
                        <h4 class="mb-0">Static Image Sizes</h4>
                    </div> --}}

                    <div class="card-body">
                        {{-- <p class="text-muted mb-4">
                            Below are the fixed image dimensions used for each module.
                            These values are predefined and cannot be changed from this page.
                        </p> --}}

                        <table class="table table-bordered text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Type</th>
                                    <th>Recommended Size (px)</th>
                                    {{-- <th>Preview</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Banner Image</strong></td>
                                    <td>1300 × 650</td>
                                    {{-- <td>
                                        <img src="{{ asset('assets/images/dummy/category.jpg') }}" alt="Category"
                                            style="width:80px; height:80px; object-fit:cover;" class="rounded shadow-sm">
                                    </td> --}}
                                </tr>
                                <tr>
                                    <td><strong>Category Image</strong></td>
                                    <td>1313 × 615</td>
                                    {{-- <td>
                                        <img src="{{ asset('assets/images/dummy/category.jpg') }}" alt="Category"
                                            style="width:80px; height:80px; object-fit:cover;" class="rounded shadow-sm">
                                    </td> --}}
                                </tr>

                                <tr>
                                    <td><strong>Subcategory Image</strong></td>
                                    <td>310 × 345</td>
                                    {{-- <td>
                                        <img src="{{ asset('assets/images/dummy/subcategory.jpg') }}" alt="Subcategory"
                                            style="width:80px; height:80px; object-fit:cover;" class="rounded shadow-sm">
                                    </td> --}}
                                </tr>

                                <tr>
                                    <td><strong>Product Image</strong></td>
                                    <td>310 × 388</td>
                                    {{-- <td>
                                        <img src="{{ asset('assets/images/dummy/product.jpg') }}" alt="Product"
                                            style="width:80px; height:80px; object-fit:cover;" class="rounded shadow-sm">
                                    </td> --}}
                                </tr>
                            </tbody>
                        </table>

                        <p class="text-muted mt-3">
                            <i class="mdi mdi-information-outline"></i>
                            For best results, upload images matching or close to these sizes.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        body,
        .main-content,
        .page-content {
            overflow-y: auto !important;
            height: auto !important;
        }
    </style>
@endsection
