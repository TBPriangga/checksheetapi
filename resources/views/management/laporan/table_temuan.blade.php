@extends('component.navbar')

@section('content')
@include('component.message')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Laporan</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Laporan</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Tabel Laporan</strong>
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
                    <form action="/genba_export" method="post">
                        @csrf
                        <input type="hidden" name="genba_table" id="genba_table" value="genba_table" >
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
                            <option value="2">Progress</option>
                            <option value="3">Closed</option>
                            <option value="4">Verified</option>
                            <option value="5">Approved</option>
                        </select>
                        </div>

                        @if (auth()->user()->getRoleNames()[0] != "PIC")
                        <div class="col-sm-2 m-b-xs"><select class="form-control-sm form-control input-s-sm inline" id="area-filter" name="area">
                            <option value="">All Area</option>
                            @foreach($areas as $area)
                            <option value="{{ $area->id }}">{{ $area->name }}</option>
                            @endforeach
                        </select>
                        </div>
                        @endif
                        @if (auth()->user()->getRoleNames()[0] == "PIC")
                        <div class="col-sm-2">

                        </div>
                        @endif
                        <div class="col-sm-4 m-b-xs form-group " id="data_5">
                            <div class="input-daterange input-group" id="datepicker">
                                <span class="input-group-addon">From</span>
                                <input type="text" class="form-control-sm form-control" id="time-start" name="timeStart" value="01/01/2000"/>
                                <span class="input-group-addon">to</span>
                                <input type="text" class="form-control-sm form-control" id="time-end" name="timeEnd" value="{{ date('m/d/Y') }}" />
                            </div>
                        </div>
                        <div class="col-sm-1">
                            @if (auth()->user()->getRoleNames()[0] != "PIC")
                            <input type="hidden" name="tipe_tabel" id="tipeTable" value="semua">
                            @else
                            <input type="hidden" name="tipe_tabel" id="tipeTable" value="{{ auth()->user()->area[0]->area_id }}">
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3" style="margin-left:0">
                        <div class="col-2 offset-8">
                            
                        </div>
                        <div class="col-sm-2 mx-3 m-sm-0 text-end">
                            <button class="btn btn-block btn-info compose-mail text-white" type="submit">Export laporan</button>
                        </div>
                    </div>
                    </form> 
                                {{-- start table 1 --}}
                    <div class="table-responsive mt-3 ">
                        <table class="table table-striped table-bordered table-hover dataTables-example-genba" >
                            <thead>
                            <tr>
                                <th class="" >No</th>
                                <th class="text-center col-2" >Area</th>
                                <th class="text-center col-1" >Rank</th>
                                <th class="text-center col-2" >Kategori</th>
                                <th class="text-center col-3" >Tanggal Laporan</th>
                                <th class="text-center col-2" >Deadline</th>
                                <th class="text-center col-1" >status </th>
                                <th class="text-center col-1" >Action </th>
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
@push('scripts')

@endpush 
@endsection