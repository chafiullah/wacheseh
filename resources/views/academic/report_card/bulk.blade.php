
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bulk Generated Report Cards</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap4.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Carattere&family=Lato" rel="stylesheet">
    @include('academic.components.style')
</head>

<body>
<div class="container-fluid page-break report-card-container">
    @foreach($listOfStudents as $currentStudent)
        @php
            $requestedData = (object)$requestedData;
            $student = $currentStudent->student;
            $additional_data = \App\ResultCompliment::where('student_id',$student->id)->where('class_id',$requestedData->class_id)->where('semester',$requestedData->semester)->first();
            $class = \App\Department::find($requestedData->class_id);
            $semester = $requestedData->semester;
            //The hell
            if ($semester != config('constant.annual')) {
                 $marks = \App\Mark::where('semester', $semester)->where('student_id', $student->id)->where('class_id', $class->id)->get();
                // return $marks;
                if ($marks->count() > 0) {
                     /**
                     * Store Data of this semester in the result table
                     */
                    $total_coef = 0;
                    $sum_n1_c = 0;
                    $sum_n2_c = 0;
                    $sum_avg_and_c = 0;
                    foreach ($marks as $item) {
                      $sum_n1_c = $sum_n1_c + ($item->n1_mark * $item->course_id->coefficient);
                      $sum_n2_c = $sum_n2_c + ($item->n2_mark * $item->course_id->coefficient);
                      $sum_avg_and_c = $sum_avg_and_c + (($item->n1_mark + $item->n2_mark) / 2) * $item->course_id->coefficient;
                      $total_coef = $total_coef + $item->course_id->coefficient;
                    }
                    $part_1 = number_format($sum_n1_c / $total_coef, 2, '.', '');
                    $part_2 = number_format($sum_n2_c / $total_coef, 2, '.', '');
                    $total_marks =  $sum_avg_and_c;
                    $term_average = number_format($sum_avg_and_c / $total_coef, 2, '.', '');
                    \App\Result::updateOrCreate(
                      [
                        'semester' => $semester,
                        'student_id' => $requestedData->student_id,
                        'class_id' => $requestedData->class_id,
                        'year' => $marks->first()->academic_year,
                      ],
                      [
                        'part_1' => $part_1,
                        'part_2' => $part_2,
                        'total_marks' => $total_marks,
                        'total_coef' => $total_coef,
                        'term_average' => $term_average
                      ]
                    );
                    $results = \App\Result::where('student_id', $requestedData->student_id)->where('class_id', $requestedData->class_id)->where('semester', $semester)->first();
                    $all_results = \App\Result::where('year', $marks->first()->academic_year)->where('class_id', $requestedData->class_id)->where('semester', $semester)->orderBy('term_average', 'desc')->get();
                    $position = 0;
                    foreach ($all_results as $index => $item) {
                      if ($item->student_id == $requestedData->student_id) {
                        $position = $index + 1;
                      }
                    }
                }
            } else {
                $courses = \App\Helper\Helper::get_listof_subjects($student->id, $class->id)->pluck('course_id')->toArray();
                $annual_grades = [];
                foreach ($courses as $course_id) {
                  $marks = \App\Mark::whereIn('semester', [config('constant.sem1'), config('constant.sem2'), config('constant.sem3')])->where('student_id', $student->id)->where('class_id', $class->id)->where('course_id', $course_id)->latest()->get();
                  if ($marks->count() > 0) {
                    foreach ($marks as $semester_marks) {
                      if ($semester_marks->semester == config('constant.sem1')) {
                        $sem1_average = ($semester_marks->n1_mark + $semester_marks->n2_mark) / 2;
                      } elseif ($semester_marks->semester == config('constant.sem2')) {
                        $sem2_average = ($semester_marks->n1_mark + $semester_marks->n2_mark) / 2;
                      } else {
                        $sem3_average = ($semester_marks->n1_mark + $semester_marks->n2_mark) / 2;
                      }
                    }
                    $total_average = number_format(($sem1_average + $sem2_average + $sem3_average) / 3, 2);
                    $course_grade = [
                      'academic_year' => $marks->first()->academic_year,
                      'course' => $marks->first()->course_id->name,
                      'first_sem' => $sem1_average,
                      'second_sem' => $sem2_average,
                      'third_sem' => $sem3_average,
                      'average' => $total_average,
                      'coef' => $marks->first()->course_id->coefficient,
                      'av_coef' => number_format(($total_average * $marks->first()->course_id->coefficient), 2),
                      'remark' => \App\Helper\Helper::calculate_average_grade($total_average)[0],
                      'signature' => $marks->where('semester', config('constant.sem3'))->first()->signature,
                    ];
                    array_push($annual_grades, $course_grade);
                  }
                }
                // return $annual_grades;
            }
        @endphp
        <div class="row mt-2 p-2">
            @if($marks->count() > 0)
                {{-- banner --}}
                @include('academic.components.banner')
                {{-- Marking and Others --}}
                @include('academic.components.marks')
                {{-- honors and behavior details --}}
                @include('academic.components.honor')
                {{-- Signatures --}}
                @include('academic.components.signatures')
            @endif
        </div>
    @endforeach
</div>
{{-- Last page of the transcript --}}
@include('academic.components.last_page')
{{-- scripts --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>

</html>
