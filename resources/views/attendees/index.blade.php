@extends('layouts.master_layout')
@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		@if (strlen($msg) > 0)
		<div class="alert alert-info">
			{{ $msg }}
		</div>
		@endif

		<div class="clearfix">
			<h3 class="panel-title pull-left">{{ $rows->total() }} Attendees</h3>
			<div class="pull-right">
				<a class="btn btn-success btn-xs" href="{{ URL::to('/attendees/print/'.$day) }}" target="_blank" title="Print" role="button"><span class="fa fa-print"></span> Print</a>
				<!-- <a class="btn btn-success btn-xs" href="{{ URL::to('/attendees/download/'.$day) }}" target="_blank" title="Print" role="button"><span class="fa fa-download"></span> Download</a> -->
			</div>
		</div>
	</div>
	<div class="panel-body">
		{!! Form::open(array('name' => 'search_form', 'url' => URL::to('attendees'), 'class'=>'form-inline', 'role' => 'form')) !!}
			<div class="form-group">

				<div class="input-group input-group-sm">
					<span class="input-group-addon">Select Day</span>

					<!-- {!! Form::select('qt', [
						'2022-06-06' => '1st Day',
					   	'2019-07-31' => '2nd Day',
					   	'2019-08-01' => '3rd Day'],
					   	$day, ['class' => 'form-control input-sm']) 
					!!} -->
					<input type="date" class="form-control" name="qt" value="{{$day}}">
				</div>

				<div class="input-group input-group-sm">					
					<span class="input-group-btn">
						<input class="btn btn-default btn-sm" type="submit" value="Search" name="search-btn" id="search-btn">
					</span>
				</div>


			</div><label class="pull-right badge badge-primary">{{\Carbon\Carbon::createfromformat('Y-m-d', $day)->format('F j, Y')}}</label>
		{!! Form::close() !!}


	</div>
	<div class="panel-footer pagination-links">
		{{ $rows->links() }}
	</div>
	<div class="row">
		
	</div>
	<div class="table-responsive">
		<table class="table table-bordered table-condensed table-striped table-hover">
			<thead>
				<tr>
					<th class="text-center">#</th>
					<th class="text-center">Code</th>
					<th class="text-center">Name</th>
					<th class="text-center">Gender</th>
					<th class="text-center">Designation</th>
					<th class="text-center">Company</th>
					<th class="text-center">Mobile</th>
					<th class="text-center">Email</th>
					<th class="text-center">Region</th>
					<th class="text-center">Class</th>					
					<th class="text-center">Date Entered</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$perPage = $rows->perPage();
					$currentPage = $rows->currentPage();
					if($currentPage > 1){
						$i = $currentPage * $perPage - $perPage;
					}else{
						$i = 0; 
					}
				?>
			    @foreach($rows as $row)
			    <?php $i++; ?>
			    <tr>
					<td class="text-center">{{ $i }}</td>
					<td>{{ $row->visitor->vis_code }}</td>
					<td>{{ $row->visitor->vis_fname }} {{ $row->visitor->vis_mname }} {{ $row->visitor->vis_lname }}</td>
					<td>{{ App\Gender::where('gender_id', $row->visitor->gender_id)->value('gender_name') }}</td>
					<td>{{ $row->visitor->vis_designation }}</td>
					<td>{{ $row->visitor->vis_company }}</td>
					<td>{{ $row->visitor->vis_gsm }}</td>
					<td>{{ $row->visitor->vis_email }}</td>
					<td>{{ App\Region::where('region_id', $row->visitor->region_id)->value('region_name') }}</td>
					<td>{{ App\Classification::where('class_id', $row->visitor->class_id)->value('class_name') }}</td>					
					<td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->format('F j, Y G:i:A')}} | <text class="label label-danger">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->diffForHumans()}}</text></td>
				</tr>
			    @endforeach
			</tbody>
		</table>
	</div>
	<div class="panel-footer pagination-links">
		{{ $rows->links() }}
	</div>
</div>

<script type="text/javascript">
var _tsOptions = {
	headers:{
		0: { sorter: true}
		}
	};
</script>
@endsection