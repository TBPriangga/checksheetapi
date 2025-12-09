<form method="post" action="/genba/team/update" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="team_id" value={{ $team_id}}>
    @foreach($Userarray as $user)
    <input type="hidden" name="userID[]" value={{ $user->id }}>
    @endforeach

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Form</h5>
                </div>
                <div class="ibox-content">
                        
<div class="form-group row">
    <label class="col-sm-2 col-form-label">Nama Team</label>
    <div class="col-sm-10" id="data_schedule">
        <input type="text" class="form-control @error('name') has-error  @enderror" name="name" value="{{ $team->name }}" required>
    </div>
</div>
<div class="form-group row">
    
        <label class="col-sm-2 col-form-label">Nama Karyawan</label>
        <div class="col-sm-4">
            <select class="select2_demo_schedule form-control" id="userOption">
                <option></option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"> {{ $user->name }}</option>           
                @endforeach
            </select>
        </div>
        <div class="col-sm-2 m-sm-0 mt-3">
            <a class="btn btn-block btn-primary text-white" id="addUser">Add</a>
        </div>
    </div>

</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
    <div class="ibox ">
        <div class="ibox-title">
            <h5>Team Memeber</h5>
        </div>
    <div class="ibox-content">

<table class="table table-striped">
    <thead>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>NPK</th>
        <th>Departement</th>
        <th>Position</th>
        <th class="text-center">Action</th>
    </tr>
    </thead>
    <tbody>
        @foreach($Userarray as $user)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->npk }}</td>
            <td>{{ $user->detail->name }}</td>
            <td>{{ $user->position->position }}</td>
            <td class="text-center"><a class="btn btn-danger text-white" wire:click="hapusUser('{{ $user->id }}')">Hapus</a> </td>
        </tr>
        @endforeach
    
    </tbody>
</table>

<div class="hr-line-dashed"></div>
<div class="row" style="margin-left:0">
                   
    <div class="col-lg-8">

    </div>
    <div class="col-lg-2 m-3 m-sm-0">
        <a href="/genba/team/delete/{{ $team_id }}" class="btn btn-block btn-danger compose-mail text-white" type="submit">Delete Team</a>
    </div>
    @if($buttonVisible)
    <div class="col-lg-2 m-3 m-sm-0">
        <button class="btn btn-block btn-primary compose-mail" type="submit">Save</button>
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
        Livewire.hook('message.processed', function (message, component) {
            $('.select2_demo_schedule').select2({
                placeholder: "Pilih Karyawan",
                allowClear: true
            })

        })
        $(document).ready(function() {
            // var usersData = JSON.parse('{!! $this->users !!}');
            $('.select2_demo_schedule').select2({
                placeholder: "Pilih Karyawan",
                allowClear: true,

            })

        const addUser = $('#addUser')
        const userOption = $('#userOption')
        addUser.click(function() {
        // Di sini, Anda dapat memancarkan event Livewire ketika tombol addUser diklik
        livewire.emit('UserSelectEdit', userOption.val());
    });

    })

        });
    </script>
@endpush