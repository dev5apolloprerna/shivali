   @extends('layouts.front')
   @section('content')
       {{-- <div class="page-title">
           <div class="container-fluid">
               
                   <div class="col-12">
                       <h3 class="heading ">All Product</h3>
                       <ul class="breadcrumbs d-flex align-items-center ">
                           <li><a class="link" href="{{ route('front.index') }}">Homepage</a></li>
                           <li><i class="fa fa-arrow"></i></li>
                           <li>Inquiry</li>
                       </ul>
                   </div>
               
           </div>
       </div> --}}
       <!-- Best Seller -->
       <section>
           <div class="container-fluid pb-5">
               <div class="sect-title text-center wow fadeInUp"style="padding-top:5px!important">
                   <h2 class="title " style="margin-bottom:10px!important">All Product</h2>
                   <div class=" d-flex justify-content-end">
                       <a href="{{ route('lookbook.pdf', $category->strSlug) }}" class="" title="Download"> <i class="fas fa-download fa-2x"></i></a>
                   </div>
               </div>
               <div class="row g-4 pb-3">
                   @foreach ($products as $product)
                       <div class=" col-lg-3 col-md-4 col-sm-6 col-6">
                           <div class=" product-card">
                               <a href="#" class="product-img product-img-2">
                                   <img class="lazyload img-product" src="{{ asset($product->product_image) }}"
                                       data-src="{{ asset($product->product_image) }}" alt="Product">
                                   <img class="lazyload img-hover" src="{{ asset($product->product_image) }}"
                                       data-src="{{ asset($product->product_image) }}" alt="Product">
                               </a>


                           </div>
                          

                       </div>
                   @endforeach


               </div>
           </div>

       </section>
       <!-- /Best Seller -->
   @endsection
