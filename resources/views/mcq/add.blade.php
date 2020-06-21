@extends('layouts.admin')

@section('content')
<div class="card" id="add_mcq">
  <div class="card-header">
    <div class="col-12">
      <h3 class="text-success">Add Mcq</h3>
      <a class="text-subtitle h6"
        href="{{ route('course.lesson.show', [ 'course' => $lesson->course_id, 'lesson' => $lesson->id ]) }}">
        Lesson: <b>{{ $lesson->title }}</b>
      </a>
    </div>
  </div>
  <div class="card-body">
    <div v-if="addMore" class="col-12">
      <a class="h3 text-success">MCQ added Successfully.</a>
      <br>
      <a class="h4 text-dark">Want to add another mcq in this lesson?</a>
      <button @click="resetForm" type="button" class="btn btn-outline-primary">Yes</button>
      <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">No</a>
    </div>
    <div v-else>
      <form @submit.prevent="submitForm('{{ route('lesson.mcq.store', ['lesson' => $lesson->id ]) }}')">
        <div class="form-group">
          <label for="question">Question</label>
          <input type="text" class="form-control" v-model="mcq.question" aria-describedby="helpId" placeholder="Question">
          <small id="helpId" class="form-text text-muted">@{{ questionHelpText() }}</small>
        </div>
        <div v-for="(option, optIdx) in mcq.options" :key="optIdx" class="form-row align-items-center">
          <div class="col-auto">
            <label class="sr-only" for="question">Option @{{ optIdx + 1 }}</label>
            <input type="text" class="form-control" v-model="option.body" :aria-describedby="'body_' + optIdx" :placeholder="optionPlaceholderText(optIdx)">
            <small :id="'body_' + optIdx" class="form-text text-muted">@{{ optionHelpText(option, optIdx) }}</small>
          </div>
          <div class="col-auto">
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" v-model="option.is_answer"  :id="'check_' + optIdx">
              <label class="form-check-label" :for="'check_' + optIdx">
                This option is an answer
              </label>
            </div>
          </div>
        </div>
        @include('comps.btn_submit', [ 'btn_submit_txt' => 'Save' ])
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script lang="js" src="{{ asset('js/add_mcq.js') }}">
</script>
@endsection