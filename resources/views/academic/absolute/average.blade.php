{{-- from report-card single view --}}
    {{-- average and totals --}}
    <div class="col-md-12">
    <table class="table table-bordered   title">
        <thead>
        <tr>
            <th colspan="2">SEQ Average</th>
            <th>Total Marks</th>
            <th>Total Coefficient</th>
            <th>Average</th>
            <th>Rank</th>
        </tr>
        </thead>
        <tbody>
        {{-- if Trimester 1 is selected --}}
        @if ($semester == config('constant.sem1'))
            <tr>
            <td>1st SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_1 }}</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>2nd SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->term_average }}</td>
            <td></td>
            </tr>
        @endif
        {{-- if Trimester 2 is selected --}}
        @if ($semester == config('constant.sem2'))
            {{-- data of trimester 2 --}}
            <tr>
            <td>3rd SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->part_1 }}</td>
            <td>2nd Term</td>
            <td>2nd Term</td>
            <td>2nd Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>4th SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->term_average }}</td>
            <td></td>
            </tr>
        @endif
        {{-- if trimester 3 is selected --}}
        @if ($semester == config('constant.sem3'))
            {{-- data of trimester 3 --}}
            <tr>
            <td>5th SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->part_1 }}</td>
            <td>TOTAL MARKS</td>
            <td>Total Coef.</td>
            <td>Average Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>6th SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->term_average }}</td>
            <td></td>
            </tr>
        @endif
        </tbody>
    </table>
    </div>
{{-- from report card view page --}}
    {{-- average and totals --}}
    {{-- this part in single report card and report card is not converted into components because: in report card we are generating average of previous semesters while in single report card only shows average of that semester --}}
    <div class="col-md-12">
    <table class="table table-bordered   title">
        <thead>
        <tr>
            <th colspan="2">SEQ Average</th>
            <th>Total Marks</th>
            <th>Total Coefficient</th>
            <th>Average</th>
            <th>Rank</th>
        </tr>
        </thead>
        <tbody>
        {{-- if Trimester 1 is selected --}}
        @if ($semester == config('constant.sem1'))
            <tr>
            <td>1st SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_1 }}</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>2nd SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->term_average }}</td>
            <td></td>
            </tr>
            {{-- rest 4 blank --}}
            <tr>
            <td>3rd SEQ AVG</td>
            <td></td>
            <td>2nd Term</td>
            <td>2nd Term</td>
            <td>2nd Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>4th SEQ AVG</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
            <tr>
            <td>5th SEQ AVG</td>
            <td></td>
            <td>3rd Term</td>
            <td>3rd Term</td>
            <td>3rd Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>6th SEQ AVG</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
        @endif
        {{-- if Trimester 2 is selected --}}
        @if ($semester == config('constant.sem2'))
            {{-- data from trimester 1 --}}
            <tr>
            <td>1st SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_1 }}</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>2nd SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->term_average }}</td>
            <td></td>
            </tr>
            {{-- data of trimester 2 --}}
            <tr>
            <td>3rd SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->part_1 }}</td>
            <td>2nd Term</td>
            <td>2nd Term</td>
            <td>2nd Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>4th SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->term_average }}</td>
            <td></td>
            </tr>
            {{-- rest is blank --}}
            <tr>
            <td>5th SEQ AVG</td>
            <td></td>
            <td>3rd Term</td>
            <td>3rd Term</td>
            <td>3rd Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>6th SEQ AVG</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            </tr>
        @endif
        {{-- if trimester 3 is selected --}}
        @if ($semester == config('constant.sem3'))
            {{-- data from trimester 1 --}}
            <tr>
            <td>1st SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_1 }}</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>1st Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>2nd SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem1'))->first()->term_average }}</td>
            <td></td>
            </tr>
            {{-- data of trimester 2 --}}
            <tr>
            <td>3rd SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->part_1 }}</td>
            <td>TOTAL MARKS</td>
            <td>Total Coef.</td>
            <td>Average Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>4th SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem2'))->first()->term_average }}</td>
            <td></td>
            </tr>
            {{-- data of trimester 3 --}}
            <tr>
            <td>5th SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->part_1 }}</td>
            <td>TOTAL MARKS</td>
            <td>Total Coef.</td>
            <td>Average Term</td>
            <td>Rank</td>
            </tr>

            <tr>
            <td>6th SEQ AVG</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->part_2 }}</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->total_marks }}</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->total_coef }}</td>
            <td>{{ $results->where('semester', config('constant.sem3'))->first()->term_average }}</td>
            <td></td>
            </tr>
            <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td>Yearly Average</td>
            <td>Yearly Rank</td>
            </tr>
            <tr>
            <td>Yearly</td>
            <td></td>
            <td></td>
            <td></td>
            <td>
                @php
                $total_average = $results->where('semester', config('constant.sem1'))->first()->term_average + $results->where('semester', config('constant.sem2'))->first()->term_average + $results->where('semester', config('constant.sem3'))->first()->term_average;
                @endphp
                {{ $total_average / 3 }}
            </td>
            <td></td>
            </tr>
        @endif
        </tbody>
    </table>
    @if ($semester == config('constant.sem3'))
        <table class="table table-bordered final">
        <tbody>
            <tr>
            <td>Final Average</td>
            <td>
                {{ ($results->where('semester', config('constant.sem1'))->first()->term_average + $results->where('semester', config('constant.sem2'))->first()->term_average + $results->where('semester', config('constant.sem3'))->first()->term_average) / 3 }}
            </td>
            <td>Final Rank</td>
            <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
            </tr>
        </tbody>
        </table>
    @endif
    </div>