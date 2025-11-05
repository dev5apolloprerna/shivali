@extends('layouts.front')
@section('content')
    <!-- Breadcrumb -->
    <section class="page-title  text-center ">
        <div class="container">
            <h3 class="heading mb-2">Our Products </h3>
            <ul class="breadcrumbs d-flex justify-content-center align-items-center">
                <li><a href="index.html" class="link">Home</a></li>
                <li><i class="fa fa-arrow-right mx-2"></i></li>
                <li>Products</li>
            </ul>
        </div>
    </section>

    <div class="container py-5">
        <h2 class="text-center mb-5"> Bridal Collection</h2>

        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 ">
                <div class="sidebar">
                    <h5>Refine Your Search</h5>
                    <div class="accordion" id="filterAccordion">

                        <div class="accordion-item">
                            <h6 class="accordion-header" id="headingZero">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseZero" aria-expanded="true" aria-controls="collapseOne">
                                    Theme
                                </button>
                            </h6>
                            <div id="collapseZero" class="accordion-collapse collapse show" aria-labelledby="headingZero"
                                data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" checked> <label
                                            class="form-check-label">Contemporary</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label
                                            class="form-check-label">Ethnic</label></div>

                                </div>
                            </div>
                        </div>

                        <!-- Category -->
                        <div class="accordion-item">
                            <h6 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapse" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Category
                                </button>
                            </h6>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" checked> <label
                                            class="form-check-label">Lehenga Sets</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label
                                            class="form-check-label">Sarees</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label
                                            class="form-check-label">Anarkalis</label></div>
                                </div>
                            </div>
                        </div>

                        <!-- Color -->
                        <div class="accordion-item">
                            <h6 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Color
                                </button>
                            </h6>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" checked> <label
                                            class="form-check-label">Red</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label
                                            class="form-check-label">Pink</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label
                                            class="form-check-label">Gold</label></div>
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="accordion-item">
                            <h6 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Occasions
                                </button>
                            </h6>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                data-bs-parent="#filterAccordion">
                                <div class="accordion-body">
                                    <div class="form-check"><input class="form-check-input" type="checkbox" checked>
                                        <label class="form-check-label">Wedding</label>
                                    </div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label
                                            class="form-check-label">Party Were</label></div>
                                    <div class="form-check"><input class="form-check-input" type="checkbox"> <label
                                            class="form-check-label">Special Day</label></div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <button class="btn filter-btn mt-4">Apply Filters</button>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class=" g-4">

                    <!-- <p class="text-uppercase small text-muted mb-1">Curated Lehengas</p> -->
                    <div class="sort-bar d-flex justify-content-end align-items-end mb-2  ">
                        <!-- <h2 class="section-title mb-0">Wedding & Festive Lehengas</h2> -->
                        <div class="dropdown">
                            <button class="btn btn-light border rounded-3 dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Sort by <strong>Recommended</strong>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Recommended</a></li>
                                <li><a class="dropdown-item" href="#">Price: Low to High</a></li>
                                <li><a class="dropdown-item" href="#">Price: High to Low</a></li>
                                <li><a class="dropdown-item" href="#">Newest</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- <small class="text-muted d-block mb-4">12 items • ship in 10–15 days</small> -->
                </div>
                <div class="row row-cols-2 row-cols-md-3 g-4">

                    <!-- Product 1 -->
                    @foreach ($products as $product)
                        <div class="col">
                            <div class="product-card">
                                <div class="product-img">
                                    <span class="badge-new">New</span>
                                    <img src="{{ asset($product->product_image ?? '') }}" alt="Ivory Floral Lehenga">
                                </div>
                                <div class="product-info">
                                    <div class="brand">{{ $product->subcategory->strSubCategoryName ?? '' }}</div>
                                    <div class="product-name">{{ $product->product_name ?? '' }}</div>
                                    <button class="btn btn-dark px-4 py-2 rounded-pill">Inquire Now</button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
