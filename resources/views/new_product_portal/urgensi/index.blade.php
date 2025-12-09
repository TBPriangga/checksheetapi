@extends('layouts.app-master')

@section('content')
    {{-- datatable library css --}}
    <link href="{{asset('css/dataTables.dateTime.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/select2/select2.min.css')}}" rel="stylesheet">

    <link href="{{asset('css/css_agil/responsive.dataTables.css')}}" rel="stylesheet">

    <!-- Sweet Alert -->
    <link href="{{asset('css/plugins/sweetalert/sweetalert.css')}}" rel="stylesheet">

    <div class="ibox-content">
        <h2>Urgensi</h2>
        {{-- <div class="lead">
            <a href="{{ route('urgensi.create') }}" class="btn btn-primary btn-sm float-right mb-1">Add Urgensi</a>
        </div> --}}
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table id="datatable" class="table table-bordered   ">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>type</th>
                    <th>Notif day PIC</th>
                    <th>Notif day SPV</th>
                    <th>Notif day Depthead</th>
                    <th>Notif day Director</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $item)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    @if ($item->type == "1")
                    <td>Normal</td>
                    @elseif($item->type == "2")
                    <td>Urgent</td>
                    @else
                    <td>Top Urgent</td>
                    @endif
                    <td>{{ $item->day_notif_pic." days"}}</td>
                    <td>{{ $item->day_notif_spv." days"}}</td>
                    <td>{{ $item->day_notif_depthead." days"}}</td>
                    <td>{{ $item->day_notif_director." days"}}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="{{ route('urgensi.edit', $item->id) }}">Edit</a>
                        {!! Form::open(['method' => 'DELETE','route' => ['urgensi.destroy', $item->id],'style'=>'display:inline']) !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm', 'onclick' => 'return confirm("Are you sure?")']) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
            </tbody>         
        </table>

       

    </div>
@endsection

@push('scripts')
<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
      $('#datatable').DataTable({
        // "pageLength": 2
      });
  } );
</script>
@endpush
