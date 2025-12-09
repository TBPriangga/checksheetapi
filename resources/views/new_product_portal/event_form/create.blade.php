@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | CREATE LINE')
 
 
@section('content')
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Task Form Event</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('form_event.store')}}" method="post">
                {{csrf_field()}}
                {{-- {{method_field("PUT")}} --}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>milestone</label> 
                            <input type="text" placeholder="milestone" name="milestone" class="form-control @error('milestone') is-invalid @enderror" value="{{old('milestone')}}">
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
                            <label>event</label> 
                            <input type="text" placeholder="event" name="event" class="form-control @error('event') is-invalid @enderror" value="{{old('event')}}">
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
                            <label>From Type</label> 
                            <input type="text" placeholder="form_type" name="form_type" class="form-control @error('form_type') is-invalid @enderror" value="{{old('form_type')}}">
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
                            <input type="number" placeholder="task_no" name="task_no" class="form-control @error('task_no') is-invalid @enderror" value="{{old('task_no')}}">
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
                            <input type="text" placeholder="task" name="task" class="form-control @error('task') is-invalid @enderror" value="{{old('task')}}">
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
                <a class="btn btn-default float-left" href="{{route('form_event.index')}}">Back</a>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // mini nav bar
        $("body").addClass("body-small mini-navbar");
    // huruf kecil table
      $(".ibox").css({fontSize:10, textTransform:'Uppercase'});
      $("select").css({fontSize:12});
      $("input").css({fontSize:12});
</script>
@endpush




















