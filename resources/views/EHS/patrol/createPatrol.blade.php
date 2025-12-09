@extends('component.navbar')

@section('content')

@include('component.message')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EHS Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{route('patrolEhs')}}">Table EHS Patrol</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Buat Laporan</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Form Data</h5>
            </div>
            <div class="ibox-content">
                <form id="submitForm" method="post" action="{{route('createPatrolStore')}}">
                    @csrf

                    <div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
                        <div class="col-sm-4">
                            <select class="select2_demo_3 form-control" name="area_id" required>
                                <option></option>
                                @foreach($areas as $area)
                                <option value={{ $area->id }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <label class="col-sm-2 col-form-label">Tanggal Patrol</label>
                        <div class="col-sm-4" id="data_2">
                            <div class="input-group date">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" name="tanggal_patrol" class="form-control" value="{{ date('d/m/Y') }}" required>
                            </div>
                        </div>
                
                    </div>
                    
                    <div class="hr-line-dashed"></div>

                    <div class="form-group row">
                        <div class="col-sm-4 col-sm-offset-2">
                            <a class="btn btn-white btn-sm" href="{{url('/patrolEHS')}}">Cancel</a>
                            <button id="submitButton" class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

@endsection