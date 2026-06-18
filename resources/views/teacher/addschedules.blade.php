@extends('teacher.layout')
@section('cont')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add Your schedules</h4>
        </div>
        <div class="card-body">
       <form action="{{ route('teacher.schedules.store') }}" method="POST">
       @csrf
    {{-- date --}}
    <div class="mb-3">
        <label>التاريخ</label>
        <input
            type="date"
            name="date"
            value="{{ old('date') }}"
            class="form-control @error('date') is-invalid @enderror">

        @error('date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- start_time --}}
    <div class="mb-3">
        <label>وقت البداية</label>
        <input
            type="time"
            name="start_time"
            value="{{ old('start_time') }}"
            class="form-control @error('start_time') is-invalid @enderror">

        @error('start_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- end_time --}}
    <div class="mb-3">
        <label>وقت النهاية</label>
        <input
            type="time"
            name="end_time"
            value="{{ old('end_time') }}"
            class="form-control @error('end_time') is-invalid @enderror">

        @error('end_time')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    {{-- is_available --}}
    <div class="mb-3">
        <label>الحالة</label>
        <select name="is_available" class="form-control @error('is_available') is-invalid @enderror">
            <option value="1" {{ old('is_available', 1) == 1 ? 'selected' : '' }}>متاح</option>
            <option value="0" {{ old('is_available') == 0 ? 'selected' : '' }}>غير متاح</option>
        </select>

        @error('is_available')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-3">
        <label>لينك المقابلة</label>
        <input
            type="text"
            name="link"
            value="{{ old('link') }}"
            class="form-control @error('link') is-invalid @enderror">

        @error('link')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>



    <button class="btn btn-primary">حفظ</button>
</form>

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

@endsection
