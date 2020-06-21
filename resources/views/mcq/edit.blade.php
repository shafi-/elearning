@extends('layouts.admin')

@section('content')
<div class="card" id="edit_mcq">
  <div class="card-header">
    <div class="col-12">
      <h3 class="text-success">Edit Mcq</h3>
      <a class="text-subtitle h6"
        href="{{ route('course.lesson.show', [ 'course' => $lesson->course_id, 'lesson' => $lesson->id ]) }}">
        Lesson: <b>{{ $lesson->title }}</b>
      </a>
    </div>
  </div>
  <div class="card-body">
    <div v-if="success" class="col-12">
      <a class="h3 text-success">MCQ update was successful.</a>
      <br>
      <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Go back</a>
    </div>
    <div v-else>
      <form @submit.prevent="submitForm('{{ route('lesson.mcq.update', ['lesson' => $mcq->lesson_id, 'mcq' => $mcq->id ]) }}')">
        <div class="form-group">
          <label for="question">Question</label>
          <input type="text" class="form-control" v-model="mcq.question" value="{{ $mcq->question }}" aria-describedby="helpId" placeholder="Question">
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
        <div class="form-group row mb-0">
          <div class="col-md-8 offset-md-4">
            <button type="submit" class="btn btn-outline-primary">
              <span v-if="submitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
              {{ __('Update') }}
            </button>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
              {{ __('Cancel') }}
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
let vmEditMcq = new Vue({
  el: '#edit_mcq',
  data() {
    return {
      mcq: {
        question: '{{ $mcq->question }}',
        options: {!! json_encode($mcq->options, JSON_HEX_TAG) !!},
      },
      error: {
        errorCode: null,
        errros: {
          question: '',
          options: []
        }
      },
      submitting: false,
      success: false
    }
  },
  created() {
    // this.resetForm();
  },
  methods: {
    getNewOption() {
      return {
        body: '',
        is_answer: false
      };
    },
    questionHelpText() {
      return this.error ? this.error.question : 'Question field is required'
    },
    optionHelpText(option, optionIndex) {
      return this.error && this.error.options ? this.error.options[optionIndex] : '';
    },
    optionPlaceholderText(optIdx) {
      return 'Option ' + (optIdx + 1) + ' text';
    },
    parseError() {},
    resetForm() {
      this.mcq.question = '',
      this.mcq.options = [];
      for(let i = 0; i < 4; i++)
        this.mcq.options.push(this.getNewOption());
      this.error = {
        errorCode: null,
        errros: {
          question: '',
          options: []
        }
      }
      this.addMore = false
    },
    submitForm(url) {
      console.log({
        url, 
        mcq: this.mcq
      });
      this.submitting = true;
      axios.patch(url, this.mcq)
        .then(console.log)
        .then(() => this.success = true)
        .catch(console.error)
        .finally(() => this.submitting = false);
    }
  }
});
</script>
@endsection
