@extends('app')
  
@section('title')
Widgets Assignment!!!
@stop
  
@section('content')

<div class="row">
<div class="col-md-12">
<h4>List with Files Processing </h4>
<div class="table-responsive">

<table id="mytable" class="table table-bordred table-striped">
<thead>
<th class="col-sm-4">Project Name</th>
<th class="col-sm-4">File Name</th>
<th class="col-sm-4">Total Processed</th>
<th class="col-sm-2">ReStart</th>
<th class="col-sm-2">Stop</th>
</thead>
<tbody>

@if (count($jsonfiles) > 0)
@foreach ($jsonfiles as $file)
    <tr>
    <td class="col-sm-4">{{ $file->name }}</td>
    <td class="col-sm-4">{{ $file->filename }}</td>
    <td class="col-sm-4">{{ $file->lastline }}</td>
    <td class="col-sm-2"><p data-placement="top" data-toggle="tooltip" title="Process"><a href="#" class="btn btn-primary btn-xs" data-title="Reload"   ><span class="glyphicon glyphicon-refresh"></span></a></p></td>
    <td class="col-sm-2"><p data-placement="top" data-toggle="tooltip" title="Stop"><a href="#" class="btn btn-danger btn-xs" data-title="Stop"   ><span class="glyphicon glyphicon-stop"></span></a></p></td>
    </tr>
@endforeach
</table>
@endif
</p>

@stop

@section('script')
<script>


</script>    

@stop