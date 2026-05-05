@extends('teacher.layout')

@section('cont')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New course</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('teacher.course.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- title --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror">

                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- description --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">description</label>
                        <textarea type="description"
                               name="description"
                               value="{{ old('description') }}"
                               class="form-control @error('description') is-invalid @enderror"></textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- specialization --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">specialization</label>
                        <input type="text"
                               name="specialization"
                               class="form-control @error('specialization') is-invalid @enderror"  value="{{old('specialization')}}">

                        @error('specialization')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- duration --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">duration</label>
                        <input type="number"
                               name="duration"
                               value="{{ old('duration') }}"
                               class="form-control @error('duration') is-invalid @enderror">

                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- price --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">price</label>
                        <input type="number"
                               name="price"
                               value="{{ old('price') }}"
                               class="form-control @error('price') is-invalid @enderror">

                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    {{-- course_cover --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file"
                               name="course_cover"
                               class="form-control @error('course_cover') is-invalid @enderror">

                        @error('course_cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <select name="category_id" class="form-control mb-2">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->category == 'uncategoriez' ? 'selected' : '' }} >
                                {{ $category->category }}
                            </option>
                        @endforeach
                    </select>


                </div>

                <div class="text-end">
                    <button class="btn btn-success px-4">
                        Create course
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
