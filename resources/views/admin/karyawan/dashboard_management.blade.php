@extends('component.navbar')

@section('content')

@include('component.message')  
{{-- yield  content--}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Account Management</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Setting Management</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Account Management</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


{{-- div content  --}}
<div class="wrapper wrapper-content animated fadeInRight"> 
    
    {{-- start dashboard  --}}

    <div class="row">
        <div class="col-lg-4 col-12">
                <div class="widget style1 navy-bg">
                    <div class="row vertical-align">
                        <div class="col-sm-3 col-2">
                            <i class="fa fa-user fa-3x"></i>
                        </div>
                        <div class="col-sm-3 col-5">
                            <h2> KARYAWAN </h2>
                        </div>
                        <div class="col-sm-5 col col-sm-6 col text-right">
                            <h2 class="font-bold">{{ $jumlahKaryawans }}</h2>
                        </div>
                    </div>
                </div>
        </div>

        <div class="col-lg-5 col-12">
                <div class="widget style1 lazur-bg">
                    <div class="row vertical-align">
                        <div class="col-sm-3 col-2">
                            <i class="fa fa-building fa-3x"></i>
                        </div>
                        <div class="col-sm-3 col-5">
                            <h2> Departement </h2>
                        </div>
                        <div class="col-sm-5 col-sm-6 col text-right">
                            <h2 class="font-bold">{{ $departements }}</h2>
                        </div>
                    </div>
                </div>
        </div>

        <div class="col-lg-3 col-12">
                <div class="widget style1 yellow-bg">
                    <div class="row vertical-align">
                        <div class="col-sm-3 col-2">
                            <i class="fa fa-jsfiddle fa-3x"></i>
                        </div>
                        <div class="col-sm-3 col-5">
                            <h2> Position </h2>
                        </div>
                        <div class="col-5 col-sm-6 col text-right">
                            <h2 class="font-bold">{{ $positions }}</h2>
                        </div>
                    </div>
                </div>
        </div>
        

    </div>
{{-- end dashboard  --}}

{{-- start table  --}}

<div class="wrapper wrapper-content animated fadeInRight">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Daftar Karyawan</h5>
                </div>
                <div class="ibox-content">
                    <div class="row" style="margin-left:0">
                        
                        <div class="col-lg-9">

                        </div>
                        <div class="col-lg-3 m-3 m-sm-0">
                            <a class="btn btn-block btn-primary compose-mail" href="{{route('createKaryawan')}}">Tambah Karyawan</a>
                        </div>
                    </div>
                          
                                {{-- start table 1 --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered table-hover dataTables-example-karyawan">
                            <thead>
                            <tr>
                                <th class="all">No</th>
                                <th class="text-center all">Nama </th>
                                <th class="text-center max_handphone" >NPK </th>
                                <th class="text-center max_handphone" >Departement</th>
                                <th class="text-center max_handphone" >Position</th>
                                <th class="text-center max_handphone" >Role</th>
                                <th class="text-center max_handphone">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($karyawans as $karyawan)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td class="text-center">{{ $karyawan->name }}</td>
                                <td class="text-center">{{ $karyawan->npk }}</td>
                                <td class="text-center">{{ $karyawan->department->name }}</td>
                                <td class="text-center">{{ $karyawan->position->position }}</td>
                                <td class="text-center">
                                    @foreach($karyawan->roles as $key => $role)
                                        {{ $role->name }}
                                        @if($key !== count($karyawan->roles) - 1)
                                            ,
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <a class="btn btn-info btn-block compose-mail" href="{{ route('detailKaryawan', ['id' => $karyawan->id]) }}">See Detail</a>
                                </td>
                            </tr>
                            @endforeach
                                
                            </tbody>
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
{{-- end table  --}}

</div>
{{-- end div content  --}}

{{-- end yield content --}}
@endsection

@section('scripts')
<script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
<script src={{ asset('js/plugins/select2/select2.full.min.js') }}></script>
<script>
    $(document).ready(function(){
            $('.dataTables-example-karyawan').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [ ],
            });

            

        });
</script>
@endsection