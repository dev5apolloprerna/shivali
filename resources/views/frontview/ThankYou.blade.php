@extends('layouts.front')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-7">
            <div class="thankyou-card">



<h1>Thank You!</h1>
<p>Your submission has been received. We appreciate you taking the time to reach out to us.</p>
<p>Our team will get back to you shortly.</p>


<a href="#" class="btn btn-primary mt-3">Return to Home</a>
</div>
        </div>
        <div class="col-lg-5">
            <img src="{{ asset('assets/front/images/thankyou.avif') }}" class="img-fluid">
        </div>
    </div>
</div>

@endsection