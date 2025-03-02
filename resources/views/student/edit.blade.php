@extends('layouts.master')

@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="row" style="margin-bottom: 20%">
                <div class="col-md-12 col-sm-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @if(Request::routeIs('student.comment.index'))
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h3 class="text-center">Student Comments</h3>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <form id="commentFrom">
                                    @csrf
                                    <input type="hidden" name="student_database_id" value="{{ $studentInfo->id }}">
                                    <input type="hidden" name="admin_id" value="{{ auth()->user()->id }}">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <label for="">Comment:</label>
                                                <input type="text" class="form-control" name="comment" required>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <button type="button" class="btn btn-success pull-right btn-sm"
                                                        style="margin-top: 10px" id="commentFormSubmitButton">add comment</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_content">
                                <ul class="list-group" id="comments">
                                    @foreach ($comments as $item)
                                        <li class="list-group-item">
                                        <span
                                                class="badge">{{ $item->admin->name . ' | ' . Carbon::parse($item->created_at)->format('d M Y m:s') }}
                                            @if (auth()->user()->id == $item->admin_id)
                                                <a href="{{ route('student.comment.delete', $item->id) }}"
                                                   class="text-danger badge">delete</a>
                                            @endif

                                        </span>
                                            {{ $item->comment }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Student Information Update<small class="text-danger"> * Feilds are required.</small></h2>
                                <div class="clearfix">+

                                </div>
                            </div>

                            <div class="x_content">
                                <form method="post" action="{{ route('studentInfo.update', $studentInfo->id) }}"
                                      enctype="multipart/form-data">
                                    @method('PATCH')
                                    @csrf
                                    <!--academic information-->
                                    <div class="form-row">
                                        <!--title-->
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="text-info text-center">Academic Information</h3>
                                        </div>
                                        <!--enrolled semester-->
                                        <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                            <label for="studentSession">Enrollment Session: <span
                                                        class="text-danger">*</span></label>
                                            <input type="date" name="admission_date"
                                                   value="{{ Carbon::parse($studentInfo->admission_date)->format('Y-m-d') }}"
                                                   class="form-control" required>

                                        </div>
                                        {{-- Series --}}
                                        <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                            <label for="student_series">Select a series: <span
                                                        class="text-danger">*</span></label>
                                            <select name="student_series" class="form-control" required>
                                                @foreach (config('constant.series') as $item)
                                                    <option value="{{ $item }}"
                                                            @if ($studentInfo->student_series == $item) selected @endif>{{ $item }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        {{-- Academic Status --}}
                                        <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                            <label for="program_id">Academic Status: <span class="text-danger">*</span></label>
                                            <select name="status" class="form-control" required>
                                                <option value="{{ config('constant.active') }}"
                                                        @if ($studentInfo->status == config('constant.active')) selected @endif>
                                                    {{ config('constant.active') }}</option>

                                                <option value="{{ config('constant.withdrawn') }}"
                                                        @if ($studentInfo->status == config('constant.withdrawn')) selected @endif>
                                                    {{ config('constant.withdrawn') }}</option>

                                                <option value="{{ config('constant.expelled') }}"
                                                        @if ($studentInfo->status == config('constant.expelled')) selected @endif>
                                                    {{ config('constant.expelled') }}</option>

                                                <option value="{{ config('constant.alumni') }}"
                                                        @if ($studentInfo->status == config('constant.alumni')) selected @endif>
                                                    {{ config('constant.alumni') }}</option>
                                            </select>

                                        </div>
                                        {{-- if student is a repeater --}}
                                        <div class="form-group col-md-3 col-lg-3 col-sm-12 col-xs-12">
                                            <label for="program_id">Is Repeater: <span class="text-danger">*</span></label>
                                            <select name="repeater" class="form-control has-feedback-left" required>
                                            <option value="no" @if ($studentInfo->repeater == 'no')
                                                selected
                                            @endif>No</option>
                                            <option value="yes" @if ($studentInfo->repeater == 'yes')
                                                selected
                                            @endif>Yes</option>
                                            </select>
                                            <i class="fa fa-info form-control-feedback left" aria-hidden="true"></i>
                                        </div>
                                    </div>

                                    <!--student information-->
                                    <div class="form-row">
                                        <!--title-->
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="text-info text-center" style="margin-top:4%">Student & Legal Guidance
                                                Information </h3>
                                        </div>

                                        <!--full name-->
                                        <div class="form-group col-md-3 col-sm-12 col-xs-12">
                                            <label for="firstName">Name: <span class="text-danger">*</span></label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                   required="required" value="{{ $studentInfo->name }}" />

                                        </div>
                                        <!--gender-->
                                        <div class="form-group col-md-3 col-sm-12 col-xs-12">
                                            <label for="gender">Gender: <span class="text-danger">*</span></label>
                                            <select class="form-control" name="gender">
                                                <option value="Male" @if ($studentInfo->gender == 'Male') selected @endif>Male
                                                </option>
                                                <option value="Female" @if ($studentInfo->gender == 'Female') selected @endif>Female
                                                </option>
                                            </select>

                                        </div>

                                        <!--Date of Birth-->
                                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                            <label for="dob">Date of birth: <span class="text-danger">*</span></label>
                                            <input type="date" name="date_of_birth" id="dob"
                                                   value="{{ Carbon::parse($studentInfo->date_of_birth)->format('Y-m-d') }}"
                                                   class="form-control" required>

                                        </div>
                                        <!--email address-->
                                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                            <label for="email ">Email Address :</label>
                                            <input type="email" id="email " class="form-control" name="email"
                                                   value="{{ $studentInfo->email }}" />

                                        </div>
                                        <!--student mobile number-->
                                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                            <label for="phone">Student Mobile Number:</label>
                                            <input type="text" class="form-control" name="phone"
                                                   value="{{ $studentInfo->phone }}" />

                                        </div>

                                        <!--Legal Guidance Information-->

                                        <!--full name-->
                                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                            <label for="firstName">Legal Guidance Name: <span
                                                        class="text-danger">*</span></label>
                                            <input type="text" id="legal_guidance"
                                                   value="{{ $studentInfo->legal_guidance }}" class="form-control"
                                                   name="legal_guidance" required="required" />

                                        </div>

                                        <!--email address-->
                                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                            <label for="email ">Legal Guidance Email Address :</label>
                                            <input type="email" id="guidance_email " class="form-control"
                                                   name="guidance_email" value="{{ $studentInfo->guidance_email }}"
                                                   data-parsley-trigger="change" />

                                        </div>
                                        <!--student mobile number-->
                                        <div class="form-group col-md-4 col-sm-12 col-xs-12">
                                            <label for="phone">Legal Guidance Mobile Number: <span
                                                        class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="guidance_phone"
                                                   value="{{ $studentInfo->guidance_phone }}"required />

                                        </div>
                                    </div>
                                    <!--geographic information-->
                                    <div class="form-row">
                                        <!--title-->
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="text-info text-center" style="margin-top:4%">Address Information</h3>
                                        </div>
                                        <!--Student Region-->
                                        <div class="form-group col-md-12 col-lg-12 col-sm-6 col-xs-6">
                                            <label for="program_id">Region: <span class="text-danger">*</span></label>
                                            <select name="region" class="form-control" required>
                                                @foreach ($regions as $item)
                                                    <option value="{{ $item->id }}"
                                                            @if ($studentInfo->getOriginal('region') == $item->id) selected @endif>{{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <!--present address-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <label for="address">Address: <span class="text-danger">*</span></label>
                                            <textarea id="address" required="required" class="form-control" name="address">{{ $studentInfo->address }}</textarea>

                                        </div>

                                    </div>
                                    <!--Files-->
                                    <div class="form-row">
                                        <!--title-->
                                        <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <h3 class="text-info text-center" style="margin-top:4%">File and Image Upload
                                                Section</h3>
                                        </div>
                                        {{-- student Image --}}
                                        <div class="form-group col-md-12 col-lg-12 col-sm-6 col-xs-6">
                                            <label for="program_id">Student Image: <span class="text-danger">*</span></label>
                                            <input type="file" name="image" class="form-control">

                                        </div>
                                        <!--previous record-->
                                        <div class="form-group col-md-12 col-lg-12 col-sm-6 col-xs-6">
                                            <label for="program_id">Report Card of Previous Academic Year: <span
                                                        class="text-danger">*</span></label>
                                            <input type="file" name="report_card" class="form-control">

                                        </div>
                                        <!--date of birth certificate-->
                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                            <label for="address">Date of Birth Certificate: <span
                                                        class="text-danger">*</span></label>
                                            <input type="file" name="birth_certificate" class="form-control">

                                        </div>

                                    </div>
                                    <!--submission-->
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-primary btn-lg pull-right">Submit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection

@section('extrascript')
    <script>
        $(document).ready(function() {
            $("#commentFormSubmitButton").on('click', function() {
                const formData = $("#commentFrom").serialize();
                $.ajax({
                    type: "post",
                    url: "{{ route('student.comment.store') }}",
                    data: formData,
                    dataType: "html",
                    success: function(response) {
                        $("#comments").empty();
                        $("#comments").html(response);
                        console.log(response)
                    }
                });
            });
        });
    </script>
@endsection
