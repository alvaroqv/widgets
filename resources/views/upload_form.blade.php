@extends('app')

@section('title')
Widgets Assignment Upload Form
@stop


@section('content')
    @if (count($errors) > 0)
        <ul>
            @foreach ($errors->all() as $error)
            <li><div class="alert alert-danger" role="alert">{{ $error }}</div></li>
            @endforeach
        </ul>
    @endif

<div class="jumbotron">
  <h1 class="display-4">Upload Form </h1>
    <form action="/upload" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        File name:
        <br />
        <input type="text" name="name" />
        <br /><br />
         Json file:
        <br />
        <input type="file" name="jsonfile" id="jsonfile">
        <br /><br />
        <input type="submit" value="Upload Files"  class="btn btn-primary"/>

    </form>
</div>
@stop
