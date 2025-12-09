@extends('component.navbar')

@section('content')
@include('component.message')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>EHS Patrol</h2>
        <ol class="breadcrumb"> 
            <li class="breadcrumb-item">
                <strong>Tabel Semua Temuan</strong>
            </li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>Tabel Laporan</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{route('exportLaporan')}}" method="post">
                        @csrf
                    <div class="row" style="margin-left:0">
                        <div class="col-sm-2 m-b-xs"><select class="form-control-sm form-control input-s-sm inline" id="rank-filter" name="rank">
                            <option value="0">All Rank</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                        </div>
                        <div class="col-sm-2 m-b-xs"><select class="form-control-sm form-control input-s-sm inline" id="kategori-filter" name="kategori">
                            <option value="0">All Kategori</option>
                            <option value="5R">5R</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="O">O</option>
                        </select>
                        </div>

                        <div class="col-sm-2 m-b-xs"><select class="form-control-sm form-control input-s-sm inline" id="status-filter" name="status">
                            <option value="0">All Status</option>
                            <option value="1">Open</option>
                            <option value="2">Approval 1 (Dept Head PIC)</option>
                            <option value="3">Approval 2 (EHS)</option>
                            <option value="4">Approval 3 (Dept Head EHS)</option>
                            <option value="5">CLOSED</option>
                            <option value="6">CANCEL</option>
                        </select>
                        </div>
                        
                        <div class="col-sm-2 m-b-xs"><select class="form-control-sm form-control input-s-sm inline" id="area-filter" name="area">
                            <option value="">All Area</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                        </div>
                        
                        <div class="col-sm-4 m-b-xs form-group " id="data_5">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                <input type="text" class="form-control-sm form-control" id="time-start" name="timeStart" value="01/01/2000"/>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" id="time-end" name="timeEnd" value="{{ date('d/m/Y') }}" />
                            </div>
                        </div>
                        <div class="col-sm-1">

                        </div>
                    </div>
                    <div class="row mt-3" style="margin-left:0">
                        <div class="col-2 offset-6">
                            
                        </div>
                        <div class="col-sm-2 offset-sm-10 m-3 m-sm-0 text-end">
                            
                        </div>
                        <div class="col-sm-2 mx-3 m-sm-0 text-end">
                            <button class="btn btn-block btn-info compose-mail" type="submit">Export laporan</button>
                        </div>
                    </div>
                    <input type="hidden" name="tipe_tabel" id="tipeTable" value="semua">
                    </form> 
                    
                    <div class="col-sm-1">
                    </div>
                                {{-- start table 1 --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered table-hover dataTables-example" width="100%">
                            <thead>
                            <tr>
                                <th class="col-1">No</th>
                                <th class="text-center col">Temuan</th>
                                <th class="text-center col-1" >Area</th>
                                <th class="text-center col-1" >Kategori Stop-6</th>
                                <th class="text-center col-1" >Rank</th>
                                <th class="text-center col-1" >Tanggal Laporan</th>
                                <th class="text-center col-1" >Due Date</th>
                                <th class="text-center col-1" >Status</th>
                                <th class="text-center col-1" >Assign To</th>
                                <th class="text-center col-1" >Action</th>
                            </tr>
                            </thead>
                            
                            <tfoot>
                                    
                            </tfoot>
                        </table>
                    </div>
                    {{-- end table 1 --}}
          
                </div>
                {{-- end ibox-content --}}
            </div>
        </div>

    </div>
</div>

@endsection