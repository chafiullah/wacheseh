<option></option>
@foreach ($courses as $item)
  <option value="{{ $item->course->id }}">
    {{ $item->course->name.' | coeff. : '.$item->course->coefficient}}
  </option>
@endforeach

<script>
  $("#select_course").select2({
    placeholder: "Select a value",
    allowClear: true
  });
</script>
