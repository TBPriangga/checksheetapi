@extends('component.navbar')

@section('content')

@include('component.message')  
{{-- yield  content--}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Management Patrol</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Management Patrol</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Schedule</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">

    </div>
</div>


{{-- div content  --}}

    {{-- start dashboard  --}}

{{-- end dashboard  --}}

{{-- start table  --}}

<div class="wrapper wrapper-content animated fadeInRight">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title bg-info">
                    <h5>Schedule</h5>
                </div>
                <div class="ibox-content">
                    <div class="row" style="margin-left:0">
                        
                        <div class="col-lg-9">

                        </div>
                        <div class="col-lg-3 m-3 m-sm-0">
                            <a class="btn btn-block btn-primary compose-mail mb-4" href="/genba/team/create">Tambah Team</a>
                        </div>
                    </div>
                          
                                {{-- start table 1 --}}
                    <div class="table-responsive mt-3">
                        <table class="footable table table-stripped toggle-arrow-tiny">
                            <thead>
                            <tr>
                                <th data-toggle="true" >Nama Team</th>
                                <th data-hide="all" class="text-center">Anggota Team</th>
                                <th class="text-center">Jumlah Anggota</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($teams as $team)   
                            <tr>
                                <td>{{ $team->name }}</td>
                                <td>
                                    @foreach($team->user as $user)
                                    - <strong> {{ $user->user->name }} </strong> <br>
                                    @endforeach 
                                </td>
                                <td class="text-center">{{ count($team->user) }}</td>
                                <td class="text-center"><a class="btn btn-info" href="/genba/team/{{ $team->id }}">See Detail</a> </td>
                            </tr>
                            @endforeach
                            </tbody>
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
    <script src={{ asset('js/bootstrap.js') }}></script>
    <script src="js/plugins/footable/footable.all.min.js"></script>
<script>
    $(document).ready(function() {

$('.footable').footable();

});
</script>
@endsection