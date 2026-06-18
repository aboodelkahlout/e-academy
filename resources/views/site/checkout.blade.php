@extends('site.app')

@section('title','Checkout')

@section('cont')

<!-- Header -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-4 text-white">Checkout</h1>
    </div>
</div>

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">

            <!-- Left: Courses -->
            <div class="col-lg-8">

                <div class="bg-light p-4 rounded shadow">

                    <h4 class="mb-4">Your Courses</h4>

                    @foreach ($cart_items as $cart_item)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-3">

                            <div>
                                <h6 class="mb-1">{{ $cart_item->course->title }}</h6>
                                <small class="text-muted">
                                    {{ $cart_item->course->teacher->user->name }}
                                </small>
                            </div>

                            <div class="text-end">
                                <strong>
                                    ${{ number_format($cart_item->course->price, 0, '.', '') }}
                                </strong>
                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

            <!-- Right: Summary -->
            <div class="col-lg-4">

                <div class="bg-light p-4 rounded shadow">

                    <h4 class="mb-4">Summary</h4>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Total</span>
                        <strong>${{ $total }}</strong>
                    </div>

                    <form action="{{route('site.paymentconfirmpage')}}" method="POST">
                        @csrf
                        <button class="btn btn-primary w-100">
                            Pay Now
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@section('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});


@if (session('msg'))
Toast.fire({
  icon: "{{session('type')}}",
  title: "{{session('msg')}}"
});
@endif

</script>


@endsection
