@extends('layouts.master')

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">

            <div class="clearfix"></div>
            <!-- row start -->
            <div class="row">
                {{-- Generate list of students already promoted --}}
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_content">
                           <h4 class="text-info text-center my-3">Select Academic Year and Class and generate the list of students of that class from that Academic Year.</h4>
                            <form action="{{route('studentinfo.list.byAcademicYear')}}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">Select Academic Year:</label>
                                        <select name="academic_year" class="select2">
                                            <option></option>
                                            @foreach($academic_years as $year)
                                                <option value="{{$year->academic_year}}">{{$year->alias}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">Select Class:</label>
                                        <select name="class" class="select2">
                                            <option></option>
                                            @foreach($classes as $class)
                                                <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-success pull-right">Generate Student List</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- row end -->
                    <div class="clearfix"></div>
                </div>
                {{-- Promote Students ony by one --}}
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h4 class="text-info text-center my-3">Select academic year, class and list of students to promote students.</h4>
                        </div>
                        <div class="x_content">
                            <form action="{{route('student.promote')}}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">Select Academic Year:</label>
                                        <select name="academic_year" class="select2">
                                            <option></option>
                                            @foreach($academic_years as $year)
                                                <option value="{{$year->academic_year}}">{{$year->alias}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">Select Class:</label>
                                        <select name="class" class="select2">
                                            <option></option>
                                            @foreach($classes as $class)
                                                <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> 
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">Select Students:</label>
                                        <select name="students[]" class="select2" multiple>
                                            <option></option>
                                            @foreach($students as $student)
                                                <option value="{{$student->id}}">{{$student->student_id.'-'.$student->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">Select Outline:</label>
                                        <select name="outline" class="select2" multiple>
                                            <option></option>
                                            @foreach($outlines as $outline)
                                                <option value="{{$outline->id}}">{{$outline->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-success pull-right">Promote Students</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- row end -->
                    <div class="clearfix"></div>
                </div> 
                {{-- Updating list of students in bulk --}}
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h4 class="text-info text-center my-3">Select From Academic Year and Class To Academic Year and Class to promote student in bulk.</h4>
                        </div>
                        <div class="x_content">
                            <form action="{{route('student.promote.bulk')}}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">From Academic Year:</label>
                                        <select name="from_academic_year" class="select2">
                                            <option></option>
                                            @foreach($academic_years as $year)
                                                <option value="{{$year->academic_year}}">{{$year->alias}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-sm-12">
                                        <label for="">And Class:</label>
                                        <select name="from_class" class="select2">
                                            <option></option>
                                            @foreach($classes as $class)
                                                <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="">To Academic Year:</label>
                                        <select name="to_academic_year" class="select2">
                                            <option></option>
                                            @foreach($academic_years as $year)
                                                <option value="{{$year->academic_year}}">{{$year->alias}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="">And Class:</label>
                                        <select name="to_class" class="select2">
                                            <option></option>
                                            @foreach($classes as $class)
                                                <option value="{{$class->id}}">{{$class->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4 col-sm-12">
                                        <label for="">Select Outline:</label>
                                        <select name="outline" class="select2">
                                            <option></option>
                                            @foreach($outlines as $outline)
                                                <option value="{{$outline->id}}">{{$outline->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-success pull-right">Promote Students</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- row end -->
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection

@section('extrascript')
<script>
    $(document).ready(function (){
        $('.select2').select2({
            placeholder:'Select a value',
            allowClear:true
        });
    });
</script>
@endsection

