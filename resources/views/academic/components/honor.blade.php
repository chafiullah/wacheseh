{{-- Student Performance --}}
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="6">Student Performance</th>
            </tr>
        </thead>
        <tbody>
            {{-- Total Score and Grade --}}
            <tr>
                @if ($semester != config('constant.annual'))
                    <td>Total Score</td>
                    <td>{{ $results->total_marks }}</td>
                @else
                    <td>Annual Score</td>
                    <td>{{ array_sum(array_column($annual_grades, 'av_coef')) }}</td>
                @endif
                <td>
                    @if ($semester != config('constant.annual'))
                        Grade
                    @else
                        Annual Grade
                    @endif
                </td>
                <td colspan="3">
                    @if ($semester != config('constant.annual'))
                        {{ Helper::calculate_average_grade($results->term_average)[0] }}
                    @else
                        {{ Helper::calculate_average_grade(array_sum(array_column($annual_grades, 'av_coef')) / array_sum(array_column($annual_grades, 'coef')))[0] }}
                    @endif
                </td>
            </tr>
            {{-- Total Coef. and Position --}}
            <tr>
                <td>
                    @if ($semester != config('constant.annual'))
                        Total Coef.
                    @else
                        Annual Coef.
                    @endif
                </td>
                <td>
                    @if ($semester != config('constant.annual'))
                        {{ $marks->sum('course_id.coefficient') }}
                    @else
                        {{ array_sum(array_column($annual_grades, 'coef')) }}
                    @endif
                </td>
                <td>Position</td>
                @php
                    if($semester == config('constant.annual')){
                        $position = $results->part_1;
                    }
                @endphp
                <td colspan="3">{{ Helper::ordinal($position) }}</td>
            </tr>
            {{-- Term Average and Remark --}}
            <tr>
                <td>Term Avg.</td>
                <td>
                    {{ $results->term_average }}
                </td>
                <td>Remark</td>
                <td colspan="3">
                    @if ($semester != config('constant.annual'))
                        {{ Helper::calculate_average_grade($results->term_average)[2] }}
                    @else
                        {{ Helper::calculate_average_grade(array_sum(array_column($annual_grades, 'average')))[2] }}
                    @endif
                </td>
            </tr>
            {{-- extra option that was asked put summary result with third term --}}
            @if ($semester == config('constant.sem3'))
                {{-- Final result after honor_old.blade.php --}}
                <tr>
                    <td rowspan="2">Final Results</td>
                    <td>1st Term AVG</td>
                    <td>2nd Term AVG</td>
                    <td>3rd Term AVG</td>
                    <td>Annual AVG</td>
                    <td>Annual Position</td>
                </tr>
                {{-- Fetch the results --}}
                @php
                    $year = $marks->first()->academic_year;
                    $firstTermResults = \App\Result::where('year',$year)->where('student_id',$student->id)->where('class_id',$class->id)->where('semester',config('constant.sem1'))->first();
                    $secondTermResults = \App\Result::where('year',$year)->where('student_id',$student->id)->where('class_id',$class->id)->where('semester',config('constant.sem2'))->first();
                    $thirdTermResults = \App\Result::where('year',$year)->where('student_id',$student->id)->where('class_id',$class->id)->where('semester',config('constant.sem3'))->first();
                    $annualTermResults = \App\Result::where('year',$year)->where('student_id',$student->id)->where('class_id',$class->id)->where('semester',config('constant.annual'))->first();
                @endphp
                <tr>
                    <td>{{$firstTermResults->term_average}}</td>
                    <td>{{$secondTermResults->term_average}}</td>
                    <td>{{$thirdTermResults->term_average}}</td>
                    <td>{{$annualTermResults->term_average}}</td>
                    <td>{{Helper::ordinal($annualTermResults->part_1)}}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
{{-- Student Discipline --}}
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="4">Student Discipline</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Unjustified Abs. (No. of Hours.)</td>
                <td>{{ $additional_data['un_absent'] }}</td>
            </tr>
            <tr>
                <td>Late (No. of Hours)</td>
                <td>{{ $additional_data['late'] }}</td>
            </tr>
            <tr>
                <td>Conduct</td>
                <td>{{ $additional_data['warning'] }}</td>
            </tr>
            <tr>
                <td>Reprimand</td>
                <td>{{ $additional_data['reprimand'] }}</td>
            </tr>
            <tr>
                <td>Suspension</td>
                <td>{{ $additional_data['suspension'] }}</td>
            </tr>
            @if ($semester != config('constant.annual'))
                <tr>
                    <td style="height: 59px">Remarks on student performance</td>
                    <td colspan="3">{{ $additional_data['remarks'] }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
