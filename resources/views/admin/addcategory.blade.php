@extends('admin.layout')
@section('cont')
<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New course</h4>
        </div>
        <div class="card-body">

            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- category --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">category</label>
                        <input type="text"
                               name="category"
                               value="{{ old('category') }}"
                               class="form-control @error('category') is-invalid @enderror">

                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- category_cover --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">category_Image</label>
                        <input type="file"
                               name="category_cover"
                               class="form-control @error('category_cover') is-invalid @enderror">

                        @error('category_cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

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
