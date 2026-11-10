document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.passwordToggle);
            if (!input) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            const icon = button.querySelector('i');
            if (icon) icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            button.setAttribute('aria-label', show ? 'Ẩn mật khẩu' : 'Hiện mật khẩu');
        });
    });

    const password = document.getElementById('password');
    const confirmation = document.getElementById('password_confirmation');
    const hint = document.getElementById('etPasswordHint');
    const bars = document.querySelectorAll('.et-auth-meter-bars i');
    const matchError = document.getElementById('etPasswordMatchError');

    function updateStrength() {
        if (!password || !hint) return;
        const value = password.value;
        let score = 0;
        if (value.length >= 8) score++;
        if (/[A-Z]/.test(value) && /[a-z]/.test(value)) score++;
        if (/\d/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;
        const labels = ['Sử dụng ít nhất 8 ký tự.', 'Mật khẩu yếu.', 'Mật khẩu trung bình.', 'Mật khẩu khá tốt.', 'Mật khẩu mạnh.'];
        const colors = ['#e3e7ef', '#ef4444', '#f59e0b', '#3b82f6', '#10b981'];
        hint.textContent = value.length ? labels[score] : labels[0];
        bars.forEach(function (bar, index) {
            bar.style.background = index < score ? colors[score] : colors[0];
        });
    }

    function validateMatch() {
        if (!password || !confirmation || !matchError) return true;
        const mismatch = confirmation.value.length > 0 && password.value !== confirmation.value;
        matchError.hidden = !mismatch;
        confirmation.setCustomValidity(mismatch ? 'Mật khẩu xác nhận chưa khớp.' : '');
        return !mismatch;
    }

    if (password) password.addEventListener('input', function () { updateStrength(); validateMatch(); });
    if (confirmation) confirmation.addEventListener('input', validateMatch);
    const form = confirmation ? confirmation.closest('form') : null;
    if (form) form.addEventListener('submit', function (event) {
        if (!validateMatch()) { event.preventDefault(); confirmation.focus(); }
    });
    updateStrength();
});
