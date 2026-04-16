// src/Views/roles/index.blade.php
@extends('multirole::layout')

@section('content')
<div class="container">
    <h1>Role Management</h1>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Create Role</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th><th>Name</th><th>Guard</th><th>Priority</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles as $role)
            <tr>
                <td>{{ $role->id }}</td>
                <td>{{ $role->name }}</td>
                <td>{{ $role->guard_name }}</td>
                <td>{{ $role->priority }}</td>
                <td>
                    <a href="{{ route('roles.edit', $role) }}">Edit</a>
                    <form action="{{ route('roles.destroy', $role) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $roles->links() }}
</div>
@endsection