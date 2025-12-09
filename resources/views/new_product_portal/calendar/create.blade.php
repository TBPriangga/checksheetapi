@extends('layouts.app-master')
 
@section('title', 'AJI PORTAL | CREATE LINE')
 
 
@section('content')
    <div class="ibox " >
        <div class="ibox-title">
            <h4>Add Calendar Event</h4>
        </div>
        <div class="ibox-content" >
            @if(session()->has('fail'))
                <div class="alert alert-danger">{{session('fail')}}</div>
            @endif
          <div >
            <form action="{{route('calendar.store')}}" method="post">
                {{csrf_field()}}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label> 
                            <input type="text" placeholder="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">
                            @error('name') 
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
                            <label>Description</label> 
                            <input type="text" placeholder="description" name="description" class="form-control @error('description') is-invalid @enderror" value="{{old('description')}}">
                            @error('description') 
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
                            <label>Date</label> 
                            <input type="date" placeholder="date" name="date" class="form-control @error('date') is-invalid @enderror" value="{{old('date')}}">
                            @error('date') 
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
                            <label>Type</label> 
                            <select name="type" class="form-control" id="type">
                                <option value="event">event</option>
                            </select>
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
                            <label>Label Color</label> 
                            <select name="color" class="form-control" id="color">
                                <option value="black" >Black </option>
                                <option value="green" >Green </option>
                                <option value="blue" >Blue </option>
                                <option value="red" >Red </option>
                                <option value="brown" >Brown </option>
                            </select>
                            @error('event') 
                                <div class="text-danger">
                                    {{$message}}
                                </div>
                            @enderror
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




















