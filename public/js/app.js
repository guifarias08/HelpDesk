document.addEventListener('DOMContentLoaded', () => {
    const root = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const menuButton = document.getElementById('menuButton');
    const mainNav = document.getElementById('mainNav');
    const profileButton = document.getElementById('profileButton');
    const profileMenu = document.getElementById('profileMenu');
    const progress = document.getElementById('routeProgress');
    const pageLoader = document.getElementById('pageLoader');

    const showPageLoader = () => {
        if (!pageLoader) return;
        pageLoader.classList.remove('is-leaving');
        pageLoader.classList.add('is-active');
        pageLoader.setAttribute('aria-hidden', 'false');
    };

    const hidePageLoader = () => {
        if (!pageLoader) return;
        pageLoader.classList.add('is-leaving');
        pageLoader.setAttribute('aria-hidden', 'true');
        window.setTimeout(() => pageLoader.classList.remove('is-active'), 320);
    };

    const updateThemeButton = () => {
        if (!themeToggle) return;
        const light = root.classList.contains('light');
        themeToggle.textContent = light ? '☾' : '☀';
        themeToggle.title = light ? 'Usar tema escuro' : 'Usar tema claro';
    };

    themeToggle?.addEventListener('click', () => {
        root.classList.toggle('light');
        localStorage.setItem('helpdesk-theme', root.classList.contains('light') ? 'light' : 'dark');
        updateThemeButton();
    });
    updateThemeButton();

    const closeMobileMenu = () => {
        mainNav?.classList.remove('open');
        menuButton?.classList.remove('open');
        menuButton?.setAttribute('aria-expanded', 'false');
    };

    menuButton?.addEventListener('click', () => {
        const open = mainNav?.classList.toggle('open');
        menuButton.classList.toggle('open', open);
        menuButton.setAttribute('aria-expanded', String(Boolean(open)));
    });

    const closeProfile = () => {
        if (!profileMenu || !profileButton) return;
        profileMenu.hidden = true;
        profileButton.setAttribute('aria-expanded', 'false');
    };

    profileButton?.addEventListener('click', (event) => {
        event.stopPropagation();
        const willOpen = profileMenu.hidden;
        profileMenu.hidden = !willOpen;
        profileButton.setAttribute('aria-expanded', String(willOpen));
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('.profile-menu-wrap')) closeProfile();
        if (!event.target.closest('.topbar-inner')) closeMobileMenu();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeProfile();
            closeMobileMenu();
        }
        if (event.key === '/' && !['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement.tagName)) {
            const search = document.getElementById('search');
            if (search) {
                event.preventDefault();
                search.focus();
            }
        }
    });

    const showProgress = () => {
        progress?.classList.remove('complete');
        progress?.classList.add('loading');
        showPageLoader();
    };

    document.querySelectorAll('a[href]').forEach((link) => {
        link.addEventListener('click', (event) => {
            const url = new URL(link.href, window.location.href);
            if (url.origin === location.origin && !link.target && !event.ctrlKey && !event.metaKey && !link.hash) showProgress();
        });
    });

    window.addEventListener('pageshow', () => {
        progress?.classList.remove('loading');
        window.setTimeout(hidePageLoader, 1400);
        document.querySelectorAll('button[disabled][data-was-enabled]').forEach((button) => {
            button.disabled = false;
            button.removeAttribute('data-was-enabled');
        });
    });

    window.setTimeout(hidePageLoader, 1400);

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (event.defaultPrevented) return;
            if (form.hasAttribute('data-confirm') && form.dataset.confirmed !== 'true') return;
            showProgress();
            const button = event.submitter;
            if (button && button.dataset.loadingLabel) {
                button.dataset.originalHtml = button.innerHTML;
                button.innerHTML = `<span class="button-spinner" aria-hidden="true"></span>${button.dataset.loadingLabel}`;
                button.dataset.wasEnabled = 'true';
                button.disabled = true;
            }
        });
    });

    document.querySelectorAll('[data-counter]').forEach((field) => {
        const target = document.getElementById(field.dataset.counterTarget);
        const update = () => {
            if (target) target.textContent = `${field.value.length} / ${field.maxLength || 5000}`;
        };
        field.addEventListener('input', update);
        update();
    });

    const dismissToast = (toast) => {
        toast.classList.add('toast-leaving');
        setTimeout(() => toast.remove(), 260);
    };

    document.querySelectorAll('[data-toast]').forEach((toast) => {
        const timeout = setTimeout(() => dismissToast(toast), 5200);
        toast.addEventListener('mouseenter', () => {
            clearTimeout(timeout);
            toast.classList.add('paused');
        }, { once: true });
        toast.querySelector('[data-toast-close]')?.addEventListener('click', () => dismissToast(toast));
    });

    window.helpdeskToast = (message, type = 'success') => {
        const region = document.getElementById('toastRegion');
        if (!region) return;
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.dataset.toast = '';
        toast.innerHTML = `<span class="toast-icon">${type === 'success' ? '✓' : '!'}</span><div><strong>${type === 'success' ? 'Concluído' : 'Atenção'}</strong><p></p></div><button type="button" class="toast-close" aria-label="Fechar aviso">×</button><span class="toast-timer"></span>`;
        toast.querySelector('p').textContent = message;
        toast.querySelector('button').addEventListener('click', () => dismissToast(toast));
        region.appendChild(toast);
        setTimeout(() => dismissToast(toast), 4200);
    };

    document.querySelectorAll('[data-copy]').forEach((button) => {
        button.addEventListener('click', async () => {
            try {
                await navigator.clipboard.writeText(button.dataset.copy);
                window.helpdeskToast('Protocolo copiado para a área de transferência.');
            } catch {
                window.helpdeskToast('Não foi possível copiar o protocolo.', 'error');
            }
        });
    });

    document.querySelectorAll('[data-submit-on-change]').forEach((select) => {
        select.addEventListener('change', () => select.form?.requestSubmit());
    });

    document.querySelectorAll('tr[data-href]').forEach((row) => {
        const open = (event) => {
            if (event.target.closest('a, button, input, select')) return;
            location.href = row.dataset.href;
        };
        row.addEventListener('click', open);
        row.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') open(event);
        });
    });

    const dialog = document.getElementById('confirmDialog');
    let pendingForm = null;
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (form.dataset.confirmed === 'true') return;
            event.preventDefault();
            pendingForm = form;
            document.getElementById('confirmMessage').textContent = form.dataset.confirm;
            dialog?.showModal();
        });
    });
    dialog?.addEventListener('close', () => {
        if (dialog.returnValue === 'confirm' && pendingForm) {
            pendingForm.dataset.confirmed = 'true';
            pendingForm.requestSubmit();
        }
        pendingForm = null;
    });

    const titleInput = document.querySelector('[data-preview-title]');
    const categoryInput = document.querySelector('[data-preview-category]');
    const priorityInput = document.querySelector('[data-preview-priority]');
    if (titleInput && categoryInput && priorityInput) {
        const labels = { low: 'Baixa', normal: 'Normal', high: 'Alta', urgent: 'Urgente' };
        const updatePreview = () => {
            const option = categoryInput.options[categoryInput.selectedIndex];
            document.getElementById('previewTitle').textContent = titleInput.value.trim() || 'Título do seu chamado';
            document.getElementById('previewCategory').textContent = categoryInput.value ? `${option.dataset.icon || '◇'} ${option.text}` : '◇ Categoria não selecionada';
            const priority = document.getElementById('previewPriority');
            priority.textContent = labels[priorityInput.value];
            priority.className = `badge priority-${priorityInput.value}`;
        };
        [titleInput, categoryInput, priorityInput].forEach((field) => field.addEventListener('input', updatePreview));
        updatePreview();
    }
});
