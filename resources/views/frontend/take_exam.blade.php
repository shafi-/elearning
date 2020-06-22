@extends('layouts.frontend')

@section('content')
<div id="take_exam">
  <div class="row">
    <div class="col-12">
      <h3 class="text-success">Mcq Test</h3>
      <a
        class="text-subtitle h6"
        href="{{ route('course.lesson.show', [ 'course' => $exam->lesson->course_id, 'lesson' => $exam->lesson->id ]) }}">
        Lesson: <b>{{ $exam->lesson->title }}</b>
      </a>
    </div>
  </div>

  <div class="row" v-if="not_submitted">
    <div class="col-12">
      <span class="text-danger">Instructions</span>
      <ul class="">
        <li>Check the box at the left of the answers</li>
        <li>There may be multiple answers of any mcq</li>
        <li>After completing, press the submit button</li>
      </ul>
    </div>
  </div>

  <div class="card-deck" v-if="not_submitted">
    <div v-for="(mcq,mcqIdx) in exam.mcqs" :key="mcq.id" class="row flex-fill">
      <div class="col-12 mb-2">
        <div class="card">
          <div class="card-body">

            <span class="h5 card-title">@{{ (mcqIdx + 1) + '. ' + mcq.question }}</span>

            <table class="table table-sm table-borderless mb-0">
              <tbody>
                <tr v-for="(optGroup, groupIdx) in chunk(mcq.options,2)" :key="groupIdx">
                  <td v-for="option in optGroup" :key="option.id">
                    <div class="form-check form-check-inline">
                      <input v-model="option.selected" :id="mcq.id+'_'+option.id" type="checkbox" class="form-check-input mcq">
                      <label class="form-check-label" :for="mcq.id+'_'+option.id">@{{ option.body }}</label>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row" v-else>
    <table class="table">
      <tbody>
        <tr>
          <td scope="row">Total: </td>
          <td>@{{ result.total }}</td>
        </tr>
        <tr>
          <td scope="row">Answered: </td>
          <td>@{{ Object.keys(result.answers).length }}</td>
        </tr>
        <tr>
          <td scope="row">Correct: </td>
          <td>@{{ result.score }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="row" v-if="not_submitted">
    <div class="col-12">
      <button type="button" v-on:click="submit" class="btn btn-primary btn-block">
        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Submit
      </button>
    </div>
  </div>

  <div class="row" v-else>
    <div class="col-12">
      <a class="btn btn-primary" href="/" role="button">Learn more</a>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  let submitUrl = "{{ route('submit_exam', [ 'exam' => $exam->id ]) }}";

  let exam = new Vue({
    el: '#take_exam',
    data() {
      return {
        exam: {
          mcqs: {!! json_encode($mcqs, JSON_HEX_TAG) !!}
        },
        errors: [],
        score: 0,
        result: undefined, // [{ mcq_id, options: [{ selected, answer }] }]
        loading: false
      }
    },
    created() {
      // axios
      //   .get('/exam/'+id)
      //   .then(res => this.exam = res.data)
      //   .catch(err => this.errors.push(err));
    },
    computed: {
      disableInput() {
        // add input disable logic
        return this.loading
      },
      not_submitted() {
        return !this.result;
      }
    },
    methods: {
      chunk(arr, size) {
        let chunks = [];
        let i = 0;
        while(i < arr.length) {
          if (!chunks[Math.floor(i/size)]) chunks.push([]);
          chunks[Math.floor(i/size)].push(arr[i]);
          i++;
        }
        return chunks;
      },
      submit() {
        if (this.loading || !this.not_submitted) return;
        this.loading = true;

        let mcqs = this.exam.mcqs.map(mcq => {
          return {
            id: mcq.id,
            answers: mcq.options.filter(opt => opt.selected).map(opt => opt.id)
          }
        });

        axios
          .post(submitUrl, { mcqs }, 'application/json' )
          .then(res => this.result = res.data)
          .catch(err => this.errors.push(err))
          .finally(() => this.loading = false);
      }
    }
  })
</script>
@endpush