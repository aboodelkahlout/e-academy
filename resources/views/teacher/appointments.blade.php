@extends('teacher.layout')

@section('cont')
<div class="content-header">
<div class="container-fluid">
    <div class="row ms-2">
        <h1>All Appointments</h1>
    </div>

    <div class="container">
        <div class="row mt-3">

<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
            <th>Status</th>
            <th>Created</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($appointments as $appointment)
        <tr id="row_{{$appointment->id}}">
            <td>{{$appointment->id}}</td>

            <td>{{$appointment->user->name}}</td>

            <td>{{$appointment->teacher_schedule->date}}</td>
            <td>{{$appointment->teacher_schedule->start_time}}</td>
            <td>{{$appointment->teacher_schedule->end_time}}</td>
            <td>
                @if($appointment->status == 'pending')
                    <span class="text-warning">Pending</span>
                @elseif($appointment->status == 'accepted')
                    <span class="text-success">Accepted</span>
                @elseif($appointment->status == 'rejected')
                    <span class="text-danger">Rejected</span>
                @else
                    <span class="text-secondary">Cancelled</span>
                @endif
            </td>

            <td>{{$appointment->created_at}}</td>

            <td class="d-flex gap-2">

                {{-- accept --}}
                <form action="" method="POST">
                    @csrf
                    <button class="btn btn-success btn-sm"><i class="fa fas-check"></i></button>
                </form>

                {{-- reject --}}
                <form action="" method="POST">
                    @csrf
                    <button class="btn btn-danger btn-sm">✖</button>
                </form>

            </td>
        </tr>
        @empty
        <tr>
            <td colspan="8" class="text-center">no appointments</td>
        </tr>
        @endforelse
    </tbody>
</table>

        </div>
    </div>
</div>
</div>
@endsection
