@extends('layouts.frontend')

@section('content')
  @if(count($exams) < 1)
  <div>
    <div class="alert alert-primary" role="alert">
      @if(Auth::user()->is_client())
      <strong>You did not take any exam.</strong> <a href="{{ route('course.index') }}" class="alert-link">Find courses to learn</a>
      @else
      <strong>Users did not take part in any exam yet. Add interesting courses and lessons.</strong>
      @endif
    </div>
  </div>
  @endif
  <div class="list-group">
    @foreach($exams as $exam)
    <a href="#" class="list-group-item list-group-item-action mb-3 border-info">
      <div>
        <h5 class="mb-1">Exam {{ $exam->id }} Result</h5>
        <small>Lesson: {{ $exam->lesson->title }}</small>
        <hr>
        <table class="table table-borderless table-sm">
          <tbody>
            <tr>
              <td scope="row">Total: </td>
              <td>{{ $exam->result['total'] ?? '' }}</td>
            </tr>
            <tr>
              <td scope="row">Answered: </td>
              <td>{{ $exam->result['answered'] ?? '' }}</td>
            </tr>
            <tr>
              <td scope="row">Correct: </td>
              <td>{{ $exam->result['score'] ?? '' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </a>
    @endforeach
  </div>

  <div>
    {{ $exams->links() }}
  </div>
@endsection
