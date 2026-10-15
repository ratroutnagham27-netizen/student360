@extends('layouts.app')

@section('title', 'Add Teacher Update')

@section('content')

    <div class="page-top">
        <div>
            <h1>Add Teacher Update <i class="bi bi-pencil-square"></i></h1>
            <p class="subtitle">Record a note about a student's progress</p>
        </div>
        <span class="role-label teacher">Teacher</span>
    </div>

    <div class="note note-info" style="margin-bottom: 20px;">
        <i class="bi bi-info-circle-fill"></i>
        Updates marked visible will appear on the parent's dashboard. Confidential notes stay private to staff.
    </div>

    <div class="panel">

        @if($errors->any())
            <div class="note note-error" style="margin-bottom: 20px;">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('status'))
            <div class="note note-ok" style="margin-bottom: 20px;">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('teacher-updates.store') }}" id="teacherUpdateForm">
            @csrf

            {{-- ============ STUDENT PICKER ============ --}}
            <div class="field">
                <label for="student_id">Student <span style="color: var(--red);">*</span></label>
                <div class="input-box">
                    <span class="icon"><i class="bi bi-person-badge-fill"></i></span>
                    <select id="student_id" name="student_id" required>
                        <option value="" disabled {{ old('student_id') ? '' : 'selected' }}>
                            -- Choose a student --
                        </option>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} — {{ $student->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- ============ CATEGORY ============ --}}
            <div class="field">
                <label for="category">Update Type <span style="color: var(--red);">*</span></label>
                <div class="input-box">
                    <span class="icon"><i class="bi bi-tag-fill"></i></span>
                    <select id="category" name="category" required>
                        <option value="" disabled {{ old('category') ? '' : 'selected' }}>-- Choose a category --</option>
                        <option value="academic"   {{ old('category') === 'academic'   ? 'selected' : '' }}>Academic</option>
                        <option value="behavioral" {{ old('category') === 'behavioral' ? 'selected' : '' }}>Behavioral</option>
                        <option value="personal"   {{ old('category') === 'personal'   ? 'selected' : '' }}>Personal</option>
                    </select>
                </div>
            </div>

            {{-- ============ NOTE ============ --}}
            <div class="field">
                <label for="note">Note <span style="color: var(--red);">*</span></label>
                <textarea
                    id="note"
                    name="note"
                    rows="6"
                    minlength="10"
                    maxlength="2000"
                    placeholder="Write your observation here... (10–2000 characters)"
                    required
                    style="width: 100%; padding: 12px; border: 1px solid var(--line-color); border-radius: 10px; font-family: inherit; font-size: 0.95rem; resize: vertical;"
                >{{ old('note') }}</textarea>
                <small style="color: var(--muted); display: block; margin-top: 6px;">
                    <span id="charCount">0</span> / 2000 characters
                </small>
            </div>

            {{-- ============ VISIBLE TO PARENT ============ --}}
            <div class="field" style="margin-top: 20px;">
                {{-- Hidden fallback: if checkbox unchecked, this sends 0 --}}
                <input type="hidden" name="visible_to_parent" value="0">

                <label style="display: flex; align-items: flex-start; gap: 10px; cursor: pointer; font-weight: 500;">
                    <input
                        type="checkbox"
                        name="visible_to_parent"
                        id="visible_to_parent"
                        value="1"
                        {{ old('visible_to_parent') == '1' ? 'checked' : '' }}
                        style="margin-top: 4px; width: 18px; height: 18px; cursor: pointer;"
                    >
                    <span>
                        <strong>Visible to parent</strong>
                        <small style="display: block; color: var(--muted); font-weight: 400; margin-top: 2px;">
                            When checked, this update will appear on the parent's dashboard. Leave unchecked to keep it private to staff.
                        </small>
                    </span>
                </label>
            </div>

            {{-- ============ BUTTONS ============ --}}
            <div class="btn-row" style="margin-top: 24px;">
                <button type="submit" class="btn btn-main">
                    <i class="bi bi-check-circle-fill"></i> Save Update
                </button>
                <a href="{{ route('teacher.dashboard') }}" class="btn btn-outline-main">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>

        </form>
    </div>

@endsection

@push('styles')
<style>
    .input-box select {
        flex: 1;
        border: none;
        outline: none;
        padding: 12px 12px 12px 0;
        font-size: 1rem;
        background: transparent;
        font-family: inherit;
        color: var(--text);
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236B7A8F' stroke-width='2'%3e%3cpolyline points='6 9 12 15 18 9'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 16px;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const note = document.getElementById('note');
        const counter = document.getElementById('charCount');

        if (note && counter) {
            counter.textContent = note.value.length;
            note.addEventListener('input', function () {
                counter.textContent = note.value.length;
            });
        }
    });
</script>
@endpush 