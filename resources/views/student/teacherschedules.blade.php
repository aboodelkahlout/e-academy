@extends('student.layout')
@section('cont')
<div class="container p-3">
  <div class="row">

    @foreach($schedules as $schedule)
          <div class="col-4 mb-3">
      <div class="card">
        <div class="card-body">

          <h5 class="card-title">

             {{ __('app.date') }} : {{ $schedule->date }}
          </h5>

          <p class="card-text">
            {{ __('app.start') }} : {{ $schedule->start_time}} -  {{ __('app.end') }} : {{ $schedule->end_time }}
          </p>

          <p>
            @if($schedule->is_available)
              <span class="badge bg-success">متاح</span>
            @else
              <span class="badge bg-danger">محجوز</span>
            @endif
          </p>

          @if($schedule->is_available)
            <a  href="{{route('site.payment', $schedule->id)}}" class="btn btn-primary btn-sm">
              حجز
            </a>
          @endif

        </div>
      </div>
    </div>


    @endforeach

  </div>
</div>
@endsection
