@extends('layouts.front')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="container-full">
            <div class="row">
                <div class="col-12">
                    <h3 class="heading text-center">About Our Store</h3>
                    <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                        <li><a class="link" href="{{ route('front.index') }}">Homepage</a></li>
                        <li><i class="fa fa-arrow-right"></i></li>
                        <li>About Our Store</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Redesigned About Us Section -->
    <section class="about-us-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <!-- Image -->
                <div class="col-lg-6 mb-4 mb-lg-0 wow fadeInLeft">
                    <div class="position-relative">
                        <img src="{{ asset('assets/front/images/about-img.jpg') }}" alt="About Shivali"
                            class="img-fluid rounded-4 shadow-lg">
                        <div class="overlay-gradient position-absolute top-0 start-0 w-100 h-100 rounded-4"></div>
                    </div>
                </div>

                <!-- Content -->
                <div class="col-lg-6 wow fadeInRight">
                    <div class="about-content ps-lg-4">
                        <h2 class="display-5 fw-bold mb-3" style="color:#222;">About Us</h2>
                        <hr class="mb-4"
                            style="width:120px; height:3px; border:none; background:linear-gradient(90deg,transparent,#d4af37,transparent);">
                        <p class="lead text-muted mb-4">
                            Founded in 1988 by <strong>Shivkumar Gogia</strong>, <span class="fw-semibold">Shivali</span>
                            began as a vision to redefine Indian ethnic wear with authenticity, creativity, and excellence.
                            What started as a one-man dedication has grown into <strong>India’s No. 1 wholesale ethnic
                                brand</strong>, trusted by thousands of retailers nationwide.
                        </p>
                        <p class="text-muted mb-4">
                            Every piece we design is a blend of tradition and innovation—crafted to inspire confidence and
                            cultural pride.
                            With a legacy built on trust and artistry, Shivali continues to set benchmarks in ethnic fashion
                            as a most reliable B2B partner for retailers.
                        </p>
                        <p class="text-muted mb-5">
                            More than a brand, Shivali is a story of perseverance, vision, and iconic style — where every
                            thread speaks of passion and heritage.
                        </p>

                        <a href="#" class="btn btn-dark px-4 py-2 rounded-pill"
                            style="background:#d4af37; border:none;">
                            Learn More <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="mission-vision py-5" style="background:#fffdf8;">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold mb-3" style="font-family:'Playfair Display',serif;">Our Mission & Vision</h2>
                    <hr class="mx-auto"
                        style="width:150px; height:3px; border:none; background:linear-gradient(90deg,transparent,#d4af37,transparent);">
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-6 wow fadeInUp">
                    <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
                        <div class="icon mb-3 text-center">
                            <i class="fa-solid fa-bullseye fs-1" style="color:#d4af37;"></i>
                        </div>
                        <h4 class="fw-semibold text-center mb-3">Our Mission</h4>
                        <p class="text-muted text-center">
                            To create timeless ethnic wear that celebrates India’s rich heritage while embracing modern
                            craftsmanship.
                            We aim to empower retailers with high-quality designs, seamless service, and consistent
                            innovation.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="card border-0 shadow-sm p-4 h-100 rounded-4">
                        <div class="icon mb-3 text-center">
                            <i class="fa-solid fa-eye fs-1" style="color:#d4af37;"></i>
                        </div>
                        <h4 class="fw-semibold text-center mb-3">Our Vision</h4>
                        <p class="text-muted text-center">
                            To be the global symbol of Indian ethnic excellence—blending traditional elegance with
                            contemporary trends
                            and setting new standards in quality, innovation, and sustainability.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="fw-bold mb-3" style="font-family:'Playfair Display',serif;">Why Choose Shivali</h2>
                    <hr class="mx-auto"
                        style="width:150px; height:3px; border:none; background:linear-gradient(90deg,transparent,#d4af37,transparent);">
                    <p class="text-muted">Discover why thousands of retailers trust us as their premium ethnic wear partner.
                    </p>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-4 wow fadeInUp">
                    <div class="feature-box p-4 text-center shadow-sm rounded-4 bg-white h-100">
                        <i class="fa-solid fa-gem fs-1 mb-3" style="color:#d4af37;"></i>
                        <h5 class="fw-semibold mb-2">Premium Quality</h5>
                        <p class="text-muted small mb-0">Each piece is crafted with exceptional attention to detail and the
                            finest fabrics.</p>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="feature-box p-4 text-center shadow-sm rounded-4 bg-white h-100">
                        <i class="fa-solid fa-palette fs-1 mb-3" style="color:#d4af37;"></i>
                        <h5 class="fw-semibold mb-2">Innovative Designs</h5>
                        <p class="text-muted small mb-0">We constantly blend traditional artistry with modern styles for
                            trend-setting creations.</p>
                    </div>
                </div>
                <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                    <div class="feature-box p-4 text-center shadow-sm rounded-4 bg-white h-100">
                        <i class="fa-solid fa-handshake fs-1 mb-3" style="color:#d4af37;"></i>
                        <h5 class="fw-semibold mb-2">Trusted Partnership</h5>
                        <p class="text-muted small mb-0">With decades of experience, we’re known for reliability,
                            transparency, and excellence.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
