@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="card">
  <div class="card-header">Students Page</div>
  <div class="card-body">
  
        <div class="card-body">
        <h5 class="card-title">Name : {{ $class->name }}</h5>
        <p class="card-text">Manage : {{ $class->manage }}</p>
        <p class="card-text">Create_at : {{ $class->create_at }}</p>
  </div>
      
    </hr>
  
  </div>
</div>