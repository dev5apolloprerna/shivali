@extends('layouts.front')
@section('content')
    <section class="hero mx-2">
        <video autoplay muted loop playsinline>
            <source src="{{ asset('assets/front/images/hero.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="overlay"></div>
        <div class="hero-content">
            <h1>The Essence of Iconic Elegance</h1>
            <p> Crafted for women who define tradition with grace. ✨</p>
            <button>Get Started</button>
        </div>
    </section>

    <!-- Banner Slider -->
    <div class="tf-slideshow type-abs tf-btn-swiper-main hover-sw-nav m-2">
        <div dir="ltr" class="swiper tf-swiper sw-slide-show slider_effect_fade" data-auto="true" data-loop="true"
            data-effect="fade" data-delay="3000">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <div class="slider-wrap style-2">
                            <div class="sld_image">
                                <img src="{{ asset('uploads/Banner/' . $banner->image) }}"
                                    data-src="{{ asset('uploads/Banner/' . $banner->image) }}" alt="Slider"
                                    class="lazyload scale-item">
                            </div>
                            <div class="sld_content type-center text-sm-center">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-sm-8 col-10">
                                            <div class="content-sld_wrap">
                                                <p class="sub-title_sld h3 text-primary fade-item fade-item-1">
                                                    The Essence of Iconic Elegance
                                                </p>
                                                <h1 class="title_sld  text-white fade-item fade-item-2">
                                                    Crafted for women who define tradition with grace.
                                                </h1>
                                                <p class="sub-text_sld h5 text-white fade-item fade-item-3">
                                                    Step into a world of timeless ethnic wear where every piece is a
                                                    work of art. Shivali blends heritage craftsmanship with refined
                                                    style, curating ensembles that exude luxury, sophistication, and
                                                    lasting charm.
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="sw-dot-default tf-sw-pagination"></div>
        </div>
        <div class="tf-sw-nav nav-prev-swiper">
            <i class="icon icon-caret-left"></i>
        </div>
        <div class="tf-sw-nav nav-next-swiper">
            <i class="icon icon-caret-right"></i>
        </div>
    </div>
    <!-- Banner Slider -->

    <!-- Collection -->
    <section class="">

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-sm-6 col-5 p-0">
                    <div style="padding-left:10px" class="sect-title">
                        <h2 class="text-start mb-4 title">
                            New In</h2>
                        <p class="text-start mb-4">New arrivals, now dropping five days a week - discover the latest
                            launches onsite.</p>
                        <h4><a href="#">EXPLORE NOW</a></h4>
                    </div>

                </div>
                <div class="col-lg-9 col-md-6 col-7">
                    <div dir="ltr" class="swiper tf-swiper" data-preview="4" data-tablet="3" data-mobile-sm="2"
                        data-mobile="1" data-pagination="1" data-space-lg="24" data-space-md="15" data-space="10"
                        data-pagination-sm="1" data-pagination-md="2" data-pagination-lg="2" data-auto="true"
                        data-speed="3000">
                        <div class="swiper-wrapper" data-loop="true">
                            <!-- item 1 -->
                            @foreach ($newinProducts as $product)
                                <div class="swiper-slide">
                                    <div class="wg-cls-2 type-space-2 d-flex hover-img">
                                        <a href="{{ route('productdetail', [$product->category->strSlug ?? '', $product->slug]) }}"
                                            class="image img-style">
                                            <img class="lazyload" src="{{ asset($product->product_image) }}"
                                                data-src="{{ asset($product->product_image) }}" alt="Slider">
                                        </a>
                                        <div class="cls-content_wrap name">
                                            <div class="cls-content ">
                                                <a href="{{ route('productdetail', [$product->category->strSlug ?? '', $product->slug]) }}"
                                                    class="tag_cls   link">{{ $product->product_name }}</a>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-2">

        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-9 col-md-6 col-7">
                    <div dir="ltr" class="swiper tf-swiper" data-preview="4" data-tablet="3" data-mobile-sm="2"
                        data-mobile="1" data-pagination="1" data-space-lg="24" data-space-md="15" data-space="10"
                        data-pagination-sm="1" data-pagination-md="2" data-pagination-lg="2" data-auto="true"
                        data-speed="3000">
                        <div class="swiper-wrapper" data-loop="true">
                            <!-- item 1 -->
                            @foreach ($bestProducts as $bestpro)
                                <div class="swiper-slide">
                                    <div class="wg-cls-2 type-space-2 d-flex hover-img">
                                        <a href="{{ route('productdetail', [$bestpro->category->strSlug ?? '', $bestpro->slug]) }}"
                                            class="image img-style">
                                            <img class="lazyload" src="{{ asset($bestpro->product_image) }}"
                                                data-src="{{ asset($bestpro->product_image) }}" alt="Slider">
                                        </a>
                                        <div class="cls-content_wrap name">
                                            <div class="cls-content">
                                                <a href="{{ route('productdetail', [$bestpro->category->strSlug ?? '', $bestpro->slug]) }}"
                                                    class="tag_cls   link">{{ $bestpro->product_name ?? '' }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>

                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-5 p-0">
                    <div style="padding-left:0px" class="sect-title">
                        <h2 class="text-start mb-4 title">
                            Best Selling Designs</h2>
                        <p class="text-start mb-4">Our most-loved styles, chosen by you. Discover the designs everyone’s
                            talking about and make them yours.</p>
                        <h4><a href="#">EXPLORE NOW</a></h4>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- Collection -->

    <section class="bg-black pb-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="sect-title text-center wow fadeInUp py-3">
                    <h2 class="title mb-8 text-white">Explore by Occasion </h2>


                    <!-- <p class="s-subtitle h6">Lorem ipsum dolor sit amet, consectetur adipiscing elit</p> -->
                </div>
                <div dir="ltr" class="swiper tf-swiper" data-preview="4" data-tablet="3" data-mobile-sm="2"
                    data-mobile="2" data-pagination="1" data-space-lg="24" data-space-md="15" data-space="15"
                    data-pagination-sm="1" data-pagination-md="2" data-pagination-lg="2" data-auto="true"
                    data-speed="3000">
                    <div class="swiper-wrapper" data-loop="true">
                        @foreach ($explore_by_occasion as $subcat)
                            <div class="swiper-slide">
                                <div class="wg-cls-2 type-space-2 d-flex hover-img">
                                    <a href="{{ route('productlist', $subcat->strSlug) }}" class="image img-style">
                                        <img class="lazyload"
                                            src="{{ asset('uploads/subcategory-images/' . $subcat->subcategory_img) }}"
                                            data-src="{{ asset('uploads/subcategory-images/' . $subcat->subcategory_img) }}"
                                            alt="Slider">
                                    </a>
                                    <div class="cls-content_wrap ocation">
                                        <div class="cls-content">
                                            <a href="{{ route('productlist', $subcat->strSlug) }}"
                                                class="tag_cls   link">{{ $subcat->strSubCategoryName ?? '' }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Best Seller -->
    <section>
        <div class="container">
            <div class="sect-title text-center wow fadeInUp pt-3">
                <h2 class="title mb-8">Shop by style</h2>
            </div>
            <div class="row g-4">
                @foreach ($shop_by_style as $shoapby)
                    <div class="card-product col-lg-3 col-md-4 col-sm-6 col-6">
                        <div class="card-product_wrapper">
                            <a href="{{ route('productlist', $shoapby->strSlug) }}" class="product-img">
                                <img class="lazyload img-product"
                                    src="{{ asset('uploads/subcategory-images/' . $shoapby->subcategory_img) }}"
                                    data-src="{{ asset('uploads/subcategory-images/' . $shoapby->subcategory_img) }}"
                                    alt="Product">
                                <img class="lazyload img-hover"
                                    src="{{ asset('uploads/subcategory-images/' . $shoapby->subcategory_img) }}"
                                    data-src="{{ asset('uploads/subcategory-images/' . $shoapby->subcategory_img) }}"
                                    alt="Product">
                            </a>


                        </div>
                        <div class="card-product_info">
                            <a href="{{ route('productlist', $shoapby->strSlug) }}"
                                class="name-product">{{ $shoapby->strSubCategoryName ?? '' }}</a>


                        </div>
                        <div class="price-wrap">
                            <button class="tf-btn btn-primary" href="#shoppingCart" data-bs-toggle="offcanvas">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                        </div>

                    </div>
                @endforeach


            </div>
        </div>

    </section>
    <!-- /Best Seller -->

    <!-- Banner Lookbook -->
    <section class="about-banner style-2">
        <div class="container">
            <div class="banner-wrap hover-img wow fadeInUp pt-3">
                <a href="#" class="banner-image img-style">
                    <img src="{{ asset('uploads/category-images/' . $Categories->category_img) }}"
                        data-src="{{ asset('uploads/category-images/' . $Categories->category_img) }}" alt="Banner"
                        class="lazyload">
                </a>
                <div class="banner-content text-right col-lg-5">
                    <h6 class="title display-6 ">
                        <a href="#" class="link text-black fw-normal">
                            {{ $Categories->strCategoryName ?? '' }}
                        </a>
                    </h6>

                    <a href="#" class="tf-btn btn-white animate-btn animate-dark fw-normal">
                        Explore Now
                        <i class="icon icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>

    </section>
    <!-- /Banner Lookbook -->

    <section class="about-banner style-2 gap-1">
        <div class="container">
            <div class=" hover-img  row vid-sec pt-3">
                <div class="text-right col-lg-4 col-md-6    inner-box  py-2">
                    <div dir="ltr" class="swiper tf-swiper" data-preview="1" data-tablet="1" data-mobile-sm="1"
                        data-mobile="1" data-pagination="1" data-space-lg="0" data-space-md="0" data-space="0"
                        data-pagination-sm="1" data-loop="true" data-pagination-md="1" data-pagination-lg="1"
                        data-auto="true" data-speed="3000" data-effect="fade" data-delay="5000">
                        <div class="swiper-wrapper" data-loop="true">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <a href="#" class="img-style">
                                    <img src="{{ asset('assets/front/images/products/celebrity.webp') }}" alt="Banner">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#" class="img-style">
                                    <img src="{{ asset('assets/front/images/products/product-10.webp') }}"
                                        alt="Banner">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#" class="img-style">
                                    <img src="{{ asset('assets/front/images/products/product-1.webp') }}" alt="Banner">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="txtonimg">
                        <h6 class=" text-black text-center">
                            <a href="#" class="link text-black fw-normal">
                                Designs of the week
                            </a>
                        </h6>
                        <p class="text-center">Best product of the week</p>
                    </div>
                </div>
                <div class=" col-lg-4  col-md-6 inner-box   py-2">
                    <div dir="rtl" class="swiper tf-swiper" data-preview="1" data-tablet="1" data-mobile-sm="1"
                        data-mobile="1" data-pagination="1" data-space-lg="0" data-space-md="0" data-space="0"
                        data-pagination-sm="1" data-loop="true" data-pagination-md="1" data-pagination-lg="1"
                        data-auto="true" data-speed="3000" data-effect="fade" data-delay="5000">
                        <div class="swiper-wrapper" data-loop="true">
                            <!-- item 1 -->
                            <div class="swiper-slide">
                                <a href="#" class="img-style">
                                    <img src="{{ asset('assets/front/images/products/product-1.webp') }}" alt="Banner">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#" class="img-style">
                                    <img src="{{ asset('assets/front/images/products/product-3.webp') }}" alt="Banner">
                                </a>
                            </div>
                            <div class="swiper-slide">
                                <a href="#" class="img-style">
                                    <img src="{{ asset('assets/front/images/products/product-8.webp') }}" alt="Banner">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="txtonimg right">
                        <h6 class="title  text-black text-center">
                            <a href="#" class="link text-black fw-normal">
                                <span>Celebrity</span> Spotting


                            </a>
                        </h6>
                        <p class="text-center">Malaika Arora in DiyaRajvvir</p>
                    </div>
                </div>
                <div class=" col-lg-4  col-md-6 inner-box  d-none d-md-block">
                    <video autoplay muted loop playsinline>
                        <source src="{{ asset('assets/front/images/videoplayback.mp4') }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
        </div>

    </section>


    <section class="about-us style-2 py-3">
        <div class="container">
            <div class="row align-items-center wow fadeInUp">
                <!-- About Content -->
                <div class="col-lg-6 ps-lg-5 order-2 order-md-1 ">
                    <div class="sect-title text-left">
                        <h2 class="title mb-4 display-4 fw-bold text-center">
                            About Us
                        </h2>
                        <svg width="100%" height="3" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <linearGradient id="fade" x1="0%" y1="0%" x2="100%"
                                    y2="0%">
                                    <stop offset="0%" stop-color="#d4af37" stop-opacity="0" />
                                    <stop offset="50%" stop-color="#d4af37" stop-opacity="1" />
                                    <stop offset="100%" stop-color="#d4af37" stop-opacity="0" />
                                </linearGradient>
                            </defs>
                            <rect width="100%" height="2" fill="url(#fade)">
                                <animate attributeName="opacity" values="0.4;1;0.4" dur="3s"
                                    repeatCount="indefinite" />
                            </rect>
                        </svg>
                    </div>
                    <p class="sub-text h5 text-muted mb-4">
                        Founded in 1988 by Shivkumar Gogia, Shivali began as a vision to redefine Indian ethnic wear
                        with authenticity, creativity, and excellence. What started as dedication of one man -
                        working tirelessly day and night-has grown into India's No. 1 wholesale ethnic brand,
                        trusted by thousands of retailers across the country. At Shivali, we are not just
                        manufacturers - we are creators of experiences. Every piece we design is crafted to inspire
                        confidence, culture and set benchmarks in ethnic fashion. With a legacy built on trust and
                        innovation, we continue to lead the industry as a most reliable wholesale B2B partner for
                        ethnic wear.
                        Shivali is not just a brand-it's a story of perseverance, vision, and iconic style.
                    </p>

                    <a href="#" class="tf-btn  fw-normal">
                        Learn More
                        <i class="icon icon-arrow-right"></i>
                    </a>
                </div>
                <!-- About Image -->
                <div class="col-lg-6 mb-lg-0 mb-5 order-1 order-md-2">
                    <img src="{{ asset('assets/front/images/about-img.jpg') }}"
                        data-src="{{ asset('assets/front/images/about-img.jpg') }}" alt="About Us"
                        class="lazyload img-fluid rounded-3 shadow">
                </div>



            </div>
        </div>
    </section>
@endsection
