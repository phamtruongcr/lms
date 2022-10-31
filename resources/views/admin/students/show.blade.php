@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="col-12">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between aligin-items-center flex-wrap grid-margin">
                <div>
                    <h4 class="mb-3 mb-md-0"> Detail a Student</h4>
                </div>

                <p><b class="mb-3 mb-md-0"> Name :</b>{{$students->first_name}}</p>
                <p><b class="mb-3 mb-md-0"> Phone :</b>{{$students->phone}}</p>
                <p><b class="mb-3 mb-md-0"> Birthday :</b>{{$students->birthday}}</p>

                
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Course Name</th>
                            <th>progress</th>

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($details as $detail )
                        <tr>
                            <td>{{ $loop->iteration + ($details->currentPage() -1) * $details->perPage() }}</td>

                            <td class="text-end">{{$detail -> name}}</td>
                            <td class="text-end">
                                <div class="progress">
                                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="{{$detail->progress}}" aria-valuemin="0" aria-valuemax="100" style="width:40%">
                                        {{$detail->progress}} Complete (success)
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">No course.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{ $details->links() }}
    </div>
</div>
@stop