@extends('app')
  
@section('title')
Widgets Assignment!!!
@stop
  
@section('content')

<div class="row">
<div class="col-md-12">
<h4>Select File to Export into Excel File</h4>
<div class="table-responsive">

<table id="mytable" class="table table-bordred table-striped">
<thead>
<th class="col-sm-4">Project Name</th>
<th class="col-sm-4">File Name</th>
<th class="col-sm-2">Export Excel</th>
</thead>
<tbody>

@if (count($jsonfiles) > 0)
@foreach ($jsonfiles as $file)
    <tr>
    <td class="col-sm-4">{{ $file->name }}</td>
    <td class="col-sm-4">{{ $file->filename }}</td>
    <td class="col-sm-2"><p data-placement="top" data-toggle="tooltip" title="Excel File"><a href="/json/export/{{$file->filename}}" class="btn btn-primary btn-xs" data-title="Edit"   ><span class="glyphicon glyphicon-save"></span></a></p></td>
    </tr>
@endforeach
</table>
@endif
</p>

@stop

@section('script')
 

@stop