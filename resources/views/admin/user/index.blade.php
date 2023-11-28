@extends('layouts.app')
@section('title', 'All User')
@section('content')

<div class="card my-3">
    <div class="card-header d-flex justify-content-between">
        <h4>All Users</h4>
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
                @foreach ($users as $key => $user)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->role }}</td>
                    <td>
                        <a href="{{ route('user.inactive',$user->id) }}" id="delete" class="btn btn-danger btn-sm">
                            <i data-feather="lock" class="nav-icon icon-xs"></i>
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
