@extends('layouts.front')
@section('content')
    <section class="page-title">
        <div class="container">
            <h3 class="heading mb-2">Our Products</h3>
            <ul class="breadcrumbs d-flex ">
                <li><a href="{{ url('/') }}" class="link">Home</a></li>
                <li><i class="fa fa-arrow-right mx-2"></i></li>
                <li>Products</li>
            </ul>
        </div>
    </section>

    <div class="container py-5">
        <h2 class="text-center mb-5">Bridal Collection</h2>
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="sidebar">
                    <h5>Refine Your Search</h5>

                    {{-- ✅ Begin Filter Form --}}
                    <form method="post" action="{{ route('productlist', request()->route('slugname')) }}">
                        @csrf
                        <div class="accordion" id="filterAccordion">
                            {{-- 🔹 Tags Filter --}}
                            <div class="accordion-item">
                                <h6 class="accordion-header" id="headingZero">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseZero" aria-expanded="true">
                                        Categories
                                    </button>
                                </h6>
                                <div id="collapseZero" class="accordion-collapse collapse show"
                                    aria-labelledby="headingZero" data-bs-parent="#filterAccordion">
                                    <div class="accordion-body">
                                        @foreach ($tagmaster as $tag)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="tags[]"
                                                    value="{{ $tag->id }}"
                                                    {{ in_array($tag->id, request()->get('tags', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label">{{ $tag->Name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- ✅ Preserve sorting --}}
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        <input type="submit" class="btn filter-btn mt-4 w-100" value="Apply Filters">
                    </form>

                    {{-- ✅ End Filter Form --}}
                </div>
            </div>


            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-end align-items-end mb-3">
                    {{-- ✅ Sort Form --}}
                    <form method="POST" action="{{ route('productlist', request()->route('slugname')) }}">
                        @csrf

                        {{-- Preserve currently selected filters --}}
                        @foreach (request()->except('sort', '_token') as $key => $value)
                            @if (is_array($value))
                                @foreach ($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach

                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Sort by Recommended</option>
                            <option value="Recommended" {{ request('sort') == 'Recommended' ? 'selected' : '' }}>
                                Recommended</option>
                            <option value="best-product" {{ request('sort') == 'best-product' ? 'selected' : '' }}>Best
                                Selling</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                    </form>
                </div>

                <div class="row row-cols-2 row-cols-md-3 g-4">
                    @forelse ($products as $product)
                        <div class="col">
                            <div class="product-card">
                                <div class="product-img">
                                    <span class="badge-new">New</span>
                                    <a
                                        href="{{ route('productdetail', [$product->category->strSlug ?? '', $product->slug]) }}">
                                        <img src="{{ asset($product->product_image ?? 'default.jpg') }}"
                                            alt="{{ $product->product_name }}">
                                    </a>
                                </div>
                                <div class="product-info">
                                    <div class="product-name">{{ $product->product_name ?? '' }}</div>
                                    <a href="{{ route('front.contactus') }}"
                                        class="btn btn-dark px-4 py-2 rounded-pill">Inquire Now</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5">
                            <h5>No products found.</h5>
                        </div>
                    @endforelse
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
