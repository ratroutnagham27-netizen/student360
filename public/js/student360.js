document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.note').forEach(note => {
        if (!note.classList.contains('note-error')) {
            setTimeout(() => {
                note.style.transition = 'opacity 0.5s';
                note.style.opacity = '0';
                setTimeout(() => note.remove(), 500);
            }, 5000);
        }
    });
});