@extends('site.app')
@section('title','About us')
@section('cont')

<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">

            <!-- Image -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="position-relative overflow-hidden rounded">
                    <img class="img-fluid w-100" src="img/about.jpg" alt="">
                </div>
            </div>

            <!-- Content -->
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                <h6 class="section-title bg-white text-start text-primary pe-3">
                    About Us
                </h6>

                <h1 class="mb-4">
                    Welcome to eLEARNING
                </h1>

                <p class="mb-4">
                    We provide high-quality online courses designed to help students
                    develop practical skills and achieve their learning goals.
                </p>

                <p class="mb-4">
                    Our platform offers expert instructors, flexible learning,
                    and a modern educational experience for learners worldwide.
                </p>

                <div class="row gy-2 gx-4 mb-4">

                    <div class="col-sm-6">
                        <p class="mb-0">
                            <i class="fa fa-arrow-right text-primary me-2"></i>
                            Skilled Instructors
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-0">
                            <i class="fa fa-arrow-right text-primary me-2"></i>
                            Online Courses
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-0">
                            <i class="fa fa-arrow-right text-primary me-2"></i>
                            Lifetime Access
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-0">
                            <i class="fa fa-arrow-right text-primary me-2"></i>
                            Practical Projects
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-0">
                            <i class="fa fa-arrow-right text-primary me-2"></i>
                            Flexible Learning
                        </p>
                    </div>

                    <div class="col-sm-6">
                        <p class="mb-0">
                            <i class="fa fa-arrow-right text-primary me-2"></i>
                            Expert Support
                        </p>
                    </div>

                </div>

                <a href="{{route('site.courses')}}" class="btn btn-primary py-3 px-5 mt-2" href="#">
                    Explore Courses
                </a>

            </div>

        </div>
    </div>
</div>
<!-- About End -->

 @endsection
