@extends('component.navbar')

@section('content')

@include('component.message')

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Area Management</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Setting Management</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Area Management</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


{{-- div content  --}}

{{-- start table  --}}

<div class="wrapper wrapper-content animated fadeInRight">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Daftar Area</h5>
                </div>
                <div class="ibox-content">
                    <div class="row" style="margin-left:0">                        
                        
                        <div class="col-sm-9">

                        </div>
                        <div class="col-lg-3 col-md-3 m-3 m-sm-0">
                            <button type="button" class="btn btn-primary btn-block compose-mail" data-toggle="modal" data-target="#myModal1">
                                Tambah Area
                            </button>
                        </div>
                    </div>

{{-- start modal  --}}
<div class="modal inmodal fade" id="myModal1" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Input Nama Area</h4>
            </div>
            <form method="post" action="{{route('areaStore')}}">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-6 offset-3">
                        <div class="form-group mb-0">
                            <input id="name" name="name" type="text" class="form-control required" required>
                        </div>
                    </div>
                </div>

                
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah Area</button>
            </div>
        </form>
        </div>
    </div>
</div>
{{-- endmodal  --}}
                          
                                {{-- start table 1 --}}
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered table-hover dataTables-example-area">
                            <thead>
                            <tr>
                                <th class="col-1">No</th>
                                <th class="text-center">Nama Area </th>
                                <th class="text-center col-1 col-md-3">Action Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($areas as $area)
                                    
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td class="text-center">{{ $area->name }}</td>
                                    <td class="text-center">
                                        <div class="row">
                                            <div class="col">
                                        <button type="button" class="btn btn-warning d-block d-md-inline-block compose-mail" data-toggle="modal" data-target="#modal{{ $area->id }}">
                                            See Detail
                                        </button>
                                            </div>
    {{-- start modal  --}}
                                        <div class="modal inmodal fade" id="modal{{ $area->id }}" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                        <h4 class="modal-title">Area {{ $area->name }}</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('picAssign')}}" method="POST">
                                                            @csrf
                                                            @php 
                                                                $areaHasPIC = false;
                                                                $areaHasDeptPIC = false;
                                                            @endphp
                                                            <input type="hidden" name="area_id" value={{ $area->id }}>
                                                        <div class="row mb-3">
                                                            <div class="col-md-5">
                                                                    <select class="form-control" name="user_id" required>
                                                                        <option value="" selected>Select PIC</option>
                                                                        @foreach($area->area as $user)
                                                                            @if($user->user->roles[0]->name == "PIC")
                                                                                @php 
                                                                                    $areaHasPIC = true;
                                                                                @endphp
                                                                            @elseif($user->user->roles[0]->name == "Departement Head PIC")
                                                                            @php 
                                                                                $areaHasDeptPIC = true;
                                                                            @endphp
                                                                            @endif
                                                                        @endforeach
                                                                        @foreach($users as $user)
                                                                            @if($user->roles[0]->name == "PIC")
                                                                                @if(!$areaHasPIC)
                                                                                    @php 
                                                                                        $checkpic = true;
                                                                                    @endphp


                                                                                    @foreach($user->area as $userArea)
                                                                                    @if($userArea->area_id == $area->id)
                                                                                        @php
                                                                                            $checkpic = false;
                                                                                        @endphp
                                                                                    @endif
                                                                                    @endforeach
                                                                                    @if($checkpic) 
                                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                                    @endif
                                                                                @endif
                                                                            @else
                                                                                @if(!$areaHasDeptPIC)
                                                                                    @php 
                                                                                        $check = true;
                                                                                    @endphp
                                                                            
                                                                                    @foreach($user->area as $userArea)
                                                                                        @if($userArea->area_id == $area->id)
                                                                                            @php
                                                                                                $check = false;
                                                                                            @endphp
                                                                                        @endif
                                                                                    @endforeach
                                                                            
                                                                                    @if($check) 
                                                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                                                    @endif
                                                                                @endif
                                                                             @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2 offset-md-5">
                                                                    <button class="btn btn-block btn-primary compose-mail" type="submit">Tambah PIC</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="row mb-3"></div>
                                                        <div class="">
                                                            <h3><strong>List PIC</strong></h3>
                                                        </div>
                                                    <div class="row">
                                                        <table class="footable table table-stripped toggle-arrow-tiny">
                                                            <thead>
                                                                <tr>
                                                                    <th class="col-1">No</th>
                                                                    <th class="col-4">Nama PIC</th>
                                                                    <th class="col-2">Departement</th>
                                                                    <th class="col-2">Position</th>
                                                                    <th class="col-2">Role</th>
                                                                    <th class="text-center col-1">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($area->area as $pic)
                                                                <form action="{{route('removeAreaPic')}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value={{ $pic->id }}>
                                                            <tr>
                                                                <td class="text-center col-1">{{ $loop->index + 1 }}</td>
                                                                <td class="text-center col-4">{{ $pic->user->name }}</td>
                                                                <td class="text-center col-3">{{ $pic->user->department->name }}</td>
                                                                <td class="text-center col-3">{{ $pic->user->position->position }}</td>
                                                                <td class="text-center col-3">{{ $pic->user->roles[0]->name }}</td>
                                                                <td>
                                                                <button class="btn btn-danger btn-block compose-mail col" type="submit">Hapus</a>
                                                                </td>
                                                            </tr>
                                                        </form>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                    </div>
            
                                                    <div class="modal-footer">
                                                        
                                                        <button type="submit" class="btn btn-white" data-dismiss="modal">Close</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- endmodal  --}}
    
                                        <div class="col">
                                            
                                        <form method="post" action="{{url('area/delete')}}" class="d-block d-xl-inline-block ">
                                            @csrf
                                            <input type="hidden" value={{ $area->id }} name="id">
                                        <button type="submit" class="btn btn-danger mt-sm-0 mt-2" >Hapus</button>
                                    </form>
                                </div>
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

{{-- end div content  --}}

{{-- end yield content --}}
@endsection

@section('scripts')
<script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
<script src={{ asset('js/plugins/select2/select2.full.min.js') }}></script>
<script>
    $(document).ready(function(){
            $('.dataTables-example-area').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [ ],
            });

            

        });
</script>
@endsection