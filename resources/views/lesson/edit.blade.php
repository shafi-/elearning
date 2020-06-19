@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">
    Update Lesson
  </div>
  <div class="card-body">
    <form action="{{ route('course.lesson.update', [ 'course' => $lesson->course_id, 'lesson' => $lesson->id ]) }}" method="POST">
      @csrf
      @method('PATCH')
      @include('comps.text_input', [ 'name' => 'title', 'label' => 'Title', 'value' => $lesson->title ])
      @include('comps.text_input', [ 'name' => 'description', 'label' => 'Description', 'value' => $lesson->description ])
      @include('comps.btn_submit', ['btn_submit_txt' => 'Save' ])
    </form>
  </div>
</div>
@endsection
