@extends('layouts.master')

@section('title', 'Role - create')

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
              <h3>Create Roles</h3>

              <div class="clearfix"></div>
            </div>
            <div class="x_content">


              <form action="{{ route('role.store') }}" method="post" role="form">
                @csrf
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="name">Name of Role</label>
                    <input type="text" class="form-control" name="name" id="" placeholder="Name of role">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="display_name">Display name</label>
                    <input type="text" class="form-control" name="display_name" id="" placeholder="Display name">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="description">Description</label>
                    <input type="text" class="form-control" name="description" id="" placeholder="Description">
                  </div>
                  <div class="form-group col-md-12 text-left">
                    <h3>Assigned Permissions</h3>
                    @foreach ($permissions as $permission)
                      <input type="checkbox" name="permission[]" value="{{ $permission->id }}"> {{ $permission->name }} <br>
                    @endforeach
                  </div>
                  <div class="form-group col-md-12 text-left">
                    <button type="submit" class="btn btn-primary pull-right">Submit</button>
                  </div>
                </div>
              </form>

            </div>
          </div>
          <!-- row end -->
          <div class="clearfix"></div>

        </div>
      </div>
      <!-- /page content -->
    @endsection
    @section('extrascript')
      <script src="{{ URL::asset('assets/js/validator.min.js') }}"></script>
      <script src="{{ URL::asset('assets/js/jquery.inputmask.bundle.min.js') }}"></script>
      <!-- validator -->
      <script>
        // initialize the validator function
        validator.message.date = 'not a real date';

        // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
        $('form')
          .on('blur', 'input[required], input.optional, select.required', validator.checkField)
          .on('change', 'select.required', validator.checkField)
          .on('keypress', 'input[required][pattern]', validator.keypress);


        $('form').submit(function(e) {
          e.preventDefault();
          var submit = true;

          // evaluate the form using generic validaing
          if (!validator.checkAll($(this))) {
            submit = false;
          }

          if (submit)
            this.submit();

          return false;
        });
      </script>
      <script>
        $(document).ready(function() {

          $("#acyear_start").inputmask();
        });
      </script>
      <!-- /validator -->
    @endsection
