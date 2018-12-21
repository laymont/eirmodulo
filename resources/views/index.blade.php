@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <nav class="navbar navbar-light bg-faded">
      <a class="navbar-brand" href="#">{4:Navbar}</a>
      <ul class="nav navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Home</a>
        </li>
      </ul>
      <form class="form-inline navbar-form pull-right">
        <input class="form-control" type="text" placeholder="Search">
        <button class="btn btn-success-outline" type="submit">Search</button>
      </form>
    </nav>
  </div>
</div>
@endsection