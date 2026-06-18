@extends('site.app')

@section('title','Course Details')

@section('cont')

<!-- Header -->
<div class="container-fluid bg-primary py-5 mb-5 page-header">
    <div class="container py-5 text-center">
        <h1 class="display-4 text-white">{{$course->title}}</h1>
    </div>
</div>

<!-- Course Details -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">

            <!-- Left Side -->
            <div class="col-lg-8">

                <!-- Image -->
                <img class="img-fluid rounded mb-4 w-100" style="height:400px;object-fit:cover;"
                     src="{{asset('cover/'.$course->course_cover)}}">

                <!-- Title -->
                <h2 class="mb-3">{{$course->title}}</h2>

                <!-- Teacher + Info -->
                <div class="d-flex mb-3">
                <a href="{{ route('site.teacherdetails', $course->teacher->id) }}" class="text-decoration-none text-dark">
                <span class="me-4">
                    <i class="fa fa-user text-primary me-2"></i>
                        {{$course->teacher->user->name}}
                    </span>
                </a>

                    <span class="me-4">
                        <i class="fa fa-clock text-primary me-2"></i>
                        {{$course->duration}}
                    </span>

                    <span>
                        <i class="fa fa-user text-primary me-2"></i>
                        {{ $course->students()->count() }}
                    </span>
                </div>

                <!-- Description -->
                <div class="bg-light p-4 rounded">
                    <h5>Description</h5>
                    <p>{{$course->description}}</p>
                </div>

            </div>

            <!-- Right Side (Card) -->
            <div class="col-lg-4">

                <div class="bg-light p-4 rounded shadow">

                    <!-- Price -->
                    <h3 class="text-primary mb-3">
                        ${{ number_format($course->price, 0, '.', '') }}
                    </h3>

                    <!-- Add to cart -->
                    <form  class="form" action="{{ route('site.addtocart', $course->id) }}" method="POST">
                        @csrf
                        <button onclick="addtocart(event)" class="btn btn-primary w-100 mb-3">Add to Cart</button>
                    </form>
                    <!-- Extra Info -->
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fa fa-clock text-primary me-2"></i>
                            Duration: {{$course->duration}}
                        </li>

                        <li class="mb-2">
                            <i class="fa fa-user text-primary me-2"></i>
                            Students: {{ $course->students()->count() }}
                        </li>

                        <li>
                          <a href="{{ route('site.teacherdetails', $course->teacher->id) }}" class="text-decoration-none text-dark">
                <span class="me-4">
                    <i class="fa fa-user text-primary me-2"></i>
                        teacher: {{$course->teacher->user->name}}
                    </span>
                </a>
                        </li>
                    </ul>

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



<script>

    function addtocart(e){
        e.preventDefault();


          @if (!auth()->check())
        alert('login required');
        window.location.href = '/login';
        return;
        @endif

        let btn = e.target.closest('button');
        let form = btn.closest('form');




         $.post({
        url:form.action,
        method:'POST',
        data:{
             _token:"{{ csrf_token() }}",
        },
        success:function(res){
               document.getElementById('cart-count').innerText = res.count;
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



                Toast.fire({
                icon: res.type,
                title: res.msg
                });

    }
       });



    }



</script>


@endsection

