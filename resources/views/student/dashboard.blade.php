@extends('student.layout')
@section('cont')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{__('app.mydashboard')}}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('student.dashboard')}}">{{__('app.home')}}</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
     <div class="container">
        <div class="row">
        @foreach ( $course as $item )
        <a href="{{ route('student.show.first.video', $item->course->id )}}">
         <div class="col-md-3">
            <div class="card" style="width: 18rem;">
                <img src="{{asset('cover/'.$item->course->course_cover)}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">{{ $item->course->title }}</h5>
                  <p class="card-text">{{ $item->course->description }}</p>
                </div>
            </div>
         </div>
        </a>
        @endforeach
        </div>
     </div>
    @endsection
