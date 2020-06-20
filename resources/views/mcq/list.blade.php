@extends('layouts.admin')

@section('content')
  <div class="row">
    <div class="col-6">
      <h3 class="text-success">Mcq List</h3>
      <a
        class="text-subtitle h6"
        href="{{ route('course.lesson.show', [ 'course' => $lesson->course_id, 'lesson' => $lesson->id ]) }}">
        Lesson: <b>{{ $lesson->title }}</b>
      </a>
    </div>
    <div class="col-6 text-right">
      <a href="{{ route('lesson.mcq.create', [ 'lesson' => $lesson->id ]) }}"
        class="nav-item btn btn-primary btn-sm">
        Add New
      </a>
    </div>
  </div>
  @foreach ($mcqs as $mcq)
    <div class="card mb-3">
      <div class="card-header">
        <h4 class="card-title">{{ $mcq->id . ' ' . $mcq->question }}</h4>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          <tbody>
            @foreach($mcq->options->chunk(2) as $option_group)
            <tr>
              @foreach($option_group as $option)
              <td>
                <div class="form-check form-check-inline">
                  <input class="form-check-input mcq" type="checkbox"
                    is_answer="{{ $option->is_answer }}"
                    name="{{ 'mcq_' . $mcq->id }}[]" id="{{ 'mcq_opt_' . $option->id }}"
                    value="{{ $option->id }}" @if($option->is_answer) checked @endif>
                  <label class="form-check-label" for="{{ 'mcq_opt_' . $option->id }}">{{ $option->body }}</label>
                </div>
              </td>
              @endforeach
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="card-footer text-muted">
        <div class=" text-right">
          <a href="{{ route('lesson.mcq.edit', ['lesson' => $lesson->id, 'mcq' => $mcq->id ]) }}" class="badge badge-pill">Edit</a>
          @include('comps.delete_form', [
            'resource_name' => 'lesson.mcq',
            'resource_id' => $mcq->id,
            'delete_route' => route('lesson.mcq.destroy', [ 'mcq' => $mcq->id, 'lesson' => $lesson->id ])
          ])
        </div>
      </div>
    </div>
  @endforeach

  {{-- {{ $mcqs->withQueryString()->links() }} --}}
@endsection

@section('js')
<script>
  // $('input.mcq', function() {});
  function gotoDetails(mcqId) {
    window.location = '/mcq/' + mcqId
  }
</script>
@endsection
