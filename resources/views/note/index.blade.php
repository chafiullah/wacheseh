@extends('layouts.master')

@section('title', 'Send Notes to Admins')

@section('extrastyle')
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
         <div class="">
           <div class="clearfix"></div>
           <div class="row">
             <div class="col-md-12">
              <div class="x_panel">
                <div class="x_content table-responsive">
                    <h2 class="text-info">
                      <a href="javascript:void(0)" data-toggle="collapse" data-target="#sendNote" class="btn btn-info">Send New Note</a>
                    </h2>

                    <div class="collapse" id="sendNote"> 
                      <form action="{{ route('admin.note.send') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-12">
                              <label for="">Select User/s:</label>
                              <select name="userIDs[]" class="form-control select2" multiple required>
                                  <option></option>
                                  @foreach ($users as $item)
                                    @if (auth()->user()->id != $item->id)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endif
                                  @endforeach
                              </select>
                            </div>
                            <div class="form-group col-md-12">
                              <label for="">Subject:</label>
                              <input type="text" name="subject" id="" class="form-control" placeholder="" aria-describedby="helpId" required>
                            </div>
    
                            <div class="form-group col-md-12">
                              <label for="">Body:</label>
                              <textarea name="body" class="form-control" cols="10" rows="10" required></textarea>
                            </div>
                            <div class="form-group col-md-12">
                              <button type="submit" class="btn btn-success pull-right"><i class="fas fa-paper-plane    "></i> send note</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
              </div>
             </div>
             {{-- all received notes --}}
             <div class="col-md-12">
               <div class="x_panel">
                 <div class="x_content">
                   <a href="javascript:void(0)" class="btn btn-success pull-right" data-toggle="modal" data-target="#sentNotes" style="margin-bottom: 20px">Sent Notes</a>
                   <table class="table table-striped dataTable">
                     <thead>
                       <th>Note</th>
                       <th>Time</th>
                     </thead>
                     <tbody>
                       @foreach ($receivedNotes as $received)
                           <tr>
                             <td>
                              <a href="javascript:void(0)" data-toggle="collapse" data-target="{{ '#note'.$received->id }}">
                                <u>{{ $received->subject }} - from  {{ $received->user->name }}</u>
                              </a>
                              <div id="{{ 'note'.$received->id }}" class="collapse" style="font-size: 16px;color:black;margin-left:20px;">
                                {{ $received->note }}
                              </div>
                             </td>
                             <td>
                                {{ Carbon\Carbon::parse($received->created_at)->diffForHumans() }}
                             </td>
                           </tr>
                       @endforeach
                     </tbody>
                   </table>
                 </div>
               </div>
             </div>
           </div>
         </div>
        </div>
        <!-- /page content -->
        {{-- sent Items Modal --}}
        <!-- Modal -->
  <div id="sentNotes" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-body">
          <table class="table table-striped dataTable">
            <thead>
              <th>Note</th>
              <th>Time</th>
            </thead>
            <tbody>
              @foreach ($sentNotes as $sent)
                  <tr>
                    <td>
                     <a href="javascript:void(0)" data-toggle="collapse" data-target="{{ '#note'.$sent->id }}">
                      <u>{{ $sent->subject }} - from  {{ $sent->user->name }}</u>
                     </a>
                     <div id="{{ 'note'.$sent->id }}" class="collapse" style="font-size: 16px;color:black;margin-left:20px;">
                       {{ $sent->note }}
                     </div>
                    </td>
                    <td>
                       {{ Carbon\Carbon::parse($sent->created_at)->diffForHumans() }}
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>

@endsection

@section('extrascript')
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js
  "></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap.min.js
  "></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
  <script>
      $(document).ready(function () {
          $('.select2').select2({
              placeholder: 'select user/s',
              allowClear: true
          });
          $('.dataTable').DataTable();
      });
  </script>
@endsection
