@extends('layouts.master')

@section('title', 'Transcripts and Certificates')
@section('extrastyle')
    <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/switchery.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.min.css">
@endsection

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="x_panel">
                        <div class="x_content">
                            <div class="row">
                                {{--                                Refresh the results --}}
                                <div class="col-md-12 col-12">
                                    <h4 class="text-Success">Refresh the Results</h4>
                                    <p class="text-danger">This is crucial. When you generate a report card, only then the system calculates the grades and creates positon for each student. So, think like this: you generated a report card and the system calculated and set a positon for that student. Later, you generated another report card for the same year, class and trimester and that student has better grades. So? The previous student's position must change right? Exactly! This is why we request you to refresh the results before you generate the report cards. Even if you are generating a single report card, this step is must. But, if you are sure you haven't inserted new grade you can obviously skip.</p>
                                    <form action="{{ route('academic.results.refresh') }}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Academic Year:</label>
                                                <select name="academic_year" class="select2" required>
                                                    <option></option>
                                                    @foreach ($academicYears as $academicYear)
                                                        <option value="{{ $academicYear->academic_year }}">
                                                            {{ $academicYear->academic_year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Class:</label>
                                                <select name="class_id" class="select2" required>
                                                    <option></option>
                                                    @foreach ($classes as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Trimester:</label>
                                                <select name="semester" class="select2" required>
                                                    <option value="{{ config('constant.sem1') }}">{{ config('constant.sem1') }}
                                                    </option>
                                                    <option value="{{ config('constant.sem2') }}">{{ config('constant.sem2') }}
                                                    </option>
                                                    <option value="{{ config('constant.sem3') }}">{{ config('constant.sem3') }}
                                                    </option>
                                                    <option value="{{ config('constant.annual') }}">
                                                        {{ config('constant.annual') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-success pull-right">refresh</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
{{--                                Generate single report card--}}
                                <div class="col-md-12 col-12">
                                    <h4 class="text-info">There are a few things you should keep in mind before generating the
                                        report card. It's mandatory.</h4>
                                    <ul class="text-warning">
                                        <li>Make sure you are using <b>Google Chrome/Brave</b> browser</li>
                                        <li>Your file saving type is <b>pdf</b></li>
                                        <li>Margin is <b>default</b></li>
                                    </ul>
                                    <form action="{{ route('academic.report-card.generate') }}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Student:</label>
                                                <select name="student_id" class="select2" required>
                                                    <option></option>
                                                    @foreach ($students as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->student_id . ' - ' . $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Class:</label>
                                                <select name="class_id" class="select2" required>
                                                    <option></option>
                                                    @foreach ($classes as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Trimester:</label>
                                                <select name="semester" class="select2" required>
                                                    <option value="{{ config('constant.sem1') }}">{{ config('constant.sem1') }}
                                                    </option>
                                                    <option value="{{ config('constant.sem2') }}">{{ config('constant.sem2') }}
                                                    </option>
                                                    <option value="{{ config('constant.sem3') }}">{{ config('constant.sem3') }}
                                                    </option>
                                                    <option value="{{ config('constant.annual') }}">
                                                        {{ config('constant.annual') }}</option>
                                                </select>
                                            </div>
                                            {{-- additional comments --}}
                                            @include('academic.components.index_extra')
                                            <div class="form-group col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-success pull-right">generate</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
{{--                                Generate report in bulk--}}
                                <div class="col-md-12 col-12">
                                    <h4 class="text-info">Generate Report Card in Bulk</h4>
                                    <form action="{{ route('academic.report-card_generate.bulk') }}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Academic Year:</label>
                                                <select name="academic_year" class="select2" required>
                                                    <option></option>
                                                    @foreach ($academicYears as $academicYear)
                                                        <option value="{{ $academicYear->academic_year }}">
                                                            {{ $academicYear->academic_year }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Class:</label>
                                                <select name="class_id" class="select2" required>
                                                    <option></option>
                                                    @foreach ($classes as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-4">
                                                <label for="">Select Trimester:</label>
                                                <select name="semester" class="select2" required>
                                                    <option value="{{ config('constant.sem1') }}">{{ config('constant.sem1') }}
                                                    </option>
                                                    <option value="{{ config('constant.sem2') }}">{{ config('constant.sem2') }}
                                                    </option>
                                                    <option value="{{ config('constant.sem3') }}">{{ config('constant.sem3') }}
                                                    </option>
                                                    <option value="{{ config('constant.annual') }}">
                                                        {{ config('constant.annual') }}</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-12 col-md-12">
                                                <button type="submit" class="btn btn-success pull-right">generate</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
        </div>
    </div>
@endsection
@section('extrascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.0/sweetalert2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2({
                "placeholder": "Select item..",
                "allowClear": true
            });
        });
    </script>
@endsection
