
@extends('site.app')

@section('title','Our Courses')

@section('cont')
    <!-- Header Start -->
    <div class="container-fluid bg-primary py-5 mb-5 page-header">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 text-white animated slideInDown">Courses</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                            <li class="breadcrumb-item text-white active" aria-current="page">Courses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->


    <!-- Categories Start -->
    <div class="container-xxl py-5 category">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Categories</h6>
                <h1 class="mb-5">Courses Categories</h1>
            </div>
            <div class="row g-3">
            @foreach ( $cate as $category )
            <div class="col-lg-4 col-md-6 wow zoomIn" data-wow-delay="0.5s">
                            <a class="position-relative d-block overflow-hidden" href="">
                                <img class="img-fluid imghe" src="{{ asset('cover/'. $category->category_cover) }}" alt="">
                                <div class="bg-white text-center position-absolute bottom-0 end-0 py-2 px-3" style="margin: 1px;">
                                    <h5 class="m-0">{{$category->category}}</h5>
                                    <small class="text-primary">{{$category->courses_count}}</small>
                                </div>
                            </a>
                        </div>

            @endforeach
        </div>
    </div>
    <!-- Categories Start -->


    <!-- Courses Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="section-title bg-white text-center text-primary px-3">Courses</h6>
                <h1 class="mb-5">Popular Courses</h1>
            </div>
            <div class="row g-4 justify-content-center">
                @foreach ( $courses as $course)
                       <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="course-item bg-light">
                        <div class="position-relative overflow-hidden">
                            <img class="img-fluid imgcourse" src="{{asset('cover/'. $course->course_cover)}}" alt="">
                            <div class="w-100 d-flex justify-content-center position-absolute bottom-0 start-0 mb-4">
                                <a href="{{route('site.coursedetails',$course->id)}}" class="flex-shrink-0 btn btn-sm btn-primary px-3 border-end" style="border-radius: 30px 0 0 30px;">Read More</a>
                             <form class="form" action="{{ route('site.addtocart', $course->id) }}" method="POST">
                                @csrf
                                <button onclick="addtocart(event)"  class="addcart flex-shrink-0 btn btn-sm btn-primary px-3" style="border-radius: 0 30px 30px 0;" >Add to Cart</button>
                            </form>
                            </div>
                        </div>
                        <div class="text-center p-4 pb-0">
                        <h3 class="mb-0">${{ number_format($course->price, 0, '.', '') }}</h3>
                            <h5 class="mb-4">{{$course->title}}</h5>
                        </div>
                        <div class="d-flex border-top">
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-user-tie text-primary me-2"></i>{{$course->teacher->user->name}}</small>
                            <small class="flex-fill text-center border-end py-2"><i class="fa fa-clock text-primary me-2"></i>{{$course->duration}}</small>
                            <small class="flex-fill text-center py-2"><i class="fa fa-user text-primary me-2"></i>  {{ $course->students()->count() }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Courses End -->
     {{ $courses->links() }}

    <!-- Testimonial Start -->
    <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="section-title bg-white text-center text-primary px-3">Testimonial</h6>
                <h1 class="mb-5">Our Students Say!</h1>
            </div>
            <div class="owl-carousel testimonial-carousel position-relative">
               @foreach ( $stu as $student )
               <div class="testimonial-item text-center">
                    <img class="border rounded-circle p-2 mx-auto mb-3" src="{{asset('cover/'.$student->cover)}}" style="width: 80px; height: 80px;">
                    <h5 class="mb-0">{{$student->name}}</h5>
                    <p>Student</p>
                    <div class="testimonial-text bg-light text-center p-4">
                    </div>
                </div>
               @endforeach
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
    </div>
@endsection


@section('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




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



