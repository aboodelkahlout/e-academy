@extends('site.app')

@section('title','Course Details')

@section('cont')

<!-- Header -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-4 text-white">Hello {{ Auth::user()->name}} </h1>
    </div>
</div>

<!-- Course Details -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <!-- Right Side (Card) -->
            @foreach ( $cart_items as $cart_item )
  <div class="col-lg-4 cart-item">
    <div class="bg-light p-4 rounded shadow position-relative">

        <!-- Delete Button -->
        <form action="{{route('site.delete.cart', $cart_item->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button

                type="submit"
                class="delcourse btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle" style="width:35px; height:35px;">
                <i class="fa fa-times"></i>
            </button>
        </form>

        <!-- title -->
        <h3 class="text-primary mb-3">
            {{ $cart_item->course->title }}
        </h3>

        <!-- Extra Info -->
        <ul class="list-unstyled">

            <li class="mb-2">
                <i class="fa text-primary me-2">$</i>
                Price:
                ${{ number_format($cart_item->course->price, 0, '.', '') }}
            </li>

            <li class="mb-2">
                <i class="fa fa-clock text-primary me-2"></i>
                Duration:
                {{ $cart_item->course->duration }}
            </li>

            <li class="mb-2">
                <i class="fa fa-user text-primary me-2"></i>
                Students:
                {{ $cart_item->course->students->count()}}
            </li>

            <li>
                <i class="fa fa-user-tie text-primary me-2"></i>
                Teacher:
                {{ $cart_item->course->teacher->user->name }}
            </li>

        </ul>
    </div>
</div>
            @endforeach

              <div class="bg-light p-4 rounded shadow">

                    <!-- title -->
                    <h3 class="text-primary mb-3">

                    </h3>

                    <!-- Add to cart -->

                        <a href="{{route('site.checkout')}}" class="btn btn-primary w-100 mb-3">Check Out</a>


                    <!-- Extra Info -->
                    <ul class="list-unstyled">

                     <li class="mb-2">
                            <i class="fa  text-primary me-2">$</i>
                            Total Price:  ${{ $total }}
                        </li>
                    </ul>

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



<script>

document.querySelectorAll('.delcourse').forEach(button => {
    button.onclick = function(e){
        e.preventDefault();

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if(result.isConfirmed){

                let form = button.closest('form');

                $.ajax({
                    url: form.action,
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        _method: "DELETE"
                    },

                    success: function(res){

                        document.getElementById('cart-count').innerText = res.count;

                        button.closest('.cart-item').remove();

                        Swal.fire({
                            icon: res.type,
                            title: res.msg,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                });
            }

        });
    }
});
</script>

@endsection
