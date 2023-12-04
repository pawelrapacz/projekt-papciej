const LIGHT = 0;
const DARK = 1;
const AUTO = 2;

colorSchemeApply();


function colorSchemeApply()
{
    if (localStorage.getItem('colorScheme') === LIGHT) {
        setToLight();
    }
    else if (localStorage.getItem('colorScheme') === DARK) {
        setToDark();
    }
    else {
        if (window.matchMedia('(prefers-color-scheme: dark)').matches) setToDark();
        localStorage.setItem('colorScheme', AUTO);
    
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', toggleColorScheme);
    }
}

function setToDark()
{
    document.documentElement.classList.add('dark');
}

function setToLight()
{
    document.documentElement.classList.remove('dark');
}

function toggleColorScheme()
{
    document.documentElement.classList.toggle('dark');
}