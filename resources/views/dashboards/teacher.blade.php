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
            <div class="info-title">My Students</div>
            <div class="info-value">32</div>
        </div>
        <div class="info-card centered">
            <div class="icon-box primary"><i class="bi bi-clipboard-check-fill"></i></div>
            <div class="info-title">Pending Grades</div>
            <div class="info-value">5</div>
        </div>
        <div class="info-card centered">
            <div class="icon-box accent"><i class="bi bi-star-fill"></i></div>
            <div class="info-title">New Evaluations</div>
            <div class="info-value">12</div>
        </div>
        <div class="info-card centered">
            <div class="icon-box secondary"><i class="bi bi-calendar-check-fill"></i></div>
            <div class="info-title">Today's Attendance</div>
            <div class="info-value">Done</div>
        </div>
    </div>
    <div class="panel">
        <h2><i class="bi bi-lightning-charge-fill"></i> Quick Actions</h2>
        <div class="btn-row">
            <button class="btn btn-outline-blue" disabled><i class="bi bi-pencil-square"></i> Add Grade</button>
            <button class="btn btn-outline-blue" disabled><i class="bi bi-star-fill"></i> Add Evaluation</button>
            <button class="btn btn-outline-blue" disabled><i class="bi bi-calendar-x-fill"></i> Mark Attendance</button>
            <button class="btn btn-outline-blue" disabled><i class="bi bi-journal-text"></i> Add Assignment</button>
        </div>
        <span class="soon-tag"><i class="bi bi-cone-striped"></i> Coming in Sprint 2</span>
    </div>
@endsection