@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">
    Update Course
  </div>
  <div class="card-body">
    <form action="{{ route('course.update', [ 'course' => $course->id ]) }}" method="POST">
      @csrf
      @method('PATCH')
      @include('comps.text_input', [ 'name' => 'title', 'label' => 'Title', 'value' => $course->title ])
      @include('comps.text_input', [ 'name' => 'description', 'label' => 'Description', 'value' => $course->description ])
      @include('comps.btn_submit', ['btn_submit_txt' => 'Save' ])
    </form>
  </div>
</div>
@endsection
