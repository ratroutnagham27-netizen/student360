@extends('layouts.app')

@section('title', 'Parent Consent')

@section('content')
    <div class="page-top">
        <div>
            <h1>Privacy Notice <i class="bi bi-shield-lock-fill"></i></h1>
            <p class="subtitle">Please review before accessing your child's information</p>
        </div>
    </div>

    <div class="panel">
        <h2>
            <i class="bi bi-file-earmark-text-fill"></i>
            What You Will See
        </h2>

        <p style="color: var(--text); line-height: 1.7;">
            As a parent or guardian on Student360, you can view selected information
            about <strong>your own child</strong> only. This includes:
        </p>

        <ul style="color: var(--text); line-height: 1.9; margin: 12px 0 20px 0;">
            <li>Academic progress and grades</li>
            <li>Teacher updates that the teacher has marked as visible to parents</li>
            <li>Behavior notes and achievements shared by the school</li>
        </ul>

        <p style="color: var(--text); line-height: 1.7;">
            Confidential staff notes are <strong>never shown</strong> to parents.
            Your access is limited to your own child's record.
        </p>

        <div class="note note-info" style="margin-top: 20px;">
            <i class="bi bi-info-circle-fill"></i>
            By clicking "I Agree", you confirm that you understand and accept these terms.
        </div>

        <form method="POST" action="{{ route('parent.consent.store') }}" style="margin-top: 24px;">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle-fill"></i>
                I Agree
            </button>
        </form>
    </div>
@endsection