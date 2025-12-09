@extends('layouts.app-master')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Schedule AJI event edit</h2>
	</div>
	<div class="col-lg-2">
	</div>
</div>

@include('layouts.partials.messages')

<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
	<div class="col-lg-12">
		<div class="ibox ">
			<div class="ibox-title">
				<h5>Edit event</small></h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="{{ route('NewProductPortalScheduleAjiController.update', $data->id) }}" enctype="multipart/form-data">
                	@csrf
                    <input type="hidden" name="id" value="{{$data->id}}">
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Project Title</label>
						<div class="col-sm-10"><input type="text" name="project_title" class="form-control" value="{{$data->project_title}}" required></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Milestone</label>
						<div class="col-sm-10"><input type="text" name="milestone" class="form-control" value="{{$data->milestone}}" required></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">event</label>
						<div class="col-sm-10"><input type="text" name="event" class="form-control" value="{{$data->event}}" required></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Description</label>
						<div class="col-sm-10"><textarea name="detail_description" class="form-control"required>{{$data->detail_description}}</textarea></div>
					</div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group row"><label class="col-sm-2 col-form-label">Pic</label>
						<div class="col-sm-10">
	                        <select id="model-dropdown" class="select2 form-control m-b" name="pic" required>
	                        	@foreach ($depts as $key => $dept)
									@if($dept->code == $data->pic)
										<option value="{{$dept->code}}" selected>{{$dept->code}}</option>
									@else
										<option value="{{$dept->code}}">{{$dept->code}}</option>
									@endif
								@endforeach
	                        </select>
						</div>
                    </div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Kordinasi </label>
						<div class="col-sm-10"><input type="text" name="koordinasi" class="form-control" value="{{$data->koordinasi}}" required></div>
					</div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Progress </label>
						<div class="col-sm-10"><input type="number" name="progress" class="form-control" min="0" max="100" value="{{ $data->progress = $data->progress ?? 0;}}" required></div>
					</div>
					<div class="form-group row"><label class="col-sm-2 col-form-label">Urgensi</label>
						<div class="col-sm-10">
	                        <select id="urgensi-dropdown" class="select2 form-control m-b" name="urgent" required>
	                        	@foreach ($urgensi as $key => $urgent)
									@if($urgent->type == $data->urgent)
										@php
											$text = "";
											if ($data->urgent == 1) {
												$text = "Normal";
											} elseif($data->urgent == 2) {
												$text = "Urgent";
											}else{
												$text = "Top Urgent";
											}
											
										@endphp
										<option value="{{$urgent->type}}" selected>{{$text}}</option>
									@else
										@php
											$text = "";
											if ($urgent->type == 1) {
												$text = "Normal";
											} elseif($urgent->type == 2) {
												$text = "Urgent";
											}else{
												$text = "Top Urgent";
											}
											
										@endphp
										<option value="{{$urgent->type}}">{{$text}}</option>
									@endif
								@endforeach
	                        </select>
							{{-- @foreach ($urgensi as $key => $urgent)
								@if($urgent->type == $data->urgent)
									{{dd($data->urgent)}}
								@else
									tidak
								@endif
							@endforeach --}}
						</div>
                    </div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">plan start </label>
						<div class="col-sm-10"><input type="date" name="plan_start" class="form-control" value="{{$data->plan_start ? date("Y-m-d", strtotime($data->plan_start)) : null}}" ></div>
					</div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">plan end </label>
						<div class="col-sm-10"><input type="date" name="plan_end" class="form-control" value="{{$data->plan_end ? date("Y-m-d", strtotime($data->plan_end)) : null}}" ></div>
					</div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">actual start  </label>
						<div class="col-sm-10"><input type="date" name="actual_start" class="form-control" value="{{$data->actual_start ? date("Y-m-d", strtotime($data->actual_start)) : null}}" ></div>
					</div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">actual end </label>
						<div class="col-sm-10"><input type="date" name="actual_end" class="form-control" value="{{$data->actual_end ? date("Y-m-d", strtotime($data->actual_end)) : null}}" ></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group row">
						<div class="col-sm-4 col-sm-offset-2">
							<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('NewProductPortalScheduleAjiController.index') }}'" value="Cancel" />
							<button class="btn btn-primary btn-sm" type="submit">Save changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {



        
    });
</script>
@endpush
