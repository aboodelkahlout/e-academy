@extends('student.layout')

@section('cont')

<div class="container py-4">


<div class="mb-4">
    <h2 class="fw-bold">My Appointments</h2>
    <p class="text-muted">View all your scheduled interviews.</p>
</div>

<div class="row g-4">


@foreach ( $appointments as $appointment)
   <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Interview Details</h5>
                    <span class="badge bg-success px-3 py-2">
                        accepted
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        Teacher
                    </small>

                    <h6 class="fw-semibold">
                       {{ $appointment->teacher->user->name }}
                    </h6>
                </div>
                <div class="row">

                    <div class="col-6 mb-3">
                        <small class="text-muted d-block">
                            Date
                        </small>

                        <h6 class="fw-semibold">
                           {{ $appointment->teacher_schedule->date }}
                        </h6>
                    </div>

                    <div class="col-6 mb-3">
                        <small class="text-muted d-block">
                            Time
                        </small>

                        <h6 class="fw-semibold">
                            {{ $appointment->teacher_schedule->start_time }}
                        </h6>
                    </div>

                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">
                        End
                    </small>

                    <h6 class="fw-semibold">
                        {{ $appointment->teacher_schedule->end_time }}
                    </h6>
                </div>
                <div class="mb-3">
                    <small class="text-muted d-block">
                        Meeting Link
                    </small>
                    <div class="bg-light rounded-3 p-3">
                       {{ $appointment->teacher_schedule->link }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


</div>


</div>
@endsection
