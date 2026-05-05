@extends('admin.layout')
@section('cont')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ __('app.myprofile') }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">{{ __('app.home') }}</a></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{route('update.img')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                          @if (Auth::user()->cover=='no-img.png')
                    <a href="{{route('admin.profile')}}">
                    <img src="https://ui-avatars.com/api/?background=random&name={{Auth::user()->name}}" class="rounded-circle" width="120px">
                    </a>
                    @else
                    <a href="{{route('admin.profile')}}">
                     <img id="preview" src="{{asset('cover/'.Auth::user()->cover)}}" class="rounded-circle" width="120px">            </a>
                @endif

                        <input type="file" id="cover" name="cover">
                       <button type="submit" class="btn btn-sm btn-primary ms-3 mt-3">CHANGE</button>
                    </form>
                </div>
            </div>


             <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

             <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                     <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        account {{ __('app.logout') }}
                    </h2>
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger mt-2">
                            {{ __('app.logout') }}
                        </button>
                    </form>
            </div>
            </div>
        </div>
    </div>
      </div><!-- /.container-fluid -->
    </div>
@endsection
