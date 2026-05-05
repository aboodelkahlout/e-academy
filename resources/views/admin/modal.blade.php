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

                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Years of Experience</label>
                            <input type="number" name="years_of_experience" class="form-control">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Profile Image</label>
                            <input type="file" name="cover" id="cover" class="form-control">
                       <img id="preview" src="{{asset('cover/' . $teacher->cover)}}" class="rounded-circle" width="120px">
                        </div>

                        <div class="col-12 mb-3">
                            <label>Bio</label>
                            <textarea name="bio" rows="4" class="form-control"></textarea>
                        </div>

                    </div>
                </div>
            <button class="btn btn-outline-primary" type="submit">update</button>
            </form>
    </div>
    </div>
  </div>
</div>
