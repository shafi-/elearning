@extends('layouts.admin')

@section('content')
  <div class="row">
    <div class="col-12">
      <h3 class="text-success">Lesson List</h3>
      <a class="text-subtitle h6" href="{{ route('course.show', ['course' => $course->id ]) }}">
        Course: <b>{{ $course->title }}</b>
      </a>
    </div>
  </div>
  @foreach ($lessons as $lesson)
    <div class="card mb-3">
      <div class="card-header">
        <h4 class="card-title">{{ $lesson->title }}</h4>
      </div>
      <div class="card-body">
        <p class="card-text text-truncate">{{ $lesson->description }}</p>
      </div>
      @auth
        @if($lesson->mcqs_count)
        <div class="card-footer">
          <div class="text-left">
            @include('comps.btn_exam', [ 'lesson_id' => $lesson->id ])
          </div>
        </div>
        @endif
      @endauth
    </div>
  @endforeach

  {{ $lessons->withQueryString()->links() }}
@endsection

@push('js')
@endpush
