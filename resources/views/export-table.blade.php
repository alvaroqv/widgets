@extends('app-excel')
  
@section('title')
Widgets Assignment!!!
@stop
  
@section('content')

<div class="row">
<div class="col-md-12">
<h4>Select Json File to Process</h4>
<div class="table-responsive">

<table id="mytable" class="table table-bordred table-striped">
<thead>
<th >File Name</th>
<th >Name</th>
<th >Address</th>
<th >Checked</th>
<th >Description</th>
<th >Interest</th>
<th >Date of Birth</th>
<th >Account</th>
<th >Card Type</th>
<th >Card Number</th>
<th >Cart Name</th>
<th >Cart Date</th>
</thead>
<tbody>

@if (count($jsonfiles) > 0)
@foreach ($jsonfiles as $file)
    <tr>
    <td>{{ $file->filename }}</td>
    <td>{{ $file->name }}</td>
    <td>{{ $file->address }}</td>
    <td>{{ $file->checked }}</td>
    <td>{{ $file->description }}</td>
    <td>{{ $file->interest }}</td>
    <td>{{ $file->date_of_birth }}</td>
    <td>{{ $file->email }}</td>
    <td>{{ $file->card_type }}</td>
    <td>{{ $file->card_number }}</td>
    <td>{{ $file->card_name }}</td>
    <td>{{ $file->card_date }}</td>
    </tr>
@endforeach
</table>
@endif
</p>

@stop

@section('script')
<script>

$(document).ready(function() {
	$('#mytable').DataTable( {
		dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		]
	} );
} );
</script>    

@stop