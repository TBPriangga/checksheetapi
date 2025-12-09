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
<div id="container">
    <div class="ibox" >
        <div class="ibox-title">
            <h4>Summary Project</h4>
        </div>
        <div class="ibox-content" >
          <div>
            @if(session()->has('success'))
                <div class="alert alert-primary">{{session('success')}}</div>
            @endif
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div style="overflow-x:auto">
            <table id="master" class="table table-bordered data-table">
              <thead>
                <tr>
                  <th class="text-center align-middle">No</th>
                  <th class="text-center align-middle" >Customer </th>
                  <th class="text-center align-middle" >Project </th>
                  <th class="text-center align-middle" >Product </th>
                  <th class="text-center align-middle" >Development Stage </th>
                  <th class="text-center align-middle" >Plan</th>
                  <th class="text-center align-middle">Progress</th>
                  <th class="text-center align-middle" >Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($data as $item)
                <tr>
                    <td class="text-center align-middle">{{ $loop->iteration }}</td>
                    <td class="text-center align-middle">{{ $item->customer }}</td>
                    <td class="text-center align-middle">{{ $item->project_title }}</td>
                    <td class="text-center align-middle">{{ $item->product }}</td>
                    <td class="text-center align-middle">{{ $item->last_insert_milestone }}</td>
                    <td class="text-center align-middle">{{ $item->percentage_not_approve."%"." (".$item->qty_plan_activity." Activities) " }}</td>
                    <td class="text-center align-middle">{{ $item->percentage_approve."%"." (".$item->qty_plan_activity_done." Activities) " }}</td>
                    <td class="text-center align-middle">
                      <?php
                        $delay = $item->percentage_not_approve - $item->percentage_approve;
                        if ($delay > 0) {
                            echo "<label class='label label-danger'>Delay</label>";
                        } else {
                            echo "<label class='label label-primary'>On Schedule</label>";
                        }
                      ?>
                    </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="ibox-footer">
          <button class="btn  btn-default " onClick="history.back()">Back</button>
        </div>
      </div>


</div>
@endsection

@push('scripts')
<script src="https://code.highcharts.com/gantt/highcharts-gantt.js"></script>
<script src="https://code.highcharts.com/gantt/modules/exporting.js"></script>
<script src="https://code.highcharts.com/gantt/modules/pattern-fill.js"></script>
<script src="https://code.highcharts.com/gantt/modules/accessibility.js"></script>
<script src="{{asset('js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/dataTables.dateTime.min.js')}}"></script>
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('js/js_agil/dataTables.responsive.js')}}"></script>
<script src="{{asset('js/moment.min.js')}}"></script>
<script src="{{asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>
<script>
    $(document).ready(function(){
      $('#master').DataTable();
    });
</script>


@endpush

@push('styles')

    
@endpush