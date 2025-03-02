@extends('layouts.master')

@section('content')
  <!-- page content -->
  <div class="right_col" role="main">
    <div class="">

      <div class="clearfix"></div>
      <!-- row start -->
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_content">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <td>{{ $file[2] }}</td>
                    <td>
                      <a href="{{ asset('public/backup' . '/' . $file[2]) }}">Download</a>
                    </td>
                  </tr>
                </tbody>
              </table>
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
