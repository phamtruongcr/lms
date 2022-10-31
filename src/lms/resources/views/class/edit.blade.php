@extends('layouts.app')
@section('title', 'Categories management')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
<h1 class="h2">Categories management</h1>
<div class="btn-toolbar mb-2 mb-md-0">
  <div class="btn-group me-2">
    <a class="btn btn-sm btn-primary" href="{{ route('category.create') }}">Create a Category</a>
  </div>
</div>
</div>
@if ($category)
<h2>{{ $category->name }}</h2>
<div class="table-responsive">
  {{ $category->description }}
</div>
@endif
@stop