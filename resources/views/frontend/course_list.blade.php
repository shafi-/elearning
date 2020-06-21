@extends('layouts.frontend')

@section('content')
  <div class="row">
    <h3 class="text-success">Course List</h3>
  </div>
  @foreach ($courses as $course)
    <div class="card mb-3">
      <div class="card-header">
        <h4 class="card-title">{{ $course->title }}</h4>
      </div>
      <div class="card-body">
        <p class="card-text text-truncate">{{ $course->description }}</p>
        <hr>
        <a href="{{ route('course.lesson.index', [ 'course' => $course->id ]) }}" class="btn btn-link">
          This course has {{ $course->lessons_count ?? 0 }} lessons
        </a>
      </div>
    </div>
  @endforeach

  {{ $courses->withQueryString()->links() }}
@endsection

@push('js')
<script></script>
@endpush
