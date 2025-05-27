<div class="col-lg-12 col-md-12 col-sm-12 mt-2">
    @if ($semester != config('constant.annual'))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject</th>
                    @if ($semester == config('constant.sem1'))
                        <th>1<sup>st</sup> Seq</th>
                        <th>2<sup>nd</sup> Seq</th>
                    @elseif ($semester == config('constant.sem2'))
                        <th>3<sup>rd</sup> Seq</th>
                        <th>4<sup>th</sup> Seq</th>
                    @else
                        <th>5<sup>th</sup> Seq</th>
                        <th>6<sup>th</sup> Seq</th>
                    @endif
                    <th>AV/20</th>
                    <th>Coef</th>
                    <th>AV x coef</th>
                    <th>GRADE</th>
                    <th>Remarks</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($marks as $item)
                    <tr>
                        <td>{{ $item->course_id->name }}</td>
                        <td>{{ $item->n1_mark }}</td>
                        <td>{{ $item->n2_mark }}</td>
                        <td class="{{ ($item->n1_mark + $item->n2_mark) / 2 < 10 ? 'text-danger' : '' }}">
                            {{ ($item->n1_mark + $item->n2_mark) / 2 }}</td>
                        <td>{{ $item->course_id->coefficient }}</td>
                        <td>{{ (($item->n1_mark + $item->n2_mark) / 2) * $item->course_id->coefficient }}</td>
                        <td>{{ $item->grade }}</td>
                        <td>{{ $item->remark }}</td>
                        <td>{{ Str::title(Str::lower($item->signature)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Subject and Teacher's Names</th>
                    <th>1st TERM</th>
                    <th>2nd TERM</th>
                    <th>3rd TERM</th>
                    <th>AV</th>
                    <th>COEF</th>
                    <th>AV x Coef</th>
                    <th>Remarks</th>
                    <th>Teacher</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($annual_grades as $grade)
                    <tr>
                        <td>{{ $grade['course'] }}</td>
                        <td>{{ $grade['first_sem'] }}</td>
                        <td>{{ $grade['second_sem'] }}</td>
                        <td>{{ $grade['third_sem'] }}</td>
                        <td class="{{ $grade['average'] < 10.00 ? 'text-danger' : '' }}">{{ $grade['average'] }}</td>
                        <td>{{ $grade['coef'] }}</td>
                        <td>{{ $grade['av_coef'] }}</td>
                        <td>{{ $grade['remark'] }}</td>
                        <td>{{ Str::title(Str::lower($grade['signature'])) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-bold">TOTAL</td>
                    <td colspan="8">{{ array_sum(array_column($annual_grades, 'average')) }}</td>
                </tr>
            </tbody>
        </table>
    @endif
</div>
