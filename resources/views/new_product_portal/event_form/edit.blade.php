@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | EDIT LINE')
 
 
@section('content')
{{-- {{dd($data)}} --}}
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Edit Form Event</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div>
            <form action="{{route('form_event.update', ['form_event' => $data->id])}}" method="post">
                {{csrf_field()}}
                {{method_field("PUT")}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>milestone</label> 
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <input type="text" placeholder="milestone" name="milestone" class="form-control @error('milestone') is-invalid @enderror" value="{{$data->milestone}}">
                            @error('milestone') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Event</label> 
                            <input type="text" placeholder="event" name="event" class="form-control @error('event') is-invalid @enderror" value="{{$data->event}}">
                            @error('event') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Form Type</label> 
                            <input type="text" placeholder="form_type" name="form_type" class="form-control @error('form_type') is-invalid @enderror" value="{{$data->form_type}}">
                            @error('form_type') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Task no</label> 
                            <input type="number" placeholder="task_no" name="task_no" class="form-control @error('task_no') is-invalid @enderror" value="{{$data->task_no}}">
                            @error('task_no') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Task</label> 
                            <input type="text" placeholder="task" name="task" class="form-control @error('task') is-invalid @enderror" value="{{$data->task}}">
                            @error('task') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
          </div>
        </div>
        <div class="ibox-footer text-right">
                <button class="btn btn-primary btn-sm " >Save</button>
        </form>
                <a class="btn btn-default btn-sm float-left" href="{{route('form_event.index')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
@endpush




















