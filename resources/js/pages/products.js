document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.w-filters');
    if (!form) return;

    const applyBtn = document.createElement('button');
    applyBtn.type = 'submit';
    applyBtn.textContent = 'Применить';
    applyBtn.className = 'floating-apply-btn btn';
    Object.assign(applyBtn.style, {
        position: 'absolute',
        left: '-100px',
        top: '0',
        cursor: 'pointer',
        width: 'auto',
        fontSize: '13px',
        boxShadow: '0 2px 6px rgba(0,0,0,0.15)',
        display: 'none',
        zIndex: '5',
    });
    form.appendChild(applyBtn);

    const checkboxes = form.querySelectorAll('.filters-list__checkbox, .category-list__checkbox');
    let lastActiveLabel = null;

    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            const anyChecked = form.querySelectorAll(
                '.filters-list__checkbox:checked, .category-list__checkbox:checked')
                .length > 0;

            if (anyChecked) {
                const label = checkbox.closest('label, a');
                if (!label) return;
                lastActiveLabel = label;

                const rect = label.getBoundingClientRect();
                const formRect = form.getBoundingClientRect();

                applyBtn.style.display = 'block';
                applyBtn.style.top = `${rect.top - formRect.top - 8}px`;
            } else {
                applyBtn.style.display = 'none';
            }
        });
    });

    form.addEventListener('scroll', () => {
        if (applyBtn.style.display === 'none' || !lastActiveLabel) return;
        const rect = lastActiveLabel.getBoundingClientRect();
        const formRect = form.getBoundingClientRect();
        applyBtn.style.top = `${rect.top - formRect.top}px`;
    });
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-values').forEach(btn => {
        btn.addEventListener('click', () => {
            const list = btn.closest('.filters-list');
            const extraItems = list.querySelectorAll('.extra-value');

            if (extraItems.length === 0) return; // ✅ защита от ошибки

            const isHidden = extraItems[0].style.display === 'none';

            extraItems.forEach(item => {
                item.style.display = isHidden ? 'block' : 'none';
            });

            btn.textContent = isHidden ? 'Свернуть' : 'Показать все';
        });
    });
});
