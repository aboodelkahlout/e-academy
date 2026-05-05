@extends('admin.layout')
@section('cont')
<div class="content-header">
<div class="container-fluid">
    <div class="row ms-2">
        <h1>All Teachers</h1>
    </div>
    <div class="container">
        <div class="row mt-3">
<Table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Bio</th>
            <th>Phone</th>
            <th>Ex_Years</th>
            <th>Cover</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
       @foreach ( $allteachers as $teacher )
       <tr id="row_{{$teacher->id}}">
        <td>{{$teacher->id}}</td>
        <td>{{$teacher->name}}</td>
        <td>{{$teacher->email}}</td>
        <td>{{$teacher->teacher->bio}}</td>
        <td>{{$teacher->teacher->phone}}</td>
        <td>{{$teacher->teacher->years_of_experience}}</td>
        <td><img src="{{asset('cover/' . $teacher->cover)}}" width="50px" alt=""></td>
        <td class="d-flex gap-2">
            <form class="form" action="{{route('admin.teacher.destroy' , $teacher->id)}}" method="post">
                @csrf
                @method('delete')
                <button type="button" onclick="confirmdel(event)" id="button{{$teacher->id}}" class="btn btn-danger">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            <!-- Button trigger modal -->
            <a href="{{route('admin.teacher.update' , $teacher->id)}}" onclick="updateinfo(event)" type="button" class="updatelink btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-edit"></i>
           </a>

            <!-- Modal -->
            @include('admin.modal')
        </td>
    </tr>
       @endforeach
    </tbody>
</Table>
<div class="container d-flex justify-content-center">
    {{ $allteachers->links() }}
</div>
</div>
</div>
</div>
</div>
@endsection
@section('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




<script>
   function updateinfo(e){
    let tr = e.target.closest('tr');
    let href=e.target.closest('a').href;
    let name = tr.querySelector('td:nth-child(2)').innerHTML;
     let email = tr.querySelector('td:nth-child(3)').innerHTML;
     let bio =tr.querySelector('td:nth-child(4)').innerHTML;
     let phone =tr.querySelector('td:nth-child(5)').innerHTML;
     let ex_years =tr.querySelector('td:nth-child(6)').innerHTML;




     document.getElementById('editForm').action=href;
     document.querySelector('form input[name="name"]').value=name;
     document.querySelector('form input[name="email"]').value=email;
     document.querySelector('form textarea[name="bio"]').value=bio;
     document.querySelector('form input[name="phone"]').value=phone;
     document.querySelector('form input[name="years_of_experience"]').value=ex_years;

}
</script>


<script>

document.querySelector('.modal form').onsubmit=(e)=>{
    e.preventDefault();

    let url =document.querySelector('.modal form').action;
    let data= new FormData(document.querySelector('.modal form'))

    axios.post(url,data).then(function(res){

    let tr = document.querySelector('#row_' + res.data.id);
    tr.querySelector('td:nth-child(2)').innerHTML= res.data.name;
    tr.querySelector('td:nth-child(3)').innerHTML = res.data.email;
    tr.querySelector('td:nth-child(4)').innerHTML= res.data.bio;
    tr.querySelector('td:nth-child(5)').innerHTML= res.data.phone;
    tr.querySelector('td:nth-child(6)').innerHTML= res.data.years_of_experience;
    tr.querySelector('td:nth-child(7) img').src = res.data.cover;
    });

     bootstrap.Modal.getInstance(document.getElementById('exampleModal')).hide();
}

</script>

<script>
    document.getElementById('cover').onchange = function (e){
         let file = e.target.files[0];

                if (!file) return;

                let reader = new FileReader();

                reader.onload = function () {
                    document.getElementById('preview').src = reader.result;
                };

                reader.readAsDataURL(file);
    }
</script>

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
