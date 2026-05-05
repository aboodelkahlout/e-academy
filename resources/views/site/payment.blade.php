@extends('site.app')

@section('title','Payment')

@section('cont')

<!-- Header -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-4 text-white">Payment</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">

            <!-- Left: Fake Payment Form -->
            <div class="col-lg-8">
                <div class="bg-light p-4 rounded shadow">

                <script
                    src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$id}}"
                    integrity="{integrity}"
                    crossorigin="anonymous">
                </script>
                <form action="{{route('site.payaction')}}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>

            </div>
            </div>

            <!-- Right: Summary -->
            <div class="col-lg-4">

                <div class="bg-light p-4 rounded shadow">

                    <h4 class="mb-4">Order Summary</h4>



                </div>

            </div>

        </div>
    </div>
</div>

@endsection
