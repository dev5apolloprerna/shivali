<!DOCTYPE html>
<html lang="en">


@include('common.front.head')

<body id="page-top">

    @include('common.front.header')

    @yield('content')

    @include('common.front.footer')

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    @include('common.front.footerjs')

    @yield('scripts')


</body>



</html>
