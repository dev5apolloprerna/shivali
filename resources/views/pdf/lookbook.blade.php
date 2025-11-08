<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
        }

        .product-box {

            margin-bottom: 24px;
        }

        .productbox {

            text-align: center;
        }

        /* .product-img {
            width: 180px;
            height: auto;
        } */

        .title {
            font-size: 20px;
            text-transform: capitalize;
            font-weight: bold;
            margin: 8px 0;
        }

        .dbg {
            color: #777;
            font-size: 11px;
            line-height: 1.3;
        }

        hr {
            margin: 16px 0;
        }
    </style>
</head>

<body>
    <h2>{{ $category->strCategoryName }} - Lookbook</h2>
    <hr>

    @foreach ($products as $p)
        <div class="product-box">
            <p class="title">{{ $p->product_name }}</p>
            <div class="productbox">

                <img class="product-img" src="{{ $p->pdf_img_src }}" alt="{{ $p->product_name }}">
            </div>

            <p>{!! $p->description !!}</p>
        </div>
        <hr>
    @endforeach
</body>

</html>
