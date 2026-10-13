@extends('layouts.app')
@section('title', 'Teacher Dashboard')
@section('content')
    <div class="page-top">
        <div>
            <h1>Teacher Dashboard <i class="bi bi-person-workspace"></i></h1>
            <p class="subtitle">Welcome back. Here is your class overview</p>
        </div>
        <span class="role-label teacher">Teacher</span>
    </div>
    <div class="cards-row" style="grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));">

    <div class="info-card centered">
        <div class="icon-box secondary"><i class="bi bi-people-fill"></i></div>
        <div class="info-title">Total Students</div>
        <div class="info-value">{{ $studentCount }}</div>
    </div>

    <div class="info-card centered">
        <div class="icon-box primary"><i class="bi bi-journal-text"></i></div>
        <div class="info-title">My Updates</div>
        <div class="info-value">{{ $myUpdatesCount }}</div>
    </div>

    <div class="info-card centered">
        <div class="icon-box accent"><i class="bi bi-clock-history"></i></div>
        <div class="info-title">Updates This Week</div>
        <div class="info-value">{{ $myRecentUpdatesCount }}</div>
    </div>

</div>

<div class="panel">
    <h2><i class="bi bi-lightning-charge-fill"></i> Quick Actions</h2>
    <div class="btn-row">
        <a href="{{ route('teacher.updates.create') }}" class="btn btn-outline-blue">
            <i class="bi bi-pencil-square"></i> Add update
        </a>
        <a href="{{ route('student.profile') }}" class="btn btn-outline-blue">
            <i class="bi bi-person-badge-fill"></i> View student profile
        </a>
    </div>
</div>
@endsection