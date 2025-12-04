(function() {
    const singularInput = document.getElementById('singular_label');
    const slugInput = document.getElementById('slug');
    const taxonomySingular = document.getElementById('taxonomy_singular_label');
    const taxonomySlug = document.getElementById('taxonomy_slug');

    function generateSlug(value) {
        return value
            .toLowerCase()
            .replace(/[^a-z0-9\s_-]/g, '')
            .trim()
            .replace(/\s+/g, '-');
    }

    function bindSlugAutoFill(source, target) {
        if (!source || !target) return;
        source.addEventListener('input', function() {
            if (target.dataset.touched === 'true') {
                return;
            }
            target.value = generateSlug(source.value);
        });
        target.addEventListener('input', function() {
            target.dataset.touched = 'true';
        });
    }

    bindSlugAutoFill(singularInput, slugInput);
    bindSlugAutoFill(taxonomySingular, taxonomySlug);

    // Field builder
    const addFieldButton = document.getElementById('my-cpt-ui-add-field');
    const fieldContainer = document.getElementById('my-cpt-ui-fields-container');
    const fieldTemplate = document.getElementById('my-cpt-ui-field-template');
    const emptyState = document.getElementById('my-cpt-ui-empty-state');
    let fieldIndex = 0;

    if (fieldContainer && fieldContainer.dataset.fieldCount) {
        const parsed = parseInt(fieldContainer.dataset.fieldCount, 10);
        if (!Number.isNaN(parsed)) {
            fieldIndex = parsed;
        }
    }

    function refreshEmptyState() {
        if (!emptyState) return;
        const hasFields = fieldContainer && fieldContainer.querySelector('.my-cpt-ui__field-row');
        emptyState.style.display = hasFields ? 'none' : 'block';
    }

    function toggleChoices(selectEl) {
        const fieldRow = selectEl.closest('.my-cpt-ui__field-row');
        const choices = fieldRow.querySelector('.my-cpt-ui__choices');
        if (!choices) return;
        choices.hidden = selectEl.value !== 'select';
    }

    function addField() {
        if (!fieldTemplate || !fieldContainer) return;
        const fragment = fieldTemplate.content.cloneNode(true);
        const html = fragment.querySelectorAll('[name]');
        html.forEach(function(input) {
            input.name = input.name.replace('__INDEX__', fieldIndex.toString());
        });

        const select = fragment.querySelector('select');
        if (select) {
            select.addEventListener('change', function() {
                toggleChoices(select);
            });
        }

        const removeBtn = fragment.querySelector('.my-cpt-ui__remove-field');
        if (removeBtn) {
            removeBtn.addEventListener('click', function() {
                removeBtn.closest('.my-cpt-ui__field-row').remove();
                refreshEmptyState();
            });
        }

        fieldContainer.appendChild(fragment);
        fieldIndex += 1;
        refreshEmptyState();
    }

    if (addFieldButton) {
        addFieldButton.addEventListener('click', addField);
    }

    document.querySelectorAll('.my-cpt-ui__remove-field').forEach(function(button) {
        button.addEventListener('click', function() {
            button.closest('.my-cpt-ui__field-row').remove();
            refreshEmptyState();
        });
    });

    document.addEventListener('change', function(event) {
        const target = event.target;
        if (target.matches('.my-cpt-ui__field-row select')) {
            toggleChoices(target);
        }
    });

    document.addEventListener('submit', function(event) {
        const target = event.target;
        if (target.classList && target.classList.contains('my-cpt-ui__delete-form')) {
            const message = target.dataset.confirmMessage || 'Are you sure?';
            if (!window.confirm(message)) {
                event.preventDefault();
            }
        }
    });

    refreshEmptyState();
})();
