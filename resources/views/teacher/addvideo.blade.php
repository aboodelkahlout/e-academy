@extends('teacher.layout')
@section('cont')

<div class="container p-5">
        <form action="{{route('teacher.course.video.store',$course->id)}}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label>Title</label>
        <input type="text" name="title" class="form-control  @error('title')
is-invalid @enderror" required>
    </div>
   @error('title')

            <div class="invalid-feedback">{{ $message }}</div>
    @enderror

    <div class="mb-3">
        <label>Duration</label>
        <input type="number" name="duration" class="form-control  @error('duration')
is-invalid @enderror" placeholder="000" required>
    </div>
    @error('duration')
            <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="mb-3">
        <label>Video File</label>
        <input type="file" name="video_path"  class="form-control  @error('video_path')
is-invalid @enderror" accept="video/*" required>
    </div>

     @error('video_path')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

    <button type="submit" class="btn btn-primary">
        Upload Video
    </button>
</form>

</div>

@endsection

@section('js')


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

