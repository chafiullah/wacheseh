{{-- Student Performance --}}
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th colspan="4">Student Performance</th>
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
                <td>
                    @if ($semester != config('constant.annual'))
                        {{ Helper::calculate_average_grade($results->term_average)[0] }}
                    @else
                        {{ Helper::calculate_average_grade(array_sum(array_column($annual_grades, 'av_coef')) / array_sum(array_column($annual_grades, 'coef')))[0] }}
                    @endif
                </td>
            </tr>
            {{-- Total Coef. and Position --}}
            <tr>
                <td rowspan="2">
                    @if ($semester != config('constant.annual'))
                        Total Coef.
                    @else
                        Annual Coef.
                    @endif
                </td>
                <td rowspan="2">
                    @if ($semester != config('constant.annual'))
                        {{ $marks->sum('course_id.coefficient') }}
                    @else
                        {{ array_sum(array_column($annual_grades, 'coef')) }}
                    @endif
                </td>
                @if ($semester != config('constant.annual'))
                    <td>Position</td>
                    <td colspan="3">{{ Helper::ordinal($position) }}</td>
                @else
                    <td>Position</td>
                    <td colspan="3">TBD</td>
                @endif
            </tr>
            {{-- Term Average and Remark --}}
            <tr>
                <td rowspan="2">Term Avg.</td>
                <td rowspan="2">
                    {{ $results->term_average }}
                </td>
                <td>Remark</td>
                <td>
                    @if ($semester != config('constant.annual'))
                        {{ Helper::calculate_average_grade($results->term_average)[1] }}
                    @else
                        {{ Helper::calculate_average_grade(array_sum(array_column($annual_grades, 'average')))[1] }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
{{-- Student Discipline --}}
<div class="col-md-12">
    <table class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th colspan="4">Discipline</th>
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
                <td rowspan="2">Suspension</td>
                <td rowspan="2">{{ $additional_data['suspension'] }}</td>
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
