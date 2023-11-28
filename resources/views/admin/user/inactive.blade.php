@extends('layouts.app')
@section('title', 'All Inactive User')
@section('content')

<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h4>All Inactive User</h4>
    </div>
    <div class="card-body p-0">
        <table class="table">
            <thead class="bg-light">
              <tr class="text-white">
                <th scope="col">SI</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Role</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($users as $key => $item)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->role }}</td>
                    <td>
                        <a href="{{ route('user.active',$item->id) }}" id="delete" class="btn btn-danger btn-sm">
                            <i data-feather="unlock" class="nav-icon icon-xs"></i>
                        </a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
        {{ $users->links() }}
    </div>
</div>

@endsection
