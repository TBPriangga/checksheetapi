@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Update Position</h2>
        <div class="lead">
            Edit Position.
        </div>

        <div class="container mt-4">

            <form method="POST" action="{{ route('urgensi.update', $data->id) }}">
                @method('patch')
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">type</label>
                    <input value="{{ $data->type }}" 
                        type="number" 
                        class="form-control" 
                        name="type" 
                        placeholder="type" required>

                    @if ($errors->has('type'))
                        <span class="text-danger text-left">{{ $errors->first('type') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="notif day PIC" class="form-label">Notif day PIC</label>
                    <input value="{{ $data->day_notif_spv }}" 
                        type="number" 
                        class="form-control" 
                        name="day_notif_pic" 
                        placeholder="notif day PIC" required>

                    @if ($errors->has('day_notif_pic'))
                        <span class="text-danger text-left">{{ $errors->first('day_notif_pic') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="notif day SPV" class="form-label">Notif day SPV</label>
                    <input value="{{ $data->day_notif_spv }}" 
                        type="number" 
                        class="form-control" 
                        name="day_notif_spv" 
                        placeholder="notif day SPV" required>

                    @if ($errors->has('day_notif_spv'))
                        <span class="text-danger text-left">{{ $errors->first('day_notif_spv') }}</span>
                    @endif
                </div>    

                <div class="mb-3">
                    <label for="notif day Depthead" class="form-label">Notif day Depthead</label>
                    <input value="{{ $data->day_notif_depthead }}" 
                        type="number" 
                        class="form-control" 
                        name="day_notif_depthead" 
                        placeholder="notif day Depthead" required>

                    @if ($errors->has('day_notif_depthead'))
                        <span class="text-danger text-left">{{ $errors->first('day_notif_depthead') }}</span>
                    @endif
                </div>   

                <div class="mb-3">
                    <label for="notif day Director" class="form-label">Notif day Director</label>
                    <input value="{{ $data->day_notif_director }}" 
                        type="number" 
                        class="form-control" 
                        name="day_notif_director" 
                        placeholder="notif day director" required>

                    @if ($errors->has('day_notif_director'))
                        <span class="text-danger text-left">{{ $errors->first('day_notif_director') }}</span>
                    @endif
                </div>    

                <button type="submit" class="btn btn-primary">Save changes</button>
                <a href="{{ route('urgensi.index') }}" class="btn btn-default">Back</a>
            </form>
        </div>

    </div>
@endsection