const colorSchemeSelector = document.getElementById('_color_scheme_selector');

colorSchemeSelector.value = localStorage.getItem('colorScheme');

colorSchemeSelector.addEventListener('change', () => {
    localStorage.setItem('colorScheme', colorSchemeSelector.value);
    colorSchemeApply();
});