 <option></option>
 @foreach ($students as $student)
   <option value="{{ $student->student->id }}">
     {{ $student->student->name }}
   </option>
 @endforeach

 <script>
   $("#student_list").select2({
     placeholder: "Select a value",
     allowClear: true
   });
 </script>
