@extends('layouts.app-master')

@section('content')

    <div class="bg-light p-4 rounded">
        <h2>Logs</h2>
        <div class="lead">
            Manage your Logs here.
        </div>
        
        <div class="mt-2">
            @include('layouts.partials.messages')
        </div>

        <table id="datatable" class="display">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User Name</th>
                    <th>Last Login</th>
                    <th>IP Address</th>
                    <th>Download At</th>
                    <th>Download File</th>
                    <th>Delete At</th>
                    <th>Delete File</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $key => $log)
                <tr>
                    <td>{{ $loop->iteration + (($logs->currentPage() -1) * $logs->perPage())  }}</td>
                    <td>
                    @foreach($users as $user)
                        @if($user->id == $log->user_id)
                            {{ $user->name }}
                        @endif
                    @endforeach
                    </td>
                    <td>{{ $log->last_login_at }}</td>
                    <td>{{ $log->last_login_ip }}</td>
                    <td>{{ $log->last_download_file_at }}</td>
                    <td>
                    <!-- {{$log->last_download_file_id}} -->
                    @foreach($file_gets as $file)
                        @if($file->id == $log->last_download_file_id)
                            {{ $file->doc_name }}
                        @endif
                    @endforeach
                    </td>                
                    <td>{{ $log->last_delete_file_at }}</td>
                    <td>
                        <!-- {{ $log->last_delete_file_id }} -->
                        @foreach($file_trasheds as $filet)
                            @if($filet->id == $log->last_delete_file_id)
                                {{ $filet->doc_name }}
                            @endif
                        @endforeach
                    </td>
                </tr>
                @endforeach
            </tbody>         
        </table>

        <div class="d-flex">
            {!! $logs->links() !!}
        </div>

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
