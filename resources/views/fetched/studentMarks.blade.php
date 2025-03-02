@foreach ($studentMarks as $item)
    <option value="{{ $item->id }}">
        @if($item->course != null)
            {{ $item->course->course_code . ' - ' . $item->course->course_name . ' - ' . $item->grade_letter }}
        @else
            {{ $item->course_code . ' - ' . $item->course_title . ' - ' . $item->grade_letter }}
        @endif
    </option>
@endforeach
<option value="all">select all courses</option>
