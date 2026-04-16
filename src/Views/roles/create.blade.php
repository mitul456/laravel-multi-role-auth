// src/Views/roles/create.blade.php
@extends('multirole::layout')

@section('content')
<div class="container">
    <h1>Create Role</h1>
    <form method="POST" action="{{ route('roles.store') }}">
        @csrf
        <div>
            <label>Role Name:</label>
            <input type="text" name="name" required>
        </div>
        <div>
            <label>Guard Name:</label>
            <select name="guard_name">
                <option value="web">Web</option>
                <option value="api">API</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div>
            <label>Priority:</label>
            <input type="number" name="priority" value="0">
        </div>
        <div>
            <label>Description:</label>
            <textarea name="description"></textarea>
        </div>
        <div>
            <label>Permissions:</label>
            @foreach($permissions as $permission)
                <div>
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}">
                    {{ $permission->name }}
                </div>
            @endforeach
        </div>
        <button type="submit">Create Role</button>
    </form>
</div>
@endsection