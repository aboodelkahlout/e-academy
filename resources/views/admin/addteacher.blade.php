@extends('admin.layout')

@section('cont')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Add New Teacher</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('admin.teacher.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- Name --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror">

                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror">

                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone') }}"
                               class="form-control @error('phone') is-invalid @enderror">

                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Years of Experience --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Years of Experience</label>
                        <input type="number"
                               name="years_of_experience"
                               value="{{ old('years_of_experience') }}"
                               class="form-control @error('years_of_experience') is-invalid @enderror">

                        @error('experience_years')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- cover --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file"
                               name="cover"
                               class="form-control @error('cover') is-invalid @enderror">

                        @error('cover')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Bio --}}
                    <div class="col-12 mb-3">
                        <label class="form-label">Bio</label>
                        <textarea name="bio"
                                  rows="4"
                                  class="form-control @error('bio') is-invalid @enderror">{{ old('bio') }}</textarea>

                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="text-end">
                    <button class="btn btn-success px-4">
                        Create Teacher
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
