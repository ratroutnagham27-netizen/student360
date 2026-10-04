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
@endsection