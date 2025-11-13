<!DOCTYPE html>
<html>

<head>
    <style>
        @page {
            margin: 0;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            line-height: 0;
            font-size: 0;
        }

        /* ✅ Centered Heading */
        .header {
            text-align: center;
            page-break-after: avoid;
            padding: 40px 0 20px;
        }

        .header h2 {
            font-size: 28pt;
            font-weight: bold;
            color: #000;
            margin: 0;
            line-height: 1.3;
        }

        .header hr {
            border: none;
            border-top: 2px solid #000;
            width: 60%;
            margin: 15px auto 0;
        }

        /* ✅ Product container */
        .product-box {
            text-align: center;
            margin: 0;
            padding: 0;
        }

        /* ✅ Start new page after each image except the first */
        .product-box:not(:first-of-type) {
            page-break-before: always;
        }

        .product-img {
            width: 100%;
            height: 100vh;
            object-fit: cover;
            border: none;
            display: block;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>

    {{-- ✅ Centered heading, shown once --}}
    <div class="header">
        <h2>{{ $category->strCategoryName }}</h2>
        <hr>
    </div>

    {{-- ✅ Each image on a full page, no blank pages --}}
    @foreach ($products as $p)
        <div class="product-box">
            <img class="product-img" src="{{ $p->pdf_img_src }}" alt="{{ $p->product_name }}">
        </div>
    @endforeach

</body>

</html>
