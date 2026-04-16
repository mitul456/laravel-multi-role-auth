// src/Views/dashboards/admin.blade.php
@extends('multirole::layout')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="stats">
        <div>Total Users: {{ $totalUsers ?? 0 }}</div>
        <div>Total Roles: {{ $totalRoles ?? 0 }}</div>
    </div>
</div>
@endsection