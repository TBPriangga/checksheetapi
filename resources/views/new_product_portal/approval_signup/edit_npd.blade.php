@extends('layouts.app-master')
 
@section('title', 'AJI MIS | DELIVERY')
 
 
@section('content')


{{-- datatable library css --}}
<link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
<link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/chosen/bootstrap-chosen.css')}}" rel="stylesheet">

<link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

<!-- Sweet Alert -->
<link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

<div class="ibox col-lg-6" >
  <div class="ibox-title">
      <h4>Register User Edit </h4>
  </div>
  <div class="ibox-content " >
    <div>
      @if(session()->has('success'))
          <div class="alert alert-primary">{{session('success')}}</div>
      @endif
      @if(session()->has('fail'))
          <div class="alert alert-danger">{{session('fail')}}</div>
      @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if(session()->has('success'))
                <div class="alert alert-primary mb-1">{{session('success')}}</div>
            @endif
            <form class="m-t" role="form" method="post" action="{{route('NewProductPortalSignupController.update_npd')}}">
                @csrf
                <input type="hidden" name="id" value="{{$data->id}}">
                <div class="form-group">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" required value="{{$data->email}}">
                    @error('email') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Name" required value="{{$data->name}}">
                    @error('name') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" placeholder="Username" required value="{{$data->username}}" autocomplete="off">
                    @error('username') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <select class="form-control" name="dept" id="dept" required>
                        <option value="">-- Department --</option>
                        @foreach ($depts as $dept)
                        <option value="{{ $dept->id }}" {{ ( $data->dept == $dept->id ? "selected":"") }}>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    @error('dept') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <select class="form-control chosen-select" data-placeholder=" --Role--" name="role[]" id="role" tabindex="4" multiple required>
                        @foreach ($roles as $role)
                        <option value="{{ $role->name }}" 
                            {{ 
                                ( in_array($role->name, explode(",",$data->role)) ? "selected":"")
                            }}
                        >
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('role') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="number"  size="5" class="form-control @error('npk') is-invalid @enderror" name="npk" placeholder="NPK" value="{{$data->npk}}" autocomplete="off" required>
                    @error('npk') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" value="{{$data->password}}" autocomplete="off" required readonly>
                    @error('password') 
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b"style="background-color:#225879">Update</button>
            </form>
        </div>
    </div>
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
    <script src="{{asset('js/plugins/chosen/chosen.jquery.js')}}"></script>
    <script>
        $('.chosen-select').chosen({width: "100%"});
        $('#role').change(function(){
        //         console.log($(this).val());
        //     });
        // $(document).ready(){function(){
        //     $('#role').change(function(){
        //         console.log($(this).val());
        //     });
        });

    </script>
@endpush



