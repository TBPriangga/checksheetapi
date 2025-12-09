@extends('layouts.app-master')

@section('content')
    <div class="ibox-content">
        <h2>Add Urgensi</h2>

        <div class="container mt-4">

            <form method="POST" action="{{ route('urgensi.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label">Type</label>
                    <input value="{{ old('type') }}" 
                        type="number" 
                        class="form-control" 
                        name="type" 
                        placeholder="type" required>

                    @if ($errors->has('type'))
                        <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="Notif day PIC" class="form-label">Notif day PIC</label>
                    <input value="{{ old('day_notif_pic') }}" 
                        type="number" 
                        class="form-control" 
                        name="day_notif_pic" 
                        placeholder="Notif day PIC" required>

                    @if ($errors->has('day_notif_pic'))
                        <span class="text-danger text-left">{{ $errors->first('day_notif_pic') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="Notif day SPV" class="form-label">Notif day SPV</label>
                    <input value="{{ old('day_notif_spv') }}" 
                        type="number" 
                        class="form-control" 
                        name="day_notif_spv" 
                        placeholder="Notif day SPV" required>

                    @if ($errors->has('day_notif_spv'))
                        <span class="text-danger text-left">{{ $errors->first('day_notif_spv') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="Notif day Depthead" class="form-label">Notif day Depthead</label>
                    <input value="{{ old('day_notif_depthead') }}" 
                        type="number" 
                        class="form-control" 
                        name="day_notif_depthead" 
                        placeholder="Notif day Depthead" required>

                    @if ($errors->has('day_notif_depthead'))
                        <span class="text-danger text-left">{{ $errors->first('day_notif_depthead') }}</span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('urgensi.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection