@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
    @php
        $role = auth()->user()->role->value;
        $canViewConfidentialNotes = in_array($role, ['admin', 'teacher'], true);
    @endphp

    <div class="page-top">
        <div>
            <h1>
                Student Profile
                <i class="bi bi-person-badge-fill"></i>
            </h1>

            <p class="subtitle">
                Complete view of the student's development
            </p>
        </div>

        <span class="role-label {{ $role }}">
            {{ ucfirst($role) }}
        </span>
    </div>

    <div class="panel"
         style="display: flex; gap: 24px; align-items: center; flex-wrap: wrap;">

        <div style="width: 120px;
                    height: 120px;
                    border-radius: 50%;
                    background: var(--teal-light);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 3rem;
                    color: var(--teal);
                    flex-shrink: 0;">
            <i class="bi bi-person-fill"></i>
        </div>

        <div style="flex: 1; min-width: 220px;">
           <h2 style="margin-bottom: 8px;">{{ $student->name ?? 'Student' }}</h2>
<p style="color: var(--muted); margin: 0 0 6px 0;">
    <i class="bi bi-mortarboard"></i> {{ $student->class_name ?? '—' }}
</p>
<p style="color: var(--muted); margin: 0 0 6px 0;">
    <i class="bi bi-calendar-event"></i> Age: {{ $student && $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->age : '—' }}
</p>
<p style="color: var(--muted); margin: 0;">
    <i class="bi bi-telephone"></i> Parent: {{ $student->parent->name ?? 'N/A' }}
</p>
        </div>

        <div>
            <span class="live-tag">Active Student</span>
        </div>
    </div>

    <div class="cards-row">

        <div class="panel">
            <h2>
                <i class="bi bi-book-fill"></i>
                Academic Performance
            </h2>

            <div style="display: flex; flex-direction: column; gap: 14px;">

                <div>
                    <div style="display: flex;
                                justify-content: space-between;
                                margin-bottom: 6px;">
                        <span>Mathematics</span>
                        <strong style="color: var(--teal);">85%</strong>
                    </div>

                    <div style="background: var(--line-color);
                                height: 8px;
                                border-radius: 4px;
                                overflow: hidden;">
                        <div style="background: var(--teal);
                                    height: 100%;
                                    width: 85%;">
                        </div>
                    </div>
                </div>

                <div>
                    <div style="display: flex;
                                justify-content: space-between;
                                margin-bottom: 6px;">
                        <span>Science</span>
                        <strong style="color: var(--teal);">90%</strong>
                    </div>

                    <div style="background: var(--line-color);
                                height: 8px;
                                border-radius: 4px;
                                overflow: hidden;">
                        <div style="background: var(--teal);
                                    height: 100%;
                                    width: 90%;">
                        </div>
                    </div>
                </div>

                <div>
                    <div style="display: flex;
                                justify-content: space-between;
                                margin-bottom: 6px;">
                        <span>English</span>
                        <strong style="color: var(--teal);">78%</strong>
                    </div>

                    <div style="background: var(--line-color);
                                height: 8px;
                                border-radius: 4px;
                                overflow: hidden;">
                        <div style="background: var(--teal);
                                    height: 100%;
                                    width: 78%;">
                        </div>
                    </div>
                </div>

                <div>
                    <div style="display: flex;
                                justify-content: space-between;
                                margin-bottom: 6px;">
                        <span>Arabic</span>
                        <strong style="color: var(--teal);">82%</strong>
                    </div>

                    <div style="background: var(--line-color);
                                height: 8px;
                                border-radius: 4px;
                                overflow: hidden;">
                        <div style="background: var(--teal);
                                    height: 100%;
                                    width: 82%;">
                        </div>
                    </div>
                </div>
            </div>

            <hr style="margin: 20px 0;
                       border: none;
                       border-top: 1px solid var(--line-color);">

            <div style="display: flex;
                        justify-content: space-between;
                        align-items: center;">
                <span style="color: var(--muted); font-weight: 600;">
                    Overall Average
                </span>

                <strong style="font-size: 1.6rem; color: var(--teal);">
                    84%
                </strong>
            </div>
        </div>

        <div class="panel">
            <h2>
                <i class="bi bi-people-fill"></i>
                Behavioral & Participation
            </h2>

            <div style="display: flex; flex-direction: column; gap: 18px;">

                <div>
                    <div style="display: flex;
                                justify-content: space-between;
                                margin-bottom: 4px;">
                        <span style="font-weight: 600;">Participation</span>
                        <span style="color: var(--yellow); font-size: 1.3rem;">
                            ★★★★☆
                        </span>
                    </div>

                    <small style="color: var(--muted);">
                        Active in class discussions
                    </small>
                </div>

                <div>
                    <div style="display: flex;
                                justify-content: space-between;
                                margin-bottom: 4px;">
                        <span style="font-weight: 600;">Cooperation</span>
                        <span style="color: var(--yellow); font-size: 1.3rem;">
                            ★★★★★
                        </span>
                    </div>

                    <small style="color: var(--muted);">
                        Great teamwork with classmates
                    </small>
                </div>

                <div>
                    <div style="display: flex;
                                justify-content: space-between;
                                margin-bottom: 4px;">
                        <span style="font-weight: 600;">Focus</span>
                        <span style="color: var(--yellow); font-size: 1.3rem;">
                            ★★★☆☆
                        </span>
                    </div>

                    <small style="color: var(--muted);">
                        Sometimes distracted in long sessions
                    </small>
                </div>

                <hr style="margin: 8px 0;
                           border: none;
                           border-top: 1px solid var(--line-color);">

                <div style="display: flex;
                            justify-content: space-between;
                            align-items: center;">
                    <span style="color: var(--muted); font-weight: 600;">
                        Attendance
                    </span>

                    <strong style="color: var(--green); font-size: 1.3rem;">
                        96%
                    </strong>
                </div>
            </div>
        </div>
    </div>


        {{-- ════════════════════════════════════════════════════ --}}
    {{-- Teacher Updates Log — S360-XX (Reem)                --}}
    {{-- ════════════════════════════════════════════════════ --}}
    @isset($teacherUpdates)
        <div class="panel">
            <h2>
                <i class="bi bi-clock-history"></i>
                Teacher Updates Log
            </h2>

            @if ($teacherUpdates->isEmpty())
                <p style="color: var(--muted); margin: 0;">
                    No updates recorded yet.
                </p>
            @else
                <div style="display: flex; flex-direction: column; gap: 14px;">
                    @foreach ($teacherUpdates as $update)
                        @php
                            $categoryClass = match ($update->category) {
                                'academic'   => 'note-info',
                                'behavioral' => 'note-yellow',
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

                            <p style="margin: 0 0 8px 0;">
                                {{ $update->note }}
                            </p>

                            <small style="color: var(--muted);">
                                <i class="bi bi-person-circle"></i>
                                {{ $update->teacher->name ?? 'Unknown teacher' }}
                            </small>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    @endisset
@endsection