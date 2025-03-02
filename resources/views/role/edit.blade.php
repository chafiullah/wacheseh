@extends('layouts.master')

@section('title', 'Role| Edit')

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
                    <h2>Edit Role<small> Role update with Permissions</small></h2>

                    <div class="clearfix"></div>
                  </div>
  <div class="x_content">
                     

    <form action="{{route('role.update',$role->id)}}" method="post" role="form">
    {{method_field('PATCH')}}
    {{csrf_field()}}

      <div class="form-group">
        <label for="name">Name of role</label>
        <input type="text" class="form-control" name="name" id="" placeholder="Name of role" value="{{$role->name}}">
      </div>
        <div class="form-group">
        <label for="display_name">Display name</label>
        <input type="text" class="form-control" name="display_name" id="" value="{{$role->display_name}}" placeholder="Display name">
      </div>
        <div class="form-group">
        <label for="description">Description</label>
        <input type="text" class="form-control" name="description" id="" placeholder="Description" value="{{$role->description}}">
      </div>


      <div class="row">
  <div class="col-md-12">
  <div class="form-group text-left">
    <h3>All Permissions</h3>
    @foreach($permissions as $permission)
    
      <input type="checkbox" {{in_array($permission->id,$role_permissions)?"checked":""}}  name="permission[]" value="{{$permission->id}}" > {{$permission->name}} <br>
      
    @endforeach
  </div>
</div>

</div>
      <button type="submit" class="btn btn-primary pull-right">Update</button>
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
<script src="{{ URL::asset('assets/js/validator.min.js')}}"></script>
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
   <!-- /validator -->
@endsection
