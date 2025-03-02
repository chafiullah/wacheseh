<a href="#" class="btn btn-info" data-toggle="modal" data-target="#gourp_create_modal"><i class="fa fa-plus-circle" aria-hidden="true"></i> create new</a>
@if ($groups == 'none')
  <div class="list-group">
    <a href="javascript:void(0)" class="list-group-item">No Groups Found <i class="fa fa-info-circle" aria-hidden="true"></i></a>
  </div>
@else
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Group Name</th>
        <th>Action</th>
      </tr>
    <tbody>
      @foreach ($groups as $item)
        <tr>
          <td>{{ $item->group_name }}</td>
          <td>
            <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="send-group-email" onclick="open_send_mail_modal({{ $item->id }})"><i
                class="fa fa-envelope" aria-hidden="true"></i></a>
            <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="get_students({{ $item->id }})"><i class="fa fa-users" aria-hidden="true"></i></a>
            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="delete_group({{ $item->id }})"><i class="fa fa-trash" aria-hidden="true"></i></a>
          </td>
        </tr>
      @endforeach
    </tbody>
    </thead>
  </table>
@endif

<!-- Modal for creating new group -->
<div class="modal fade" id="gourp_create_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Create New Group</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="">Gorup Name:</label>
              <input type="text" id="gourp_name" class="form-control">
            </div>
            <div class="form-group col-md-12">
              <button class="btn btn-success pull-right" type="button" onclick="create_group()">create</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Modal for sending group email --}}
<div class="modal fade" id="group_mail_modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Send New Group Email</h4>
      </div>
      <div class="modal-body">
        <form action="{{ route('teacher.email.send') }}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="form-row">
            <input type="hidden" name="student_group_id_for_email" id="student_group_id_for_email">
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
  $('.summernote').summernote({
    placeholder: 'Email Body Here...',
    tabsize: 2,
    height: 200
  });
  // open the modal
  function open_send_mail_modal(group_id) {
    $("#student_group_id_for_email").val(group_id);
    $("#group_mail_modal").modal('toggle');
  }
</script>
