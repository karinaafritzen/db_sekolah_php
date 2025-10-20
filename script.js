document.addEventListener('DOMContentLoaded', function() {
    function setupPasswordToggle(toggleId, passwordId) {
        const toggleButton = document.getElementById(toggleId);
        const passwordInput = document.getElementById(passwordId);
        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
            });
        }
    }
    setupPasswordToggle('togglePassword', 'password');
    setupPasswordToggle('toggleConfirmPassword', 'confirm_password');

    const profilePhotoInput = document.getElementById('foto_profil');
    if (profilePhotoInput) {
        profilePhotoInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                document.getElementById('upload-photo-form').submit();
            }
        });
    }

    const modalOverlay = document.getElementById('customModal');
    if (!modalOverlay) return;

    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalCancelBtn = document.getElementById('modalCancelBtn');
    const modalCloseBtn = document.querySelector('.modal-close');
    const modalBody = modalOverlay.querySelector('.modal-body');

    function openModal() {
        modalOverlay.classList.add('active');
    }

    function closeModal() {
        const oldInput = document.getElementById('modalPasswordInput');
        if (oldInput) {
            oldInput.parentElement.remove();
        }
        modalOverlay.classList.remove('active');
    }

    window.showModal = function(message, title = "Informasi") {
        const modalConfirmBtn = document.getElementById('modalConfirmBtn');
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modalConfirmBtn.style.display = 'none';
        modalCancelBtn.textContent = 'Tutup';
        openModal();
    }

    window.showConfirmModal = function(message, onConfirm, title = "Konfirmasi") {
        let modalConfirmBtn = document.getElementById('modalConfirmBtn');
        modalTitle.textContent = title;
        modalMessage.textContent = message;
        modalConfirmBtn.style.display = 'inline-flex';
        modalCancelBtn.textContent = 'Batal';
        const newConfirmBtn = modalConfirmBtn.cloneNode(true);
        modalConfirmBtn.parentNode.replaceChild(newConfirmBtn, modalConfirmBtn);
        newConfirmBtn.onclick = function() {
            onConfirm();
            closeModal();
        };
        openModal();
    }

    window.showPasswordConfirmModal = function(message, formId, title = "Verifikasi Aksi") {
        let modalConfirmBtn = document.getElementById('modalConfirmBtn');
        modalTitle.textContent = title;
        modalMessage.textContent = message;

        if (!document.getElementById('modalPasswordInput')) {
            const passwordGroup = document.createElement('div');
            passwordGroup.className = 'form-group';
            passwordGroup.style.marginTop = '20px';
            passwordGroup.innerHTML = `
                <label for="modalPasswordInput" style="text-align: left; font-weight: 500;">Masukkan password Anda:</label>
                <input type="password" id="modalPasswordInput" name="password_verification" class="modal-input" required>
            `;
            modalBody.appendChild(passwordGroup);
        }

        modalConfirmBtn.style.display = 'inline-flex';
        modalCancelBtn.textContent = 'Batal';

        const newConfirmBtn = modalConfirmBtn.cloneNode(true);
        modalConfirmBtn.parentNode.replaceChild(newConfirmBtn, modalConfirmBtn);

        newConfirmBtn.onclick = function() {
            const form = document.getElementById(formId);
            const passwordInput = document.getElementById('modalPasswordInput');
            if (form && passwordInput && passwordInput.value) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'password_verification';
                hiddenInput.value = passwordInput.value;
                form.appendChild(hiddenInput);
                form.submit();
            } else if (passwordInput && !passwordInput.value) {
                alert('Password tidak boleh kosong.');
            }
        };

        openModal();
    }
    
    if(modalCloseBtn) modalCloseBtn.addEventListener('click', closeModal);
    modalCancelBtn.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', function(event) {
        if (event.target === modalOverlay) {
            closeModal();
        }
    });
});

