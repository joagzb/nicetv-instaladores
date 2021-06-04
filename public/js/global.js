window.onload = function (){
    //pintar las pestanas de navegacion en el panel lateral en base a la pantalla
    paint_current_tab();
}

/*=============================================================
* SIDEBAR
* ==============================================================*/
function paint_current_tab(){
    // selectores de componentes html
    let entrada_panelPrincipal = document.querySelectorAll('.entrada_panelPrincipal');
    let entrada_historial = document.querySelectorAll('.entrada_historial');

    let entrada_administradores = document.querySelectorAll('.entrada_admins');
    let entrada_ayuda = document.querySelectorAll('.entrada_ayuda');

    let entrada_Adashboard = document.querySelectorAll('.entrada_Adashboard');
    let entrada_ARecents = document.querySelectorAll('.entrada_Arecientes');
    let entrada_AInstaladores = document.querySelectorAll('.entrada_AInstaladores');
    let entrada_APreferencias = document.querySelectorAll('.entrada_APreferencias');

    //obtener la url relativa
    const relative_path = window.location.pathname;

    //cambiar la entrada activa segun el path de la url (INSTALADORES)
    if(relative_path.includes('/home')){
        entrada_panelPrincipal.forEach(element => {
            element.classList.add('active');
        });
        entrada_historial.forEach(element => {
            element.classList.remove('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });
    }

    if(relative_path.includes('/historial')){
        entrada_panelPrincipal.forEach(element => {
            element.classList.remove('active');
        });
        entrada_historial.forEach(element => {
            element.classList.add('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });
    }

    if(relative_path.includes('/usuarios/administradores')){
        entrada_panelPrincipal.forEach(element => {
            element.classList.remove('active');
        });
        entrada_historial.forEach(element => {
            element.classList.remove('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.add('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });
        entrada_Adashboard.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ARecents.forEach(element => {
            element.classList.remove('active');
        });
        entrada_AInstaladores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_APreferencias.forEach(element => {
            element.classList.remove('active');
        });
    }

    if(relative_path.includes('/help')){
        entrada_panelPrincipal.forEach(element => {
            element.classList.remove('active');
        });
        entrada_historial.forEach(element => {
            element.classList.remove('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.add('active');
        });
        entrada_Adashboard.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ARecents.forEach(element => {
            element.classList.remove('active');
        });
        entrada_AInstaladores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_APreferencias.forEach(element => {
            element.classList.remove('active');
        });
    }

    // (ADMINISTRADORES)
    if(relative_path.includes('/admin/home')){
        entrada_Adashboard.forEach(element => {
            element.classList.add('active');
        });
        entrada_ARecents.forEach(element => {
            element.classList.remove('active');
        });
        entrada_AInstaladores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_APreferencias.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });
    }

    if(relative_path.includes('/admin/reclamos/reciente')){
        entrada_Adashboard.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ARecents.forEach(element => {
            element.classList.add('active');
        });
        entrada_AInstaladores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_APreferencias.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });
    }

    if(relative_path.includes('/admin/instaladores')){
        entrada_Adashboard.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ARecents.forEach(element => {
            element.classList.remove('active');
        });
        entrada_AInstaladores.forEach(element => {
            element.classList.add('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_APreferencias.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });
    }
    if(relative_path.includes('/admin/preferencias')){
        entrada_Adashboard.forEach(element => {
            element.classList.remove('active');
        });
        entrada_ARecents.forEach(element => {
            element.classList.remove('active');
        });
        entrada_AInstaladores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_administradores.forEach(element => {
            element.classList.remove('active');
        });
        entrada_APreferencias.forEach(element => {
            element.classList.add('active');
        });
        entrada_ayuda.forEach(element => {
            element.classList.remove('active');
        });
    }
}
