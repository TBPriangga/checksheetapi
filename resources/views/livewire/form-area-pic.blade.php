    <div class="form-group row"><label class="col-sm-2 col-form-label">Area</label>
        <div wire:ignore class="col-sm-4">
            <select class="select2_demo_4 form-control" name="area_id" required @if($selectdisable) disabled @endif>
                <option></option>
                @foreach($areas as $area)
                <option value={{ $area->id }} @if ($laporan != null && $area->id == $laporan->area_id) selected @endif @if ($genba_area != null && $area->id == $genba_area) selected @endif>{{ $area->name }}</option>
                @endforeach
            </select>
            @if($selectdisable)
            <input type="hidden" name="area_id" value={{ $genba_area }}>
            @endif
        </div>
            <label class="col-sm-1 col-form-label">PIC</label>
                    <div class="col-sm-4"><input type="text" disabled=""@if($PIC)  placeholder="{{ $PIC->user->name }}" @else placeholder="Tidak ada data" @endif class="form-control"></div>
                    <input type="hidden" name="PIC_id" @if($PIC) value="{{ $PIC->user->id }}" @else value="" @endif> 

    </div>
    @push('scripts')
    <script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/plugins/select2/select2.full.min.js') }}></script>
    <script>
    document.addEventListener('livewire:load', function () {
            Livewire.hook('message.processed', function (message, component) {
                
                $('.select2_demo_5').select2({
                placeholder: "Select a state",
                allowClear: true
            })
            });

            // Initialize Select2 for the first time
            $('.select2_demo_4').select2({
                placeholder: "Select a state",
                allowClear: true
            }).on('change', function (e) {
                @this.set('selectedOption', e.target.value);
            });

            $('.select2_demo_5').select2({
                placeholder: "Select a state",
                allowClear: true
            })
        });
    </script>
    @endpush