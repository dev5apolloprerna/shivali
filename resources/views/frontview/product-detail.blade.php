@extends('layouts.front')
@section('content')
    <!-- Breadcrumb -->
    <section class="page-title text-center">
        <div class="container">
            <h3 class="heading mb-2">Product Details</h3>
            <ul class="breadcrumbs d-flex justify-content-center align-items-center">
                <li><a href="{{ url('/') }}" class="link">Home</a></li>
                <li><i class="fa fa-arrow-right mx-2"></i></li>
                <li>{{ $product->product_name }}</li>
            </ul>
        </div>
    </section>

    <section class="product-detail py-5">
        <div class="container">
            <div class="row g-5">

                <!-- Product Images -->
                <div class="col-lg-5">
                    <div class="product-gallery d-flex">
                        <div class="thumb-list d-flex flex-column me-3">
                            @foreach ($product->productimage as $img)
                                <img src="{{ asset($img->image) }}" alt="Thumbnail" onclick="changeImage(this);"
                                    class="{{ $loop->first ? 'active' : ' ' }}">
                            @endforeach
                        </div>

                        <div class="main-image flex-grow-1">
                            <img id="mainProductImage" src="{{ asset($product->product_image ?? 'no-image.jpg') }}"
                                alt="{{ $product->product_name }}">
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="col-lg-7">
                    <div class="product-info">
                        <h2 class="fw-bold mb-3" style="color:#222;">{{ $product->product_name }}</h2>
                        <p class="text-muted mb-5 pb-5">{!! $product->description !!}</p>
                        <div class="d-flex gap-3 mb-4">
                            <a href="#" class="btn btn-dark px-4 py-2 rounded-pill">
                                Inquiry now <i class="fa fa-info ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Related Products -->
    <section class="related-products py-5">
        <div class="container">
            <h3 class="fw-bold text-center mb-5">You May Also Like</h3>
            <div class="row g-4">
                @foreach ($relatedProducts as $rel)
                    <div class="col-md-3 col-6">
                        <div class="card border-0 shadow-sm">
                            <img src="{{ asset($rel->product_image ?? 'no-image.jpg') }}" class="card-img-top rounded-3"
                                alt="{{ $rel->product_name }}">
                            <div class="card-body text-center">
                                <h6 class="fw-semibold mb-1">{{ $rel->product_name }}</h6>
                                <a href="{{ route('productdetail', [$product->category->strSlug ?? '', $rel->slug]) }}"
                                    class="btn btn-sm btn-outline-dark rounded-pill">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function changeImage(element) {
            // get the clicked thumbnail's src
            const newSrc = element.getAttribute('src');

            // update main image
            const mainImage = document.getElementById('mainProductImage');
            if (mainImage) {
                mainImage.setAttribute('src', newSrc);
            }

            // remove 'active' class from all thumbnails
            document.querySelectorAll('.thumb-list img').forEach(img => {
                img.classList.remove('active');
            });

            // add 'active' to the clicked one
            element.classList.add('active');
        }
    </script>
@endsection
