@php
  $params = [];
  $params[$resource_name] = $resource_id;
  if(!isset($delete_route)) $delete_route = route($resource_name . '.destroy', $params);
  $form_id = 'form_' . $resource_name . '_delete_' . $resource_id;
@endphp

<a class="badge badge-pill text-danger"
  href="{{ $delete_route }}" onclick="event.preventDefault(); document.getElementById('{{ $form_id }}').submit();">
  Delete
</a>
<form id="{{ $form_id }}" action="{{ $delete_route }}" method="POST" style="display: none;">
  @csrf
  @method("DELETE")
</form>
