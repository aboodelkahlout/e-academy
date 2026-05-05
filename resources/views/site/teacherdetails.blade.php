@extends('site.app')

@section('title','Teacher Details')

@section('cont')

<div class="container-xxl py-5">
    <div class="container">

        <div class="row g-5">

            <!-- LEFT: Teacher Info -->
            <div class="col-lg-4">

                <div class="bg-light p-4 text-center">
                    <img class="img-fluid imghe rounded mb-3" src="{{asset('cover/'.$teacher->user->cover)}}">
                    <h4>{{$teacher->user->name}}</h4>
                    <p>{{$teacher->user->role}}</p>
                    <p>{{$teacher->bio}}</p>
                </div>

            </div>

            <!-- RIGHT: Sections -->
            <div class="col-lg-8">

                <!-- Schedule -->
      <div class="col-lg-8">

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="teacherTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses" type="button">
                Courses
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule" type="button">
                Schedule
            </button>
        </li>
    </ul>

    <div class="tab-content">

        <!-- Courses Tab -->
        <div class="tab-pane fade show active" id="courses">

            <div class="row g-4">

            @foreach ( $courses as $course )
             <div class="col-md-6">
                    <div class="course-item bg-light">
                        <div class="overflow-hidden">
                            <img class="img-fluid imgcourse" src="{{asset('cover/' . $course->course_cover)}}">
                        </div>

                        <div class="text-center p-4">
                            <h5 class="mb-3">{{$course->title}}</h5>
                            <h3 class="text-primary">${{ number_format($course->price, 0, '.', '') }}</h3>
                        </div>

                        <div class="text-center pb-3">
                            <button class="btn btn-primary px-4">Add to Cart</button>
                        </div>
                    </div>
                </div>
            @endforeach

                <!-- كرر الكارد -->

            </div>

        </div>

        <!-- Schedule Tab -->
        <div class="tab-pane fade" id="schedule">
                <div id='calendar'></div>

            <!-- كرر المواعيد -->

        </div>

    </div>

</div>

            </div>

        </div>

    </div>
</div>

@endsection

@section('js')

<script>
document.addEventListener('DOMContentLoaded', function() {
  var calendarEl = document.getElementById('calendar');

  var calendar = new FullCalendar.Calendar(calendarEl, {
    eventClick: function(info) {
      var eventObj = info.event;

      if (eventObj.url) {
        alert(
          'Clicked ' + eventObj.title + '.\n' +
          'Will open ' + eventObj.url + ' in a new tab'
        );

        window.open(eventObj.url);

        info.jsEvent.preventDefault(); // prevents browser from following link in current tab.
      } else {
        alert('Clicked ' + eventObj.title);
      }
    },
    // initialDate: '2026-04-15',

    events: @json($events)

  });

  calendar.render();
    var scheduleTab = document.querySelector('#schedule-tab');
    scheduleTab.addEventListener('shown.bs.tab', function () {
    calendar.updateSize();
});
});

</script>

@endsection
