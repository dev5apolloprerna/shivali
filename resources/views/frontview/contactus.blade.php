@extends('layouts.front')
@section('content')
    <div class="page-title">
        <div class="container-full">
            <div class="row">
                <div class="col-12">
                    <h3 class="heading text-center">Inquiry</h3>
                    <ul class="breadcrumbs d-flex align-items-center justify-content-center">
                        <li><a class="link" href="{{ route('front.index') }}">Homepage</a></li>
                        <li><i class="fa fa-arrow"></i></li>
                        <li>Inquiry</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="container my-5">
        <div class="row">
            <div class="card shadow-lg border-1 col-lg-8 mx-auto">
                <div class="card-body p-5">
                    <h2 class="text-center mb-5">Get In Touch</h2>

                    <hr class="my-4">
                    <form action="{{ route('contactstore') }}" method="POST">
                        <!-- Contact Information -->
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Enter your full name"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Business Type</label>
                                <select name="business_type" class="form-control" required>
                                    <option selected disabled>Choose...</option>
                                    <option value="Wholesaler">Wholesaler</option>
                                    <option value="Reseller">Reseller</option>
                                    <option value="Retailer">Retailer</option>
                                    <option value="Individual">Individual</option>

                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="mobileno" class="form-control" maxlength="10"
                                    placeholder="+91 9123456789" required>
                            </div>


                            <h5 class="mb-3">Address</h5>
                            <div class="col-md-12">
                                <label class="form-label">Street Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Maninagar road"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">City</label>
                                <input type="text" name="city" class="form-control" placeholder="Ahmedabad" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">State / Province</label>
                                <input type="text" name="state" class="form-control" placeholder="Gujarat" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Country</label>
                                <input type="text" name="country" class="form-control" placeholder="India" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Pincode / Postal Code</label>
                                <input type="text" name="pincode" class="form-control" placeholder="e.g., 380008"
                                    required>
                            </div>

                        </div>

                        <!-- Additional Details -->

                        <div class="mb-3">
                            <label class="form-label">Message / Inquiry</label>
                            <textarea name="message" class="form-control" rows="4"
                                placeholder="e.g., catalog request, specific product inquiry..." required></textarea>
                        </div>




                        <div class="d-grid col-lg-2">
                            <button type="submit" class="btn btn-dark btn-sm">Submit Inquiry</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
