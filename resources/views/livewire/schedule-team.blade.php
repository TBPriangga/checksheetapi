
<form method="post" action="/genba/schedule/store" enctype="multipart/form-data">

    @csrf
<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Form</h5>
            </div>
            <div class="ibox-content">
                @livewire('form-area-p-i-c')
                @stack('scripts')

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tanggal Patrol</label>
        <div class="col-sm-4" id="data_schedule">
            <div class="input-group date" >
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" class="form-control" name="tanggal_patrol" value="{{ date('d/m/Y') }}">
            </div>
        </div>
        
            <label class="col-sm-1 col-form-label">Team</label>
            <div wire:ignore class="col-sm-4">
                <select  class="select2_demo_schedule form-control" name="team_id" required>
                    <option></option>
                    @foreach($teams as $team)
                        <option value={{ $team->id }}>{{ $team->name }}</option>
                    @endforeach
                </select>
            </div>
            @foreach($team_members as $member)
            <input type="hidden" name="userID[]" value={{ $member->user->id }}>
            @endforeach
        </div>

    </div>
</div>
</div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title bg-info">
                <h5>Team Memeber</h5>
            </div>
        <div class="ibox-content">
    
    <table class="table table-striped">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Departement</th>
            <th>Position</th>
            <th class="col-sm-1 text-center">PIC Auditor</th>
            <th class="text-center">Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach($team_members as $member)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $member->user->name }}</td>
                <td>{{ $member->user->detail->name }}</td>
                <td>{{ $member->user->position->position }}</td>
                <td class="text-center">
                    <div><input type="checkbox" name="PIC_auditor" value="{{ $member->user->id }}" onclick="checkedBox(this)"></div>
                </td>
                <td class="text-center text-white"><a class="btn btn-danger" wire:click="hapusUser('{{ $member->user->id }}')">Hapus</a> </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row" style="margin-left:0">
                        
        <div class="col-lg-9">

        </div>
        @if($buttonVisible)
        <div class="col-lg-3 m-3 m-sm-0">
            <button class="btn btn-block btn-primary compose-mail">Buat Schedule</button>
        </div>
        @endif
    </div>
    </div>
</div>
</div>
</div>

</form>


@push('scripts')
    <script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/plugins/select2/select2.full.min.js') }}></script>
    <script src={{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}></script>
    <script>
        document.addEventListener('livewire:load', function () {
            });
            function checkedBox(checkbox) {
                var checkboxes = document.getElementsByName('PIC_auditor');
                checkboxes.forEach(function(currentCheckbox) {
                    if (currentCheckbox !== checkbox) {
                        currentCheckbox.checked = false;
                    }
                });
            }

            // Initialize Select2 for the first time
            $('.select2_demo_schedule').select2({
                placeholder: "Select a Team",
                allowClear: true
            }).on('change', function (e) {
                @this.set('selectedTeam', e.target.value);
            });

            $('#data_schedule .input-group.date').datepicker({
                format: 'dd/mm/yyyy', // Format tampilan
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });
        </script>
    @endpush