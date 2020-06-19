@extends('layouts.admin')

@section('content')
  <div class="row">
    <div class="col-6">
      <h3 class="text-success">Lesson List</h3>
      <a class="text-subtitle h6" href="{{ route('course.show', ['course' => $course->id ]) }}">
        Course: <b>{{ $course->title }}</b>
      </a>
    </div>
    <div class="col-6 text-right">
      <a href="{{ route('course.lesson.create', [ 'course' => $course->id ]) }}" class="nav-item btn btn-primary btn-sm">Add New</a>
    </div>
  </div>
  @foreach ($lessons as $lesson)
    <div class="card mb-3" onclick="gotoDetails({{ $lesson->id }})">
      <div class="card-header">
        <h4 class="card-title">{{ $lesson->title }}</h4>
      </div>
      <div class="card-body">
        <p class="card-text text-truncate">{{ $lesson->description }}</p>
      </div>
      <div class="card-footer text-muted">
        <div class=" text-right">
          <a href="{{ route('course.lesson.edit', ['course' => $course->id, 'lesson' => $lesson->id ]) }}" class="badge badge-pill">Edit</a>
          @include('comps.delete_form', [
            'resource_name' => 'course.lesson',
            'resource_id' => $lesson->id,
            'delete_route' => route('course.lesson.destroy', [ 'course' => $course->id, 'lesson' => $lesson->id ])
          ])
        </div>
      </div>
    </div>
  @endforeach

  {{ $lessons->withQueryString()->links() }}
@endsection

@section('js')
<script>
  function gotoDetails(courseId) {
    window.location = '/course/' + courseId
  }
</script>
@endsection
