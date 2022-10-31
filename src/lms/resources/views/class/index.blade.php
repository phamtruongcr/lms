@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div>
        <h4 class="mb-3 mb-md-0"> All Class</h4>
    </div>
<div class="d-flex align-items-center flex-wrap text-nowrap ">
    <a href="{{ route('class.create') }}" class="btn btn-info btn-icon-text mb-2 mb-md-0">Create a Class     
    </a>
  </div>
</div>
</div>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover mb-0">
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Class Manager</th>
                        <th>Class Created-at</th>
                        <th>Class Updated-at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                    <tr>
                        <td>{{ $group->name }}</td>
                        <td>{{ $group->manager_name  }}</td>
                        <td class="text-end">{{ $group->created_at->format('d-m-Y') }}</td>
                        <td class="text-end">{{ $group->updated_at->format('d-m-Y') }}</td>
                        <td>
                                <a href="{{ route('test.edit', ['id'=>$test->id]) }}" class="btn btn-sm btn-success">
                                <i class="fas fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" 
                                  onclick="javascript:test_delete('{{ $test->id }}')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                    </tr>
                    @endforelse
                </tbody>
                
            </table>
        </div>
    </div>
</div>
@endsection
