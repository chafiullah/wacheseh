@extends('layouts.master')

@section('title', 'Result Additional Data')

@section('extrastyle')
    <link href="{{ URL::asset('assets/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h4 class="text-info">What are we doing here?</h4>
                            <p>Here we will insert the additional data related to our academic report cards. Still not clear? Let us be more specific:</p>
                            <ul>
                                <li>When we generated the report cards, we inserted the additional data before.</li>
                                <li><b>Such as: Unjustified Hours, Late, Warning, etc.</b></li>
                                <li>When you will bulk generate the report cards, there is no chance that, for each individual student you will insert the data while the process is running.</li>
                                <li>So, here in this section you will select each individual student and the additional data to store in the database.</li>
                                <li>While generating the report cards in bulk, the system will fetch these data and use it for printing.</li>
                                <li>Make sure you insert the correct data here, otherwise the only option to rectify is deleting the data and insert it again.</li>
                                <li class="text-danger">Remember that: the fields except <b>remarks</b> will not accept empty values. So, do not remove N/A if you wish to keep it empty.</li>
                                <li class="text-info">Also, this section is a free area which means you can add details for any student, any year and class. So, if you are looking for something more efficient you have to try the import option where you can upload in bulk.</li>
                            </ul>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="col-12">
                                    <h4  class="text-info">Add Single Information:</h4>
                                    <form action="{{route('additional_data.store')}}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <!-- student list -->
                                            <div class="form-group col-md-4 col-sm-12">
                                                <label for="">Select Student:</label>
                                                <select name="student_id" class="select2">
                                                    <option value=""></option>
                                                    @foreach($students as $student)
                                                        <option value="{{$student->id}}">{{$student->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- class list -->
                                            <div class="form-group col-md-4 col-sm-12">
                                                <label for="">Select Class:</label>
                                                <select name="class_id" class="select2">
                                                    <option value=""></option>
                                                    @foreach($classes as $class)
                                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- semester list -->
                                            <div class="form-group col-md-4 col-sm-12">
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
                                        </div>
                                        {{--                                    Additional Data --}}
                                        <div class="form-row">
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="">Unjustified Absent:</label>
                                                <input type="text" name="un_absent" class="form-control" value="N/A" required>
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="">Late (No. of Hours):</label>
                                                <input type="text" name="late" class="form-control" value="N/A" required>
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="">Warning:</label>
                                                <input type="text" name="warning" class="form-control" value="N/A" required >
                                            </div>
                                            <div class="form-group col-md-3 col-sm-12">
                                                <label for="">Reprimand:</label>
                                                <input type="text" name="reprimand" class="form-control" value="N/A" required >
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label for="">Suspension:</label>
                                                <input type="text" name="suspension" class="form-control" value="N/A" required >
                                            </div>
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label for="">Class Master:</label>
                                                <input type="text" name="class_master" class="form-control" value="N/A" required>
                                            </div>
                                            <div class="form-group col-md-12 col-sm-12">
                                                <label for="">Remarks (max 120 characters):</label>
                                                <textarea name="remarks" class="form-control" maxlength="120"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-success pull-right">submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <h4  class="text-info">Import From Excel:</h4>
                                    <form action="{{route('additional_data.import')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-12">
                                                <label for="">Upload:</label>
                                                <input type="file" name="excel_file" class="form-control">
                                            </div>
                                            <div class="form-group col-12">
                                                <button type="submit" class="btn btn-success pull-right">submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-12">
                                    <h4 class="text-info">Generate List of Data</h4>
                                    <p>This section will also help you with bulk uploading additional data. To bulk upload select the academic year and semester then click on **generate**.</p>
                                    <form action="{{route('additional_data.list')}}" method="post">
                                        @csrf
                                        <div class="form-row">
                                            <!-- class list -->
                                            <div class="form-group col-md-6 col-sm-12">
                                                <label for="">Select Class:</label>
                                                <select name="class_id" class="select2">
                                                    <option value=""></option>
                                                    @foreach($classes as $class)
                                                        <option value="{{$class->id}}">{{$class->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- semester list -->
                                            <div class="form-group col-md-6 col-sm-12">
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
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-12">
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
        </div>
    </div>
@endsection
@section('extrascript')
    <script>
        $(document).ready(function() {
            $(".select2").select2({
                "placeholder": "Select item..",
                "allowClear": true
            });
        });
    </script>
@endsection
