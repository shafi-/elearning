@extends('layouts.admin')

@section('content')
  <div class="row">
    <div class="col-6">
      <h3 class="text-success">Course List</h3>
    </div>
    <div class="col-6 text-right">
      <a href="{{ route('course.create') }}" class="nav-item btn btn-primary btn-sm">Add New</a>
    </div>
  </div>
  @foreach ($courses as $course)
    <div class="card mb-3" onclick="gotoDetails({{ $course->id }})">
      <div class="card-header">
        <h4 class="card-title">{{ $course->title }}</h4>
      </div>
      <div class="card-body">
        <p class="card-text text-truncate">{{ $course->description }}</p>
        <hr>
        <a href="{{ route('course.lesson.index', [ 'course' => $course->id ]) }}" class="badge badge-primary">
          This course has {{ $course->lessons_count ?? 0 }} lessons
        </a>
      </div>
      <div class="card-footer text-muted">
        <div class=" text-right">
          <a href="{{ route('course.edit', ['course' => $course->id ]) }}" class="badge badge-pill">Edit</a>
          @include('comps.delete_form', [ 'resource_name' => 'course', 'resource_id' => $course->id ])
        </div>
      </div>
    </div>
  @endforeach

  {{ $courses->withQueryString()->links() }}
@endsection

@section('js')
<script>
  function gotoDetails(courseId) {
    window.location = '/course/' + courseId
  }
</script>
@endsection
