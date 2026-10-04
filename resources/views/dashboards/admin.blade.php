@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')
    <div class="page-top">
        <div>
            <h1>Admin Dashboard <i class="bi bi-shield-fill-check"></i></h1>
            <p class="subtitle">Overview of your school's Student360 data</p>
        </div>
        <span class="role-label admin">Administrator</span>
    </div>
    <div class="cards-row">
        <div class="info-card">
            <div class="icon-box primary"><i class="bi bi-people-fill"></i></div>
            <div class="info-text">
                <div class="info-title">Total Students</div>
                <div class="info-value">128</div>
            </div>
        </div>
        <div class="info-card">
            <div class="icon-box secondary"><i class="bi bi-person-workspace"></i></div>
            <div class="info-text">
                <div class="info-title">Teachers</div>
                <div class="info-value">14</div>
            </div>
        </div>
        <div class="info-card">
            <div class="icon-box accent"><i class="bi bi-house-door-fill"></i></div>
            <div class="info-text">
                <div class="info-title">Classes</div>
                <div class="info-value">6</div>
            </div>
        </div>
    </div> 
@endsection