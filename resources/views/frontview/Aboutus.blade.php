@extends('layouts.front')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h3 class="heading p-0 m-0">About Our Store</h3>
                    <ul class="breadcrumbs d-flex ">
                        <li><a class="link" href="{{ route('front.index') }}">Homepage</a></li>
                        <li><i class="fa-solid fa-caret-right"></i></li>
                        
                        
                        
                       
                        <li>About Our Brand</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Redesigned About Us Section -->
    <section class="about-us-section py-5">
        <div class="container-fluid">
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
                        <p class=" text-muted mb-4">
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

                        
                    </div>
                </div>
            </div>
        </div>
    </section>

 
@endsection
