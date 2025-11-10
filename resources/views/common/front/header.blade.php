 @php
     $categories = App\Models\Category::get();
 @endphp

 <div id="wrapper">
     <!-- Top Bar-->
     <div class="tf-topbar ">
         <div class="container">
             <div class="row">
                 <div class="col-xl-7 col-lg-8">
                     <div class="topbar-left">
                         <p class="text-up text-white fw-normal text-line-clamp-1">Welcome to Shivali Iconic Trend
                         </p>

                     </div>
                 </div>
                 <div class="col-xl-5 col-lg-4 d-none d-lg-block">
                     <ul class="topbar-right topbar-option-list">
                         <li class="">
                             <a href="#" class="text-white link"><i class="fa fa-phone"></i> +91 9123456789</a>
                         </li>
                         <li class="br-line"></li>
                         <li class="">
                             <a href="#" class="text-white link"><i class="fa fa-envelope"></i>
                                 info@shivali.com</a>
                         </li>

                     </ul>
                 </div>
             </div>
         </div>
     </div>
     <!-- /Top Bar -->
     <!-- Header -->
     <header class="tf-header header-fix header-abs-1">
         <div class="container-fluid">
             <div class="row align-items-center">

                 <div class="position-relative col-xl-3 col-md-4 col-6 d-flex justify-content-xl-start">
                     <a href="{{ route('front.index') }}" class="logo-site">
                         <img src="{{ asset('assets/front/images/logo/logo.png') }}"> </a>
                 </div>
                 <div class="col-xl-6 d-none d-xl-block">
                     <nav class="box-navigation">
                         <ul class="box-nav-menu">
                             <li class="menu-item">
                                 <a href="{{ route('front.index') }}" class="item-link">HOME</a>

                             </li>
                             <li class="menu-item">
                                 <a href="{{ route('front.about') }}" class="item-link">ABOUT US</a>

                             </li>
                             <li class="menu-item position-relative">
                                 <a href="javascript:void(0)" class="item-link">PRODUCT <i
                                         class="icon icon-caret-down"></i></a>
                                 <div class="sub-menu">
                                     <ul class="sub-menu_list">
                                         @foreach ($categories as $cat)
                                             <li><a href="{{ route('productlist', $cat->strSlug) }}"
                                                     class="sub-menu_link">{{ $cat->strCategoryName ?? '' }}</a></li>
                                         @endforeach


                                     </ul>
                                 </div>
                             </li>
                             <li class="menu-item">
                                 <a href="{{ route('front.contactus') }}" class="item-link">CONTACT US</a>

                             </li>

                         </ul>
                     </nav>
                 </div>
                 <div class="col-xl-3 col-md-4 col-3">
                     <!-- <ul class="nav-icon-list">
                            <li class="d-none d-lg-flex">
                                <a class="nav-icon-item link" href="login.html"><i class="icon icon-user"></i></a>
                            </li>
                            <li class="d-none d-md-flex">
                                <a class="nav-icon-item link" href="#search" data-bs-toggle="modal">
                                    <i class="icon icon-magnifying-glass"></i>
                                </a>
                            </li>
                            <li class="d-none d-sm-flex">
                                <a class="nav-icon-item link" href="wishlist.html"><i class="icon icon-heart"></i></a>
                            </li>
                            <li class="shop-cart" data-bs-toggle="offcanvas" data-bs-target="#shoppingCart">
                                <a class="nav-icon-item link" href="#shoppingCart" data-bs-toggle="offcanvas">
                                    <i class="icon icon-shopping-cart-simple"></i>
                                </a>
                                <span class="count">24</span>
                            </li>
                        </ul> -->
                 </div>
                 <div class="col-md-4 col-3 d-xl-none d-flex justify-content-end ">
                     <a href="#mobileMenu" data-bs-toggle="offcanvas" class="btn-mobile-menu">
                         <span></span>
                     </a>
                 </div>
             </div>
         </div>
     </header>

     <!-- Mobile Menu -->
     <div class="offcanvas offcanvas-start canvas-mb" id="mobileMenu">
         <span class="icon-close-popup" data-bs-dismiss="offcanvas">
             <i class="icon-close"></i>
         </span>
         <div class="canvas-header">
             <p class="text-logo-mb">
                 <img src="{{ asset('assets/front/assets/images/logo/logo.png') }}" alt="Logo">
             </p>
             <!-- <a href="login.html" class="tf-btn type-small style-2">
                Login
                <i class="icon icon-user"></i>
            </a> -->
             <span class="br-line"></span>
         </div>
         <div class="canvas-body">
             <div class="mb-content-top">
                 <ul class="nav-ul-mb" id="wrapper-menu-navigation"></ul>
             </div>
             <!-- <div class="group-btn">
                <a href="wishlist.html" class="tf-btn type-small style-2">
                    Wishlist
                    <i class="icon icon-heart"></i>
                </a>
                <div data-bs-dismiss="offcanvas">
                    <a href="#search" data-bs-toggle="modal" class="tf-btn type-small style-2">
                        Search
                        <i class="icon icon-magnifying-glass"></i>
                    </a>
                </div>
            </div> -->
             <div class="flow-us-wrap">
                 <h5 class="title">Follow us on</h5>
                 <ul class="tf-social-icon">
                     <li>
                         <a href="https://www.facebook.com/" target="_blank" class="social-facebook">
                             <span class="icon"><i class="icon-fb"></i></span>
                         </a>
                     </li>
                     <li>
                         <a href="https://www.instagram.com/shivaliahmedabad/" target="_blank" class="link">
                             <i class="icon-instagram-logo"></i>
                         </a>
                     </li>
                     <li>
                         <a href="https://www.youtube.com/@shivalifashion6925" target="_blank" class="link">
                             <i class="fab fa-youtube"></i>
                         </a>
                     </li>
                     <li>
                         <a href="https://x.com/" target="_blank" class="social-x">
                             <span class="icon"><i class="icon-x"></i></span>
                         </a>
                     </li>
                     <!-- <li>
                        <a href="https://www.tiktok.com/" target="_blank" class="social-tiktok">
                            <span class="icon"><i class="icon-tiktok"></i></span>
                        </a>
                    </li> -->
                 </ul>
             </div>

         </div>

     </div>
     <!-- /Mobile Menu -->
