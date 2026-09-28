document.addEventListener('DOMContentLoaded', () => {
    // Auto-dismiss only flash messages (temporary alerts).
    // Content notes (.note) are permanent and must NOT be removed.
    document.querySelectorAll('.flash-message, .alert-auto-dismiss').forEach(message => {
        setTimeout(() => {
            message.style.transition = 'opacity 0.5s';
            message.style.opacity = '0';
            setTimeout(() => message.remove(), 500);
        }, 5000);
    });
});