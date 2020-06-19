@extends('layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">
    Add Course
  </div>
  <div class="card-body">
    <form action="{{ route('course.store') }}" method="POST">
      @csrf
      @method('PUT')
      @include('comps.text_input', [ 'name' => 'title', 'label' => 'Title' ])
      @include('comps.text_input', [ 'name' => 'description', 'label' => 'Description' ])
      @include('comps.btn_submit', ['btn_submit_txt' => 'Save' ])
    </form>
  </div>
</div>
@endsection
