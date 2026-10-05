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

    @if (! $student)
        <div class="note note-info">
            <i class="bi bi-info-circle-fill"></i>
            No student is linked to your account yet. Please contact the school administrator.
        </div>
    @else

        {{-- Child overview card --}}
        <div class="kid-card">
            <div class="kid-info">
                <div class="icon-box accent">
                    <i class="bi bi-person-badge-fill"></i>
                </div>
                <div class="details">
                    <div class="label">Viewing profile of</div>
                    <div class="name">{{ $student->name }}</div>
                    <div class="meta">
                        {{ $student->class_name }}
                        @if ($student->date_of_birth)
                            · Age: {{ $student->date_of_birth->age }}
                        @endif
                    </div>
                </div>
            </div>
            <span class="live-tag">Active</span>
        </div>

        {{-- Stat cards --}}
        <div class="cards-row" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
            <div class="info-card">
                <div class="info-text">
                    <div class="info-title">Academic Average</div>
                    <div class="info-value" style="color: var(--teal);">85%</div>
                    <small style="color: var(--muted);">Current term</small>
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
                    <div class="info-value" style="color: #B8851E;">{{ $visibleCount }}</div>
                    <small style="color: var(--muted);">Visible to you</small>
                </div>
            </div>
        </div>

        {{-- Teacher Updates — Sprint 4 (Reem) --}}
        <div class="panel">
            <h2>
                <i class="bi bi-chat-square-quote-fill"></i>
                Teacher Updates
            </h2>

            @if ($updates->isEmpty())
                <p style="color: var(--muted); margin: 0;">
                    No updates from teachers yet.
                </p>
            @else
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    @foreach ($updates as $update)
                        @php
                            $categoryClass = match (strtolower($update->category)) {
                                'academic'   => 'note-info',
                                'behavioral' => 'note-yellow',
                                'personal'   => 'note-ok',
                                default      => 'note-info',
                            };
                        @endphp

                        <div class="note {{ $categoryClass }}">
                            <div style="display: flex;
                                        justify-content: space-between;
                                        align-items: center;
                                        margin-bottom: 6px;
                                        gap: 12px;">
                                <strong style="text-transform: capitalize;">
                                    {{ $update->category }}
                                </strong>
                                <small style="color: var(--muted); white-space: nowrap;">
                                    {{ $update->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <p style="margin: 0 0 8px 0;">{{ $update->note }}</p>
                            <small style="color: var(--muted);">
                                <i class="bi bi-person-circle"></i>
                                {{ $update->teacher->name ?? 'Teacher' }}
                            </small>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Permissions panel (kept from جنى's original) --}}
        <div class="panel">
            <h2><i class="bi bi-eye-fill"></i> What You Can View</h2>
            <ul class="perm-list">
                <li><span><i class="bi bi-bar-chart-fill" style="color: var(--teal);"></i> Grades and Academic Progress</span></li>
                <li><span><i class="bi bi-calendar-check-fill" style="color: var(--green);"></i> Attendance Record</span></li>
                <li><span><i class="bi bi-star-fill" style="color: var(--yellow);"></i> Teacher Evaluations</span></li>
                <li><span><i class="bi bi-trophy-fill" style="color: var(--blue);"></i> Talents and Strengths</span></li>
            </ul>
            <div class="note note-info" style="margin-top: 16px; margin-bottom: 0;">
                <i class="bi bi-shield-lock-fill"></i>
                You can only view information for your own child. Confidential staff notes are never shown.
            </div>
        </div>

    @endif
@endsection