const sidebar = document.querySelector('.sidebar');
const sidebarBtn = document.querySelector('.sidebar-btn');
const wrapper = document.querySelector('.wrapper');

if (sidebar)
{
const SIDEBAR_COL_WIDTH = sidebar.style.width;
const SIDEBAR_EX_WIDTH = 'clamp(20rem, 20vw, 25rem)';
const COLLAPSED = 0;
const EXPANDED = 1;

if (localStorage.getItem('sidebarStatus') == EXPANDED) toggleSidebar();
sidebarBtn.addEventListener('click', toggleSidebar);

const submenus = document.querySelectorAll('.submenu');
submenus.forEach((submenu, index) => {
    const expandBtn = submenu.parentElement.querySelector('.nav-link');
    submenu.storageName = 'submenu' + index + 'Status';
    
    if (localStorage.getItem(submenu.storageName) == EXPANDED) toggleSubmenu(submenu, EXPANDED);

    expandBtn.addEventListener('click', () => {toggleSubmenu(submenu)});
});



function toggleSidebar() {
    sidebar.classList.toggle('sidebar-expanded');
    
    if (sidebar.classList.contains('sidebar-expanded'))
    {
        sidebar.style.width = SIDEBAR_EX_WIDTH;
        wrapper.style.marginLeft = SIDEBAR_EX_WIDTH;
        localStorage.setItem('sidebarStatus', EXPANDED);
        return;
    }
    
    sidebar.style.width = SIDEBAR_COL_WIDTH;
    wrapper.style.marginLeft = SIDEBAR_COL_WIDTH;
    localStorage.setItem('sidebarStatus', COLLAPSED);
    submenus.forEach(el => {
        toggleSubmenu(el, COLLAPSED);
    });
}

function toggleSubmenu(el, event = undefined) {
    if (event == EXPANDED)
    {
        if (!sidebar.classList.contains('sidebar-expanded')) toggleSidebar();
        el.classList.add('submenu-expanded');
        localStorage.setItem(el.storageName, EXPANDED);
        return;
    }
    if (event == COLLAPSED)
    {
        el.classList.remove('submenu-expanded');
        localStorage.setItem(el.storageName, COLLAPSED);
        return;
    }
    
    if (!sidebar.classList.contains('sidebar-expanded')) toggleSidebar();

    el.classList.toggle('submenu-expanded');

    if (el.classList.contains('submenu-expanded'))
        localStorage.setItem(el.storageName, EXPANDED);
    else
        localStorage.setItem(el.storageName, COLLAPSED);
}

}