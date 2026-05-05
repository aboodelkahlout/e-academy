@extends('admin.layout')
@section('cont')
<div class="content-header">
<div class="container-fluid">
    <div class="row ms-2">
        <h1>All categories</h1>
    </div>

    <div class="container">
        <div class="row mt-3">

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Cover</th>
            <th>Created</th>
            <th>action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($categories as $cate)
        <tr id="row_{{$cate->id}}">
            <td>{{$cate->id}}</td>
            <td>{{$cate->category}}</td>
            <td><img src="{{asset('cover/'.	$cate->category_cover)}}" alt="no-img" width="50px"></td>
            <td>{{$cate->created_at}}</td>
            <td>
                <form action="{{route('admin.category.destroy', $cate->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button onclick="confirmdel(event)" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">no categories</td>
        </tr>
        @endforelse
    </tbody>
</table>

        </div>
    </div>
</div>
</div>
@endsection




@section('js')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
    function confirmdel(e){
        e.preventDefault();
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
