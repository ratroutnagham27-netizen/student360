@extends('layouts.app')
@section('title', 'Parent Dashboard')
@section('content')
    <div class="page-top">
        <div>
            <h1>Parent Dashboard <i class="bi bi-people-fill"></i></h1>
            <p class="subtitle">Track your child's progress at a glance</p>
        </div>
        <span class="role-label parent">Parent</span>
    </div>
    <div class="kid-card">
        <div class="kid-info">
            <div class="icon-box accent"><i class="bi bi-person-badge-fill"></i></div>
            <div class="details">
                <div class="label">Viewing profile of</div>
                <div class="name">Jana Shreif</div>
                <div class="meta">Grade 10 - Section A</div>
            </div>
        </div>
        <span class="live-tag">Active</span>
    </div>
    <div class="note note-yellow">
        <i class="bi bi-trophy-fill"></i>
        Jana earned a "Math Star" badge this week.
    </div>
    <div class="cards-row" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
        <div class="info-card">
            <div class="info-text">
                <div class="info-title">Academic Average</div>
                <div class="info-value" style="color: var(--teal);">85%</div>
                <small style="color: var(--green);"><i class="bi bi-arrow-up-short"></i> +4% this month</small>
            </div>
        </div>
        <div class="info-card">
            <div class="info-text">
                <div class="info-title">Attendance Rate</div>
                <div class="info-value" style="color: var(--green);">96%</div>
                <small style="color: var(--muted);">Excellent standing</small>
            </div>
        </div>
        <div class="info-card">
            <div class="info-text">
                <div class="info-title">Teacher Notes</div>
                <div class="info-value" style="color: #B8851E;">3</div>
                <small style="color: var(--muted);">New this week</small>
            </div>
        </div>
    </div>
    <div class="panel">
        <h2><i class="bi bi-eye-fill"></i> What You Can View</h2>
        <ul class="perm-list">
            <li><span><i class="bi bi-bar-chart-fill" style="color: var(--teal);"></i> Grades and Academic Progress</span><span class="soon-badge">Coming Soon</span></li>
            <li><span><i class="bi bi-calendar-check-fill" style="color: var(--green);"></i> Attendance Record</span><span class="soon-badge">Coming Soon</span></li>
            <li><span><i class="bi bi-star-fill" style="color: var(--yellow);"></i> Teacher Evaluations</span><span class="soon-badge">Coming Soon</span></li>
            <li><span><i class="bi bi-trophy-fill" style="color: var(--blue);"></i> Talents and Strengths</span><span class="soon-badge">Coming Soon</span></li>
        </ul>
        <div class="note note-info" style="margin-top: 16px; margin-bottom: 0;">
            <i class="bi bi-shield-lock-fill"></i>
            You can only view information for your own child. Confidential staff notes are never shown.
        </div>
    </div>
@endsection