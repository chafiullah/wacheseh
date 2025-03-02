<div class="col-md-6">
  <table class="table table-bordered">
    <thead>
        <tr class="text-center">
            <th colspan="4">Student Performance</th>
        </tr>
    </thead>
    <tbody>
      <tr>
        @if ($semester != config('constant.annual'))
          <td>Total Score</td>
          <td>{{ $results->total_marks }}</td>
        @else
          <td>Annual Score</td>
          <td>{{array_sum(array_column($annual_grades, 'av_coef'))}}</td>
        @endif
        <td>Remark</td>
        <td>
          @if ($semester != config('constant.annual'))
            {{Helper::calculate_average_grade($results->term_average)[1]}}  
          @else
            {{Helper::calculate_average_grade((array_sum(array_column($annual_grades, 'average'))))[1]}}
          @endif
        </td>
      </tr>
      <tr>
        <td rowspan="2">
          @if ($semester != config('constant.annual'))
            Coef.
          @else
            Annual Coef. 
          @endif
        </td>
        <td rowspan="2">
          @if ($semester != config('constant.annual'))
            {{ $marks->sum('course_id.coefficient') }}
          @else
            {{array_sum(array_column($annual_grades, 'coef'))}}
          @endif
        </td>
        @if ($semester != config('constant.annual'))
          <td>CVWA</td>
          <td>{{$marks->where('remark','CVWA')->count()}}</td>
        @endif
      </tr>
      @if ($semester != config('constant.annual'))
        <tr>
          <td>CWA</td>
          <td>{{$marks->where('remark','CWA')->count()}}</td>
        </tr>
        <tr>
          <td rowspan="2">Term Avg.</td>
          <td rowspan="2">
            {{ $results->term_average }}
          </td>
          <td>CA</td>
          <td>{{$marks->where('remark','CA')->count()}}</td>
        </tr>
        <tr>
          <td>CAA</td>
          <td>{{$marks->where('remark','CAA')->count()}}</td>
        </tr>
      @endif
      @if ($semester == config('constant.annual'))
        <tr>
          <td>Annual Average</td>
          <td colspan="3">{{array_sum(array_column($annual_grades, 'av_coef')) / array_sum(array_column($annual_grades, 'coef'))}}</td>
        </tr>
      @endif
      <tr>
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
            {{Helper::calculate_average_grade((array_sum(array_column($annual_grades, 'av_coef')))/array_sum(array_column($annual_grades, 'coef')))[0]}}
          @endif
        </td>
        @if ($semester != config('constant.annual'))
          <td>CNA</td>
          <td>{{$marks->where('remark','CNA')->count()}}</td>
        @endif
      </tr>
      @if ($semester == config('constant.annual'))
        <tr>
          <td style="height: 59px">Remarks on student performance</td>
          <td colspan="3">{{$additional_data['remarks']}}</td>
        </tr>
      @endif
      @if ($semester != config('constant.annual'))
      <tr>
        <td>Position</td>
        <td colspan="3">{{ Helper::ordinal($position) }}</td>
        {{-- <td colspan="3"></td> --}}
      </tr>
      @endif
    </tbody>
  </table>
</div>
<div class="col-md-6">
  <table class="table table-bordered">
    <thead>
      <tr class="text-center">
          <th colspan="4">Discipline</th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td>Unjustified Abs. (Nº of hrs.)</td>
          <td>{{$additional_data['un_absent']}}</td>
          <td>Conduct Warning</td>
          <td>{{$additional_data['warning']}}</td>
      </tr>
      <tr>
          <td>Justified Abs. (Nº of hrs.)</td>
          <td>{{$additional_data['absent']}}</td>
          <td>Reprimand</td>
          <td>{{$additional_data['reprimand']}}</td>
      </tr>
      <tr>
          <td>Late (Nº of times)</td>
          <td>{{$additional_data['late']}}</td>
          <td rowspan="2">Suspension</td>
          <td rowspan="2">{{$additional_data['suspension']}}</td>
      </tr>
      <tr>
          <td>Punishment (Nº of hrs.)</td>
          <td colspan="3">{{$additional_data['punishment']}}</td>
      </tr>
      @if ($semester != config('constant.annual'))
        <tr>
          <td style="height: 59px">Remarks on student performance</td>
          <td colspan="3">{{$additional_data['remarks']}}</td>
        </tr>
      @endif
    </tbody>
  </table>
</div>