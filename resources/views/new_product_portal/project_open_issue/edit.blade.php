@extends('layouts.app-master')

@section('content')
{{-- {{dd($data)}} --}}
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Pica event edit</h2>
	</div>
	<div class="col-lg-2">
	</div>
</div>

@include('layouts.partials.messages')

<div class="row wrapper-content" style="padding-bottom: 0px; margin-bottom: -20px;">	
	<div class="col-lg-12">
		<div class="ibox ">
			<div class="ibox-title">
				<h5>Edit Project Open Issue</small></h5>
				<div class="ibox-tools">
					<a class="collapse-link">
						<i class="fa fa-chevron-up"></i>
					</a>
				</div>
			</div>
			<div class="ibox-content">
				<form method="POST" action="{{ route('project_open_issue.update', $data->id) }}" enctype="multipart/form-data">
                	@csrf
					@method('PUT')
                    <input type="hidden" name="id" value="{{$data->id}}">
                    <input type="hidden" name="last_edit_by" value="{{auth()->user()->name;}}">
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Project Title</label>
						<div class="col-sm-10"><input type="text" name="project_title" class="form-control" value="{{$data->project_title}}" required disabled></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Product</label>
						<div class="col-sm-10"><input type="text" name="product" class="form-control" value="{{$data->product}}" required disabled></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Pic</label>
						<div class="col-sm-10"><input type="text" name="pic" class="form-control" value="{{$data->pic}}" required></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Root cause</label>
						<div class="col-sm-10"><textarea name="root_cause" class="form-control" >{{$data->root_cause}}</textarea></div>
					</div>
					<div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Counter measure</label>
						<div class="col-sm-10"><textarea name="countermeasure" class="form-control" >{{$data->countermeasure}}</textarea></div>
					</div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Remark</label>
						<div class="col-sm-10"><textarea name="remark" class="form-control">{{$data->remark}}</textarea></div>
					</div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group  row"><label class="col-sm-2 col-form-label">Progress </label>
						<div class="col-sm-10">
							<select class="select2 form-control m-b" name="progress" required >
								<option value="0" {{ $data->progress == "0" ? 'selected' : '' }}>open</option>
								<option value="1" {{ $data->progress == "1" ? 'selected' : '' }}>close</option>
								<option value="2" {{ $data->progress == "2" ? 'selected' : '' }}>cancel</option>
								<option value="3" {{ $data->progress == "3" ? 'selected' : '' }}>postpone</option>
							</select>
						</div>
					</div>
                    <div class="hr-line-dashed"></div>
					<div class="form-group row">
						<div class="col-sm-4 col-sm-offset-2">
							<input class="btn btn-white btn-sm" type="button" onclick="location.href='{{ route('project_open_issue.index') }}'" value="Cancel" />
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
		
		$('#progress').on('input keydown', function(event) {
		var currentValue = parseInt($(this).val());
		var maxValue = parseInt($(this).attr('max'));
		
		if (currentValue > maxValue) {
			if (event.key === 'ArrowUp' || event.key === 'ArrowDown' || event.key === 'e') {
			event.preventDefault();
			} else {
			$(this).val(maxValue);
			}
		}
		});


        
    });
</script>
@endpush
