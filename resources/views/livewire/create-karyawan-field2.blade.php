
<form method="post" action="{{ route('updateKaryawan', ['id' => $karyawan->id]) }}">
    @csrf
    <div class="row">
    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Account Information</h5>
            </div>
            <div class="ibox-content">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Username</label>

                        <div wire:ignore class="col-sm-4  @error('username') has-error  @enderror"><input type="text" name="username" class="form-control" required value={{ $karyawan->username}}>
                            @error('username')
                            <code>
                                {{ $message }}
                            </code>
                            @enderror
                        </div>
                        
                        <label class="col-sm-2 col-form-label">Role</label>

                        <div wire:ignore class="col-sm-4">

                            <select id="selectedOption1" multiple="multiple" class="form-control required" name="role[]" required>
                                <option> </option>
                                @foreach($roles as $role)
                                <option value="{{ $role->id }}" @foreach($karyawan->roles as $roleID) @if ($roleID->id == $role->id) selected @endif @endforeach>{{ $role->name }}</option>
                                
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Email</label>
                        <div wire:ignore class="col-sm-4">
                            <input id="email" name="email" type="email" class="form-control email  @error('email') has-error  @enderror" required value={{ $karyawan->email}}>
                            @error('email')
                            <code>
                                {{ $message }}
                            </code>
                            @enderror
                        </div>

                        <label class="col-sm-2 col-form-label">Create New Password</label>
                        <div wire:ignore class="col-sm-4">
                            <input id="password" name="password" type="password" class="form-control" >
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
                    <h5>Profiles</h5>
                </div>
                <div class="ibox-content">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Name</label>
                        <div wire:ignore class="col-sm-4"><input type="text" name="name" class="form-control" required value="{{ $karyawan->name }}" ></div>

                        <label class="col-sm-2 col-form-label">NPK</label>

                        <div wire:ignore class="col-sm-4  @error('npk') has-error  @enderror"><input type="text" name="npk" class="form-control" required value={{ $karyawan->npk}}>
                            @error('npk')
                            <code>
                                {{ $message }}
                            </code>
                            @enderror
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Departement</label>
                        <div wire:ignore class="col-sm-4">
                            <select class="form-control required" id="departementOption" name="dept_id" required>
                                <option> </option>
                                @foreach($departments as $department)
                                <option value="{{ $department->id }}" @if ($karyawan->department->id == $department->id) selected @endif>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="col-sm-2 col-form-label">Detail Departement</label>
                        <div class="col-sm-4">
                            <select class="form-control required select_detai" id="selectedOption9" name="detail_dept_id" required>
                                <option> </option>
                                @foreach($detail_departements as $detail_departement)
                                <option value="{{ $detail_departement->id }}"  @if ($karyawan->detail->id == $detail_departement->id) selected @endif>{{ $detail_departement->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="hr-line-dashed"></div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Position</label>
                        <div wire:ignore class="col-sm-4">
                            <select wire:key="selectedOption2" class="form-control required" name="position_id" required>
                                <option> </option>
                                @foreach($positions as $position)
                                <option value="{{ $position->id }}" @if ($karyawan->position->id == $position->id) selected @endif>{{ $position->position }}</option>
                                @endforeach
                            </select>
                        </div>
{{-- @if ($areadisabled)
                        <label class="col-sm-2 col-form-label">Area</label>
                        <div class="col-sm-4">
                            <select class="form-control" name="area" required>
                                <option> </option>
                                @foreach($areas as $area)
                                <option value="{{ $area->id }}" @if ($karyawan->area->isempty()) @else @if ($karyawan->area[0]->area->id == $area->id) selected @endif @endif>{{ $area->name }}</option>
                                @endforeach
                                </select>
                        </div>
@endif --}}
                    </div>

                    <div class="hr-line-dashed"></div>
                    <div class="form-group row ">
                        <div class="col-sm-4">
                            <a href="{{ route('detailKaryawan', ['id' => $karyawan->id]) }}" class="btn btn-white btn-sm">Cancel</a>
                            <button class="btn btn-primary btn-sm" type="submit">Save Changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@push('scripts')

<script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
<script src={{ asset('js/plugins/select2/select2.full.min.js') }}></script>
<!-- Steps -->
<script src={{ asset("js/plugins/steps/jquery.steps.min.js") }}></script>

<!-- Jquery Validate -->
<script src={{ asset("js/plugins/validate/jquery.validate.min.js") }}></script>

<script>
console.log('231');
document.addEventListener('livewire:load', () => { 
    $(document).ready(function() {               
        
        
        $("#selectedOption1").select2();
        const departementOption = $('#departementOption') 
        if(departementOption.val() != '') {
            livewire.emit('detail_departement_change', departementOption.val());
        }
        
        // if (selectedOption1.val() == 4) {
        //     livewire.emit('areaVisible', true)
        //     selectedOption1
        // } else {
        //     livewire.emit('areaVisible', false)
        // }
        //         selectedOption1.on('change', function() {
        //             if (selectedOption1.val() == 4) {
        //                livewire.emit('areaVisible', true)
        //             } else {
        //                livewire.emit('areaVisible', false)
        //             }                    
        //         });
                departementOption.on('change', function() {
                    livewire.emit('detail_departement_change', departementOption.val());
                    
                })

});
});             

    </script>
@endpush