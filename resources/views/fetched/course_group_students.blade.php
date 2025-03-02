<a href="#" class="btn btn-info" data-toggle="modal" data-target="#add_student_modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> add new student</a>
@if ($students == 'none')
  <div class="list-group">
    <a href="javascript:void(0)" class="list-group-item">No Student Found <i class="fa fa-info-circle" aria-hidden="true"></i></a>
  </div>
@else
  <table class="table table-striped">
    <thead>
      <tr>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
      </tr>
    <tbody>
      @foreach ($students as $item)
        <tr>
          <td>{{ $item->student->first_name }}</td>
          <td>{{ $item->student->last_name }}</td>
          <td>{{ $item->student->email }}</td>
          <td>{{ $item->student->phone }}</td>
          <td>
            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="delete_group_student({{ $item->id }},{{ $group_id }})" data-toggle="tooltip" data-placement="top"
              title="remove-student"><i class="fa fa-trash" aria-hidden="true"></i></a>

            <a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="send_mail('{{ $item->student_id }}')" data-toggle="tooltip" data-placement="top" title="send-email"><i
                class="fa fa-envelope" aria-hidden="true"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
    </thead>
  </table>
@endif

<!-- Modal -->
<div class="modal fade" id="add_student_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-row">
            <div class="form-group col-md-12">
              <input type="hidden" name="group_id" value="{{ $group_id }}" id="group_id">
              <label for="">Selecte students:</label>
              <select name="students[]" class="form-control" id="selected_students" multiple>
                <option></option>
                @foreach ($available_students as $available_student)
                  <option value="{{ $available_student->student->id }}">{{ $available_student->student->first_name . ' ' . $available_student->student->last_name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="form-group col-md-12">
              <button class="btn btn-success pull-right" type="button" onclick="add_students_to_group()">add to group</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
{{-- Modal for sending group email --}}
<div class="modal fade" id="send_mail_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Send New Email</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('send.mail.send') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="">Student ID:</label>
              <input type="text" name="studentIDs[]" class="form-control" id="student_id_for_email" readonly>
            </div>
            <div class="form-group col-md-12">
              <label for="">Subject:</label>
              <input type="text" name="subject" id="" class="form-control" placeholder="" aria-describedby="helpId">
            </div>
            <div class="form-group col-md-12">
              <label for="">Body:</label>
              <textarea name="body" class="summernote form-control"></textarea>
            </div>
            <div class="form-group col-md-12">
              <button type="submit" class="btn btn-success pull-right">send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $("#selected_students").select2({
    placeholder: "select studnets.....",
    dropdownParent: $("#add_student_modal")
  });

  function send_mail(studentID) {
    $("#send_mail_modal").modal('toggle');
    $("#student_id_for_email").val(studentID);
  }
</script>
