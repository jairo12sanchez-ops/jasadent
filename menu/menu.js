document.addEventListener('DOMContentLoaded', function() {
    const cerrarBtn = document.getElementById('cerrarSesionBtn');
    if (cerrarBtn) {
        cerrarBtn.addEventListener('click', function() {
            localStorage.removeItem('usuarioActual');
            window.location.href = '../login/index.html'; // O la ruta correcta a tu login
        });
    }
});
