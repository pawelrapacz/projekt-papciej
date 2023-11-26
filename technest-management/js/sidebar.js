const sidebar = document.querySelector('.sidebar');
const sidebarBtn = document.querySelector('.sidebar-btn');
const wrapper = document.querySelector('.wrapper');

const SIDEBAR_COL_WIDTH = sidebar.style.width;
const SIDEBAR_EX_WIDTH = 'clamp(20rem, 20vw, 25rem)';
const SIDEBAR_COL = 0;
const SIDEBAR_EX = 1;


if (localStorage.getItem('sidebarStatus') == SIDEBAR_EX) expandSidebar();

sidebarBtn.addEventListener('click', expandSidebar);

const links = document.querySelectorAll('.nav-link');
links.forEach(element => {
    const submenu = element.parentElement.querySelector('.submenu');

    if (!submenu) return;

    element.addEventListener('click', () => {
        if (!sidebar.classList.contains('sidebar-expanded')) expandSidebar();
        submenu.classList.toggle('submenu-expanded')
    })
});



function expandSidebar() {
    const submenus = document.querySelectorAll('.submenu');
    sidebar.classList.toggle('sidebar-expanded');
    
    if (sidebar.classList.contains('sidebar-expanded'))
    {
        sidebar.style.width = SIDEBAR_EX_WIDTH;
        wrapper.style.marginLeft = SIDEBAR_EX_WIDTH;
        localStorage.setItem('sidebarStatus', SIDEBAR_EX);
        return;
    }
    
    sidebar.style.width = SIDEBAR_COL_WIDTH;
    wrapper.style.marginLeft = SIDEBAR_COL_WIDTH;
    localStorage.setItem('sidebarStatus', SIDEBAR_COL);
    submenus.forEach(el => {
        el.classList.remove('submenu-expanded');
    });
}