@extends('admin_student.master')

@section('title')
  Student || Dashboard
@endsection

@section('main')
  <div class="row mt-3">
    <div class="col-md-12 col-12 mt-3">
      <table class="table table-striped">
        <thead>
          <tr>
            <th>File Name</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($documents as $item)
            <tr>
              <td>{{ $item->title }}</td>
              <td><a href="{{ Storage::url('app/public/documents/' . $item->file) }}" download>click to download</a></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@endsection
