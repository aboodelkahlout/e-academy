@extends('teacher.layout')

@section('cont')
<div class="content-header">
<div class="container-fluid">
    <div class="row ms-2">
        <h1>All Schedules</h1>
    </div>

    <div class="container">
        <div class="row mt-3">

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($schedules as $schedule)
        <tr id="row_{{$schedule->id}}">
            <td>{{$schedule->id}}</td>
            <td>
    <span class="editable" data-field="date" data-id="{{ $schedule->id }}">
        
        {{ $schedule->date }}
    </span>

 <input type="date" class="edit-input d-none"
                    data-field="date"
                    data-id="{{ $schedule->id }}"
                    value="{{ $schedule->date }}">
            </td>
           <td>
                <span class="editable" data-field="start_time" data-id="{{ $schedule->id }}">
                    {{ $schedule->start_time }}
                </span>
                <input type="time" class="edit-input d-none"
                    data-field="start_time"
                    data-id="{{ $schedule->id }}"
                    value="{{ $schedule->start_time }}">
            </td>
            <td>
                <span class="editable" data-field="end_time" data-id="{{ $schedule->id }}">
                    {{ $schedule->end_time }}
                </span>
                <input type="time" class="edit-input d-none"
                    data-field="end_time"
                    data-id="{{ $schedule->id }}"
                    value="{{ $schedule->end_time }}">
            </td>


        <td>
                <button class="toggle-status btn btn-sm
                    {{ $schedule->is_available ? 'btn-success' : 'btn-danger' }}"
                    data-id="{{ $schedule->id }}"
                    data-value="{{ $schedule->is_available }}">

                    {{ $schedule->is_available ? 'Available' : 'Not Available' }}
                </button>
        </td>
            <td class="d-flex gap-2">
                <form action="{{route('teacher.schedules.delete' , $schedule->id )}}" method="POST">
                    @csrf
                    @method('delete')
                    <button type="button" onclick="confirmdel(event)" class="btn btn-danger">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">no schedules available</td>
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

function confirmdel(e){
    e.preventDefault();

    let form = e.target.closest('form');

    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes"
    }).then((result) => {

        if (!result.isConfirmed) return;

       $.ajax({
        url:form.action,
        method:'POST',
        data:{
             _token:document.querySelector('meta[name="csrf-token"]').content,
            _method:'DELETE',
        },
        success:function(){
            form.closest('tr').remove();
        }
       });

    });
}
</script>



<script>
    

</script>





<script>
$(document).on('click', '.editable', function () {
    let id = $(this).data('id');
    let field = $(this).data('field');

    $(this).hide();
    $('.edit-input[data-id="'+id+'"][data-field="'+field+'"]')
        .removeClass('d-none')
        .focus();
});

$(document).on('keypress', '.edit-input', function (e) {
    if (e.which === 13) {

        let id = $(this).data('id');
        let field = $(this).data('field');
        let value = $(this).val();
        let input = $(this);

        $.ajax({
            url: '/teacher/schedules/update',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                field: field,
                value: value
            },
            success: function () {
                input.addClass('d-none');

                $('.editable[data-id="'+id+'"][data-field="'+field+'"]')
                    .text(value)
                    .show();
            }
        });
    }
});
</script>
<script>
    $(document).on('click', '.toggle-status', function () {

    let btn = $(this);
    let id = btn.data('id');
    let current = btn.data('value');
    let newValue = current == 1 ? 0 : 1;

    $.ajax({
        url: '/teacher/schedules/toggle-status',
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: id,
            is_available: newValue
        },
        success: function () {

            btn.data('value', newValue);

            if (newValue == 1) {
                btn.removeClass('btn-danger').addClass('btn-success');
                btn.text('Available');
            } else {
                btn.removeClass('btn-success').addClass('btn-danger');
                btn.text('Not Available');
            }
        }
    });

});
</script>
@endsection
