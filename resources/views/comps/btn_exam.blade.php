@php
  $exam_route = route('exam.store');
  $form_id = 'form_exam_create' . $lesson_id;
@endphp

<a class="btn btn-outline-secondary text-info"
  href="{{ $exam_route }}" onclick="event.preventDefault(); document.getElementById('{{ $form_id }}').submit();">
  Take Exam
</a>
<form id="{{ $form_id }}" action="{{ $exam_route }}" method="POST" style="display: none;">
  @csrf
  <input name="lesson_id" value="{{ $lesson_id }}">
</form>
