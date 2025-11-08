@extends('layouts.front')
@section('content')
    @php
        use Illuminate\Support\Str;

        /* --------- Build media lists --------- */
        $images = [];
        $push = function ($p) use (&$images) {
            if (!$p) {
                return;
            }
            $url = Str::startsWith($p, ['http://', 'https://']) ? $p : asset(ltrim($p, '/'));
            if (!in_array($url, $images, true)) {
                $images[] = $url;
            }
        };

        // primary + gallery
        $push($product->product_image ?? null);
        foreach ($product->productimage as $img) {
            if (($img->isDelete ?? 0) == 0) {
                $push($img->image ?? null);
            }
        }

        // collect YouTube ids (ignore empty / non-YouTube safely)
        $videoIds = [];
        foreach ($product->videos as $vid) {
            $url = (string) ($vid->video_link ?? '');
            if (!$url) {
                continue;
            }
            if (
                preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]+)/', $url, $m)
            ) {
                $videoIds[] = $m[1];
            }
        }

        $totalMedia = count($images) + count($videoIds);
        $hideThumbs = $totalMedia <= 1;

        /* --------- Decide first (main) media --------- */
        // Prefer image as default (Amazon-like). If no images, use first video.
        if (count($images) > 0) {
            $firstMedia = ['type' => 'image', 'src' => $images[0]];
        } elseif (count($videoIds) > 0) {
            // keep only the id; we’ll embed as big player
            $firstMedia = ['type' => 'video', 'src' => $videoIds[0]];
        } else {
            $firstMedia = null;
        }
    @endphp

    <section class="product-detail py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <div class="product-gallery d-flex">
                        {{-- Thumbs rail (hidden when only one media) --}}
                        @unless ($hideThumbs)
                            <div class="thumb-list d-flex flex-column me-3" style="width:120px; overflow-y:auto;">
                                {{-- images --}}
                                @foreach ($images as $imgUrl)
                                    <img src="{{ $imgUrl }}" class="thumbnail border rounded mb-2" data-type="image"
                                        data-src="{{ $imgUrl }}"
                                        style="width:100%; height:90px; object-fit:cover; cursor:pointer;">
                                @endforeach

                                {{-- videos as mini YouTube players (no autoplay) --}}
                                @foreach ($product->videos as $vid)
                                    @php
                                        $videoThumb = asset('/uploads/frontend/images/video-thumb.jpg');

                                        $videoSrc = $vid->video_link;
                                    @endphp
                                    <img src="{{ $videoThumb }}" class="thumbnail border rounded mb-2" data-type="video"
                                        data-src="{{ $videoSrc }}"
                                        style="width:100%; height:90px; object-fit:cover; cursor:pointer;">
                                @endforeach
                            </div>
                        @endunless

                        {{-- Main media --}}
                        <div class="main-media flex-grow-1" style="flex:1;">
                            @if ($firstMedia)
                                @if ($firstMedia['type'] === 'image')
                                    <img id="mainProductMedia" src="{{ $firstMedia['src'] }}"
                                        alt="{{ $product->product_name }}" class="w-100 rounded-3">
                                @else
                                    <iframe id="mainProductMedia" width="100%" height="400"
                                        src="https://www.youtube.com/embed/{{ $firstMedia['src'] }}?autoplay=1&mute=1&loop=1"
                                        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen
                                        class="w-100 rounded-3"></iframe>
                                @endif
                            @else
                                <img id="mainProductMedia" src="{{ asset('frontend/images/no-image.jpg') }}"
                                    class="w-100 rounded-3" alt="No image">
                            @endif
                        </div>
                    </div>
                </div>

                {{-- right column with product info ... (unchanged) --}}
                <div class="col-lg-7">
                    <div class="product-info">
                        <h2 class="mb-3">{{ $product->product_name }}</h2>
                        <p class="text-muted">{!! $product->description !!}</p>
                        <div class="d-flex gap-3 mt-4 mb-4">
                            <a href="{{ route('front.contactus') }}" class="btn btn-dark px-4 py-2 rounded-pill">
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
                        <div class="card border-0 shadow-sm"> <img src="{{ asset($rel->product_image ?? 'no-image.jpg') }}"
                                class="card-img-top rounded-3" alt="{{ $rel->product_name }}">
                            <div class="card-body text-center">
                                <h6 class="fw-semibold mb-1">{{ $rel->product_name }}</h6> <a
                                    href="{{ route('productdetail', [$product->category->strSlug ?? '', $rel->slug]) }}"
                                    class="btn btn-sm btn-outline-dark rounded-pill"> View </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @push('styles')
        <style>
            .thumb-list img,
            .thumb-list iframe {
                border: 2px solid #eee;
                transition: .2s
            }

            .thumb-list img.active,
            .thumb-list iframe.active,
            .thumb-list img:hover,
            .thumb-list iframe:hover {
                border-color: #d4a762;
                transform: scale(1.03)
            }
        </style>
    @endpush

@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const thumbs = document.querySelectorAll('.thumb-list img, .thumb-list iframe');
            const container = document.querySelector('.main-media');
            if (!thumbs || thumbs.length === 0) return; // nothing to bind when single media

            thumbs.forEach(el => {
                el.addEventListener('click', function() {
                    thumbs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');

                    const src = this.getAttribute('data-src') || '';
                    const type = this.getAttribute('data-type') || 'image';

                    let html = '';
                    if (type === 'video') {
                        const m = src.match(
                            /(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/|shorts\/))([a-zA-Z0-9_-]+)/
                        );
                        const id = m ? m[1] : '';
                        html = `
          <iframe class="w-100 rounded-3" height="400"
                  src="https://www.youtube.com/embed/${id}?autoplay=1&mute=1&loop=1"
                  frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        `;
                    } else {
                        html = `<img src="${src}" class="w-100 rounded-3" alt="Product">`;
                    }
                    container.innerHTML = html;
                });
            });
        });
    </script>
@endsection
