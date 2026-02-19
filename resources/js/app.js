import './bootstrap';

const likedIcon = `
<svg viewBox="0 0 24 24" class="ig-icon ig-heart-filled" aria-hidden="true">
    <path d="M12 21s-7-4.35-9.5-8.28C.3 9.2 2.1 5 6 5c2.2 0 3.4 1.3 4 2.2C10.6 6.3 11.8 5 14 5c3.9 0 5.7 4.2 3.5 7.72C19 16.65 12 21 12 21z"></path>
</svg>
`;

const unlikedIcon = `
<svg viewBox="0 0 24 24" class="ig-icon" aria-hidden="true">
    <path d="M12 21s-7-4.35-9.5-8.28C.3 9.2 2.1 5 6 5c2.2 0 3.4 1.3 4 2.2C10.6 6.3 11.8 5 14 5c3.9 0 5.7 4.2 3.5 7.72C19 16.65 12 21 12 21z" fill="none" stroke="currentColor" stroke-width="1.7"></path>
</svg>
`;

function getLikeCountElement(form) {
    const container = form.closest('.ig-post-card, .ig-post-detail-side');
    return container ? container.querySelector('.ig-post-likes') : null;
}

function setFallbackMethodInput(form, shouldUseDelete) {
    const existing = form.querySelector('input[name="_method"]');

    if (shouldUseDelete) {
        if (!existing) {
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
        } else {
            existing.value = 'DELETE';
        }
        form.action = form.dataset.destroyUrl;
        return;
    }

    if (existing) {
        existing.remove();
    }
    form.action = form.dataset.storeUrl;
}

async function handleLikeFormSubmit(event) {
    event.preventDefault();

    const form = event.currentTarget;
    if (form.dataset.loading === '1') {
        return;
    }

    const button = form.querySelector('button[type="submit"]');
    const currentlyLiked = form.dataset.liked === '1';
    const targetUrl = currentlyLiked ? form.dataset.destroyUrl : form.dataset.storeUrl;
    const targetMethod = currentlyLiked ? 'DELETE' : 'POST';
    const csrfToken = form.querySelector('input[name="_token"]')?.value;

    if (!targetUrl || !csrfToken) {
        form.submit();
        return;
    }

    form.dataset.loading = '1';
    if (button) {
        button.disabled = true;
    }

    try {
        const response = await fetch(targetUrl, {
            method: targetMethod,
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
            },
            credentials: 'same-origin',
            body: '{}',
        });

        if (!response.ok) {
            throw new Error('Like request failed');
        }

        const data = await response.json();
        const isLiked = Boolean(data.liked);
        form.dataset.liked = isLiked ? '1' : '0';
        setFallbackMethodInput(form, isLiked);

        if (button) {
            button.innerHTML = isLiked ? likedIcon : unlikedIcon;
            button.setAttribute('aria-label', isLiked ? 'Unlike' : 'Like');
        }

        const likesCountElement = getLikeCountElement(form);
        if (likesCountElement && Number.isFinite(Number(data.likes_count))) {
            likesCountElement.textContent = `${data.likes_count} likes`;
        }
    } catch (error) {
        form.submit();
    } finally {
        form.dataset.loading = '0';
        if (button) {
            button.disabled = false;
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-like-form]').forEach((form) => {
        form.addEventListener('submit', handleLikeFormSubmit);
    });
});
