@extends('teacher.layout')
@section('cont')
<div class="content-header">
<div class="container-fluid">
    <div class="row ms-2">
        <h1>All Course</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
<Table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>title</th>
            <th>description</th>
            <th>specialization</th>
            <th>category</th>
            <th>duration</th>
            <th>price</th>
            <th>course_cover</th>
            <th>created_at</th>
            <th>updated_at</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>

        @forelse ( $allcourse as  $course)
       <tr id="row_{{$course->id}}">
        <td>{{$course->id}}</td>
        <td><a data-bs-toggle="modal" data-bs-target="#exampleModal" class="showinfo" href="{{route('teacher.course.info', $course->id)}}">{{$course->title}}</a></td>
        <td>{{$course->description}}</td>
        <td>{{$course->specialization}}</td>
        <td>{{$course->category->category}}</td>
        <td>{{$course->duration}}</td>
        <td>{{$course->price}}</td>
        <td><img src="{{asset('cover/' . $course->course_cover)}}" width="50px" alt=""></td>
        <td>{{$course->created_at}}</td>
        <td>{{$course->updated_at}}</td>
        <td class="d-flex gap-2">
            <form class="form" action="{{route('teacher.course.destroy' , $course->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="button" onclick="confirmdel(event)" id="button{{$course->id}}" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            <!-- Button trigger modal -->
            <a href="{{route('teacher.course.edit' , $course->id)}}"  type="button" class="updatelink btn btn-primary">
            <i class="fas fa-edit"></i>
           </a>
        </td>
    </tr>
        @empty
        <tr>
            <td colspan="9" class="text-center">there is no course avilable</td>
        </tr>
        @endforelse
    </tbody>
</Table>
           <!-- Modal -->

           <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">students of {{$course->title}} course</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="container d-flex justify-content-center">
</div>
</div>
</div>
</div>
</div>
@endsection

@section('js')

<script>
   $('.showinfo').click(function(){
     var link = $(this).attr('href');
     $('.modal-body').html(" ");
      $.get({
        url:link,
        success:function(res){
             $('.modal-body').append('count of students of this course :' + res.stu_count + '<br>');
         res.students.forEach(element => {
              $('.modal-body').append("name of student :" +'<button>' + element.name + '</button>'+'<br>');
         });
       }
    })
   });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function confirmdel(e){
        let form=e.target.closest('form');
        Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed){
            e.target.closest('form').submit();
        };
        });
    }
</script>


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
