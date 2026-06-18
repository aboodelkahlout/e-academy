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
                    teacher  :{{ $schedule->teacher->user->name }}
                    <br>
                    price  :{{ $schedule->price }}
            </div>
            </div>

            <!-- Right: Summary -->
            <div class="col-lg-4">

                <div class="bg-light p-4 rounded shadow">

                    <h4 class="mb-4">Order Summary</h4>
                    <div class="d-flex justify-content-between mb-3">
                        <h6>Schedule</h6>
                        <h6>{{$schedule->start_time}} - {{$schedule->end_time}}</h6>
                              <form action="{{route('site.confirmappointment', $schedule->id)}}" method="POST">
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
