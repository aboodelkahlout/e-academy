@extends('admin.layout')
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
            <th>teacher_name</th>
            <th>title</th>
            <th>description</th>
            <th>specialization</th>
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
        <td>{{$course->teacher->user->name}}</td>
        <td>{{$course->title}}</td>
        <td>{{$course->description}}</td>
        <td>{{$course->specialization}}</td>
        <td>{{$course->duration}}</td>
        <td>{{$course->price}}</td>
        <td><img src="{{asset('cover/' . $course->course_cover)}}" width="50px" alt=""></td>
        <td>{{$course->created_at}}</td>
        <td>{{$course->updated_at}}</td>

        <td class="d-flex gap-2">
            <form class="form" action="{{route('admin.course.destroy' , $course->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="button" onclick="confirmdel(event)" id="button{{$course->id}}" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            <!-- Button trigger modal -->
            <a href="{{route('admin.course.update' , $course->id)}}" onclick="updateinfo(event)" type="button" class="updatelink btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
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

            @include('admin.modalcourse')
<div class="container d-flex justify-content-center">
    {{ $allcourse->links() }}
</div>
</div>
</div>
</div>
</div>
@endsection
@section('js')

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

 <script>
   function updateinfo(e){

   let tr=e.target.closest('tr');
   let href = e.target.closest('a').href;
   let title=tr.querySelector('td:nth-child(3)').innerHTML;
   let description=tr.querySelector('td:nth-child(4)').textContent.trim();
   let specialization=tr.querySelector('td:nth-child(5)').innerHTML;
   let duration=tr.querySelector('td:nth-child(6)').innerHTML;
   let price=tr.querySelector('td:nth-child(7)').innerHTML;
   let course_cover=tr.querySelector('td:nth-child(8) img').src;



   document.getElementById('editForm').action=href;
   document.querySelector('form input[name="title"]').value = title;
    document.querySelector('form textarea[name="description"]').value = description;
    document.querySelector('form input[name="specialization"]').value = specialization;
    document.querySelector('form input[name="duration"]').value = duration;
    document.querySelector('form input[name="price"]').value = price;
    document.getElementById('preview').src=course_cover;

}
</script>


<script>

document.querySelector('.modal form').onsubmit=(e)=>{
    e.preventDefault();

    let form =document.getElementById('editForm');
    let url=form.action
    let data = new FormData(form);

    axios.post(url,data).then(function(res){

    let tr = document.querySelector('#row_' + res.data.id);
    tr.querySelector('td:nth-child(2)').innerHTML = res.data.teacher_id
    tr.querySelector('td:nth-child(3)').innerHTML = res.data.title;
    tr.querySelector('td:nth-child(4)').innerHTML= res.data.description;
    tr.querySelector('td:nth-child(5)').innerHTML= res.data.specialization;
    tr.querySelector('td:nth-child(6)').innerHTML= res.data.duration;
    tr.querySelector('td:nth-child(7)').innerHTML = res.data.price;
    tr.querySelector('td:nth-child(8) img').src = res.data.course_cover;
    });

     bootstrap.Modal.getInstance(document.getElementById('exampleModal')).hide();

}

</script>

<script>
    document.getElementById('course_cover').onchange = function (e){
         let file = e.target.files[0];

                if (!file) return;

                let reader = new FileReader();

                reader.onload = function () {
                    document.getElementById('preview').src = reader.result;
                };

                reader.readAsDataURL(file);
    }
</script>




</script>
@endsection
