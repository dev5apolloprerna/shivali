   @extends('layouts.front')
   @section('content')
       {{-- <div class="page-title">
           <div class="container-full">
               <div class="row">
                   <div class="col-12">
                       <h3 class="heading text-center">All Product</h3>
                       <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                           <li><a class="link" href="{{ route('front.index') }}">Homepage</a></li>
                           <li><i class="fa fa-arrow"></i></li>
                           <li>Inquiry</li>
                       </ul>
                   </div>
               </div>
           </div>
       </div> --}}
       <!-- Best Seller -->
       <section>
           <div class="container pb-5">
               <div class="sect-title text-center wow fadeInUp"style="padding-top:5px!important">
                   <h2 class="title " style="margin-bottom:10px!important">All Product</h2>
                   <div class=" d-flex justify-content-end">
                       <a href="{{ route('lookbook.pdf', $category->strSlug) }}" class="btn btn-primary">Download</a>
                   </div>
               </div>
               <div class="row g-4 pb-3">
                   @foreach ($products as $product)
                       <div class="card-product col-lg-3 col-md-4 col-sm-6 col-6">
                           <div class="card-product_wrapper">
                               <a href="#" class="product-img">
                                   <img class="lazyload img-product" src="{{ asset($product->product_image) }}"
                                       data-src="{{ asset($product->product_image) }}" alt="Product">
                                   <img class="lazyload img-hover" src="{{ asset($product->product_image) }}"
                                       data-src="{{ asset($product->product_image) }}" alt="Product">
                               </a>


                           </div>
                           <div class="card-product_info">
                               {{-- <a href="{{ route('productlist', $shoapby->strSlug) }}" class="name-product"></a> --}}

                               {{-- <a href="{{ route('productlist', $shoapby->strSlug) }}"
                                class="name-product">{{ $shoapby->strSubCategoryName ?? '' }}</a> --}}
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
   @endsection
