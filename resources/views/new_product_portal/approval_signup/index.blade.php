@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')


{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

<link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

<div class="ibox" >
  <div class="ibox-title">
      <h4>Signup Approval </h4>
  </div>
  <div class="ibox-content" >
    <div>
      @if(session()->has('success'))
          <div class="alert alert-primary">{{session('success')}}</div>
      @endif
      @if(session()->has('fail'))
          <div class="alert alert-danger">{{session('fail')}}</div>
      @endif
    </div>
    <table id="master" class="table table-bordered">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th class="text-center">Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">NPK</th>
            <th class="text-center">Dept</th>
            <th class="text-center">Position</th>
            <th class="text-center">Detail Dept</th>
            <th class="text-center">Username</th>
            <th class="text-center">Role</th>
            <th class="text-center">Action</th>
        </thead>
        <tbody>
          @foreach ($signups as $signup)
              <tr class="text-center">
                  <td>{{$loop->iteration}}</td>
                  <td>{{$signup->name}}</td>
                  <td>{{$signup->email}}</td>
                  <td>{{$signup->npk}}</td>
                  <td>{{$signup->dept}}</td>
                  <td>{{$signup->position}}</td>
                  <td>{{$signup->detail_dept}}</td>
                  <td>{{$signup->username}}</td>
                  <td>{{$signup->role}}</td>
                  @role('Dept Head Approver')
                  <td>
                    <a href="{{ route('NewProductPortalSignupController.approve_dept', ['data' => $signup->id]) }}" class="btn btn-default btn-md "><i class="fa fa-check"></i></a>
                    <a href="{{ route('NewProductPortalSignupController.edit', ['data' => $signup->id]) }}" class="btn btn-secondary btn-md "><i class="fa fa-edit"></i></a>
                    <a href="{{ route('NewProductPortalSignupController.destroy', ['data' => $signup->id]) }}" class="btn btn-danger btn-md "><i class="fa fa-trash"></i></a>
                  </td>
                  @endrole
                  @role('User Approver')
                  <td>
                    <a href="{{ route('NewProductPortalSignupController.approve_superadmin', ['data' => $signup->id,'role_name' => $signup->role]) }}" class="btn btn-default btn-md "><i class="fa fa-check"></i></a>
                    <a href="{{ route('NewProductPortalSignupController.edit_superadmin', ['data' => $signup->id]) }}" class="btn btn-secondary btn-md "><i class="fa fa-edit"></i></a>
                    <a href="{{ route('NewProductPortalSignupController.destroy', ['data' => $signup->id]) }}" class="btn btn-danger btn-md "><i class="fa fa-trash"></i></a>
                  </td>
                  @endrole
                  @role('APQP Approver')
                  <td>
                    <a href="{{ route('NewProductPortalSignupController.approve_npd', ['data' => $signup->id,'role_name' => $signup->role]) }}" class="btn btn-default btn-md "><i class="fa fa-check"></i></a>
                    <a href="{{ route('NewProductPortalSignupController.edit_npd', ['data' => $signup->id]) }}" class="btn btn-secondary btn-md "><i class="fa fa-edit"></i></a>
                    <a href="{{ route('NewProductPortalSignupController.destroy', ['data' => $signup->id]) }}" class="btn btn-danger btn-md "><i class="fa fa-trash"></i></a>
                  </td>
                  @endrole
              </tr>
          @endforeach
        </tbody>
      </table>
  </div>
  <div class="ibox-footer">
    <button class="btn  btn-default " onClick="history.back()">Back</button>
  </div>
</div>


@endsection

@push('scripts')
    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
    <script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>
    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
    <script>
      $(document).ready(function(){
        // btn detail
        $(".edit_btn").click(function(){
          var id = $(this).attr('data-id');
          var role = $(this).attr('data-role-id');
          var dept = $(this).attr('data-dept-id');

          alert(id +" "+role+" "+dept);
        });
      });

    </script>
@endpush

