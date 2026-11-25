function initializeAdminVerificationFilters() {
    if (!document.getElementById('admin-user-manager')) {
        return;
    }

    const regionIds = ['summary-cards', 'user-filter-controls', 'user-results'];
    const results = document.getElementById('user-results');
    const errorMessage = document.getElementById('filter-error');
    let requestVersion = 0;
    let searchTimeout;

    async function refreshUsers(url, historyMode = 'push') {
        const currentRequestVersion = ++requestVersion;
        const restoreSearchFocus = document.activeElement && document.activeElement.name === 'search';

        results.setAttribute('aria-busy', 'true');
        results.classList.add('opacity-60');
        document.getElementById('filter-loading').hidden = false;
        errorMessage.hidden = true;

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'text/html',
                },
            });

            if (!response.ok) {
                throw new Error('Filter request failed with status ' + response.status + '.');
            }

            const html = await response.text();
            const parsedDocument = new DOMParser().parseFromString(html, 'text/html');
            const replacements = regionIds.map((id) => ({
                current: document.getElementById(id),
                next: parsedDocument.getElementById(id),
            }));

            if (replacements.some((item) => !item.current || !item.next)) {
                throw new Error('The filter response did not contain the expected account sections.');
            }

            if (currentRequestVersion !== requestVersion) {
                return;
            }

            replacements.forEach((item) => {
                item.current.innerHTML = item.next.innerHTML;
            });

            if (historyMode !== 'none') {
                const nextUrl = new URL(url, window.location.origin);
                const historyMethod = historyMode === 'replace' ? 'replaceState' : 'pushState';
                window.history[historyMethod]({}, '', nextUrl.pathname + nextUrl.search);
            }

            if (restoreSearchFocus) {
                const searchInput = document.querySelector('#user-filter-controls input[name="search"]');
                if (searchInput) {
                    searchInput.focus();
                    searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
                }
            }
        } catch (error) {
            if (currentRequestVersion === requestVersion) {
                console.error(error);
                errorMessage.hidden = false;
            }
        } finally {
            if (currentRequestVersion === requestVersion) {
                results.setAttribute('aria-busy', 'false');
                results.classList.remove('opacity-60');
                document.getElementById('filter-loading').hidden = true;
            }
        }
    }

    function searchUsers(form, historyMode) {
        const parameters = new URLSearchParams(new FormData(form));
        parameters.delete('users_page');
        parameters.delete('employees_page');

        const searchUrl = new URL(form.action, window.location.origin);
        searchUrl.search = parameters.toString();
        refreshUsers(searchUrl.href, historyMode);
    }

    document.addEventListener('click', (event) => {
        const target = event.target instanceof Element ? event.target : event.target.parentElement;
        const link = target && target.closest('#summary-cards a, #user-filter-controls a, #user-results a');

        if (!link || link.origin !== window.location.origin || link.pathname !== window.location.pathname) {
            return;
        }

        event.preventDefault();
        refreshUsers(link.href);
    });

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!form.matches('#user-filter-controls form')) {
            return;
        }

        event.preventDefault();
        clearTimeout(searchTimeout);
        searchUsers(form, 'push');
    });

    document.addEventListener('input', (event) => {
        const input = event.target;
        if (!input.matches('#user-filter-controls input[name="search"]')) {
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchUsers(input.form, 'replace');
        }, 400);
    });

    window.addEventListener('popstate', () => {
        refreshUsers(window.location.href, 'none');
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeAdminVerificationFilters, { once: true });
} else {
    initializeAdminVerificationFilters();
}
