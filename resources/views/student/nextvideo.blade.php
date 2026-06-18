@extends('student.layout')

@section('cont')

<div class="container py-5">
    <div class="row">

        <!-- الفيديو الرئيسي -->
        <div class="col-lg-8">

            <div class="card shadow border-0 mb-4">
                <div class="card-body">

                    <video width="100%" height="450" controls>
                        <source src="{{ asset('video/'.$firstVideo->video_path) }}" type="video/mp4">
                    </video>

                    <h3 class="mt-3">
                        {{ $firstVideo->title }}
                    </h3>

                    <p class="text-muted">
                        Duration : {{ $firstVideo->duration }}
                    </p>

                </div>
            </div>

            <!-- التعليقات -->
            <div class="card shadow border-0">
                <div class="card-body">

                    <h4 class="mb-4">Comments</h4>

                 <form action="{{ route('student.comment.store',[
                        'video' => $firstVideo->id,
                        'course' => $firstVideo->course_id
                    ])}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="comment" class="form-control"
                                      rows="4"
                                      placeholder="Write your comment"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </form>

                    <hr>

                    <!-- تعليق -->
                 @foreach ( $comments as $comment )
                      <div class="d-flex mb-4 mt-3">
                        <div class="me-3">
                            <img src="{{asset('cover/'.$comment->user->cover)}}"
                               style="width:50px;"  class="rounded-circle pr-2">
                        </div>

                        <div>
                            <h6>{{$comment->user->name}}</h6>

                            <p class="mb-0">
                                {{ $comment->comment }}
                            </p>
                        </div>

                    </div>
                    @endforeach

                </div>
            </div>

        </div>

        <!-- قائمة الفيديوهات -->
        <div class="col-lg-4">

            <div class="card shadow border-0">

                <div class="card-header">
                    <h5 class="mb-0">
                        Course Videos
                    </h5>
                </div>

                <div class="card-body">


                       @forelse ( $videos as $video )
                        <a href="{{ route('student.show.next.video', ['id' => $video->id , 'course' => $video->course_id])}}"
                           class="text-decoration-none">

                            <div class="border rounded p-3 mb-3">

                                <h6 class="text-dark">
                                    {{ $video->title }}
                            </h6>

                                <small class="text-muted">
                                    Duration : {{ $video->duration }}
                                </small>

                            </div>

                        </a>
                       @empty

                       @endforelse


                </div>

            </div>

        </div>

    </div>
</div>

@endsection
