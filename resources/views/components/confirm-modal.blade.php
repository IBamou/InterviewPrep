<div id="confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 p-5 transform transition-all scale-95 opacity-0" id="confirm-dialog">
        <div class="flex items-center gap-3 mb-4">
            <div id="confirm-icon" class="w-10 h-10 rounded-full bg-error/10 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-error text-[20px]">warning</span>
            </div>
            <h3 id="confirm-title" class="text-[15px] font-semibold text-on-surface">Confirm Action</h3>
        </div>
        <p id="confirm-message" class="text-[13px] text-on-surface-variant/70 mb-5"></p>
        <div class="flex gap-2 justify-end">
            <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 border border-outline-variant text-on-surface-variant rounded-lg text-[13px] font-medium hover:bg-surface-container transition-all">Cancel</button>
            <button type="button" id="confirm-action" onclick="if (window._confirmCallback) { window._confirmCallback(); closeConfirmModal(); }" class="px-4 py-2 bg-error text-white rounded-lg text-[13px] font-medium hover:bg-error/90 transition-all">Confirm</button>
        </div>
    </div>
</div>

<script>
(function () {
    window.showConfirmModal = function (title, message, callback, variant) {
        variant = variant || 'danger';
        var modal = document.getElementById('confirm-modal'),
            dialog = document.getElementById('confirm-dialog'),
            titleEl = document.getElementById('confirm-title'),
            msgEl = document.getElementById('confirm-message'),
            actionBtn = document.getElementById('confirm-action'),
            iconEl = document.getElementById('confirm-icon');
        titleEl.textContent = title;
        msgEl.textContent = message;
        window._confirmCallback = callback;
        if (variant === 'success') {
            actionBtn.className = 'px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all';
            iconEl.className = 'w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center shrink-0';
            iconEl.innerHTML = '<span class="material-symbols-outlined text-primary text-[20px]">check_circle</span>';
        } else {
            actionBtn.className = 'px-4 py-2 bg-error text-white rounded-lg text-[13px] font-medium hover:bg-error/90 transition-all';
            iconEl.className = 'w-10 h-10 rounded-full bg-error/10 flex items-center justify-center shrink-0';
            iconEl.innerHTML = '<span class="material-symbols-outlined text-error text-[20px]">warning</span>';
        }
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        requestAnimationFrame(function () {
            dialog.classList.remove('scale-95', 'opacity-0');
            dialog.classList.add('scale-100', 'opacity-100');
        });
    };
    window.closeConfirmModal = function () {
        var modal = document.getElementById('confirm-modal'),
            dialog = document.getElementById('confirm-dialog');
        dialog.classList.remove('scale-100', 'opacity-100');
        dialog.classList.add('scale-95', 'opacity-0');
        setTimeout(function () {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            window._confirmCallback = null;
        }, 200);
    };
    document.getElementById('confirm-modal').addEventListener('click', function (e) {
        if (e.target === e.currentTarget) window.closeConfirmModal();
    });
})();
</script>
