
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                 <div class="modal-body">
                    <div class="row">
                {{-- title --}}
                    <div class="col-md-6 mb-3">
                        <label for="title">Title</label>
                        <input id="title" type="text" name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror">
                    </div>

                    {{-- description --}}
                    <div class="col-md-6 mb-3">
                        <label for="description">Description</label>
                        <textarea id="description" rows="3" name="description"
                               value="{{ old('description') }}"
                               class="form-control @error('description') is-invalid @enderror"></textarea>
                    </div>

                    {{-- specialization --}}
                    <div class="col-md-6 mb-3">
                        <label for="specialization">Specialization</label>
                        <input id="specialization" type="text" name="specialization"
                               value="{{ old('specialization') }}"
                               class="form-control @error('specialization') is-invalid @enderror">
                    </div>

                    {{-- duration --}}
                    <div class="col-md-6 mb-3">
                        <label for="duration">Duration</label>
                        <input id="duration" type="number" name="duration"
                               value="{{ old('duration') }}"
                               class="form-control @error('duration') is-invalid @enderror">
                    </div>

                    {{-- price --}}
                    <div class="col-md-6 mb-3">
                        <label for="price">Price</label>
                        <input id="price" type="number" name="price"
                               value="{{ old('price') }}"
                               class="form-control @error('price') is-invalid @enderror">
                    </div>

                    {{-- course_cover --}}
                    <div class="col-md-6 mb-3">
                        <label for="course_cover">Course Cover</label>
                        <input id="course_cover" type="file" name="course_cover"
                               class="form-control @error('course_cover') is-invalid @enderror">
                               <img src="" width="70px" class="rounded" id="preview" alt="" >
                    </div>

                                        {{-- select teacher --}}
                    <div class="col-md-6 mb-3">
                        <label for="teacher_id">Teacher</label>
                       <select name="teacher_id" id="teacher_id">
                        <option selected disabled><span>select teacher</span></option>
                        @foreach ( $allteacher as $teacher )
                        <option  value="{{$teacher->id}}">{{$teacher->user->name}}</option>
                        @endforeach
                       </select>
                    </div>

                </div>
                 </div>

            <button class="btn btn-outline-primary" type="submit">update</button>
            </form>
    </div>
    </div>
  </div>
</div>
