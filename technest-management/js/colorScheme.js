const LIGHT = 0;
const DARK = 1;
const AUTO = 2;

colorSchemeApply();


function colorSchemeApply()
{
    const prefered = window.matchMedia('(prefers-color-scheme: dark)');
    prefered.removeEventListener('change', autoColorScheme);

    if (localStorage.getItem('colorScheme') == LIGHT) {
        setToLight();
        return;
    }
    else if (localStorage.getItem('colorScheme') == DARK) {
        setToDark();
        return;
    }

    autoColorScheme();
    localStorage.setItem('colorScheme', AUTO);

    prefered.addEventListener('change', autoColorScheme);
}

function setToDark()
{
    document.documentElement.classList.add('dark');
}

function setToLight()
{
    document.documentElement.classList.remove('dark');
}

function autoColorScheme()
{
    if (window.matchMedia('(prefers-color-scheme: dark)').matches) setToDark();
    else setToLight();
}