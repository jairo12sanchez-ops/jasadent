function cerrarSesion() {
    localStorage.removeItem('usuarioActual');
    // Detectar si estamos en un subdirectorio o en la raíz para redirigir correctamente
    // Asumimos estructura: /carpeta/archivo.html -> ../login/index.html
    // Si estamos en /menu/menu.html -> ../login/index.html

    // Una forma robusta es usar ruta absoluta si se conoce, o relativa asumiendo profundidad 1
    window.location.href = '../login/index.html';
}

document.addEventListener('DOMContentLoaded', function () {
    const cerrarBtn = document.getElementById('cerrarSesionBtn');
    if (cerrarBtn) {
        cerrarBtn.addEventListener('click', cerrarSesion);
    }
});
