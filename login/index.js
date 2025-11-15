document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const usuario = document.getElementById('usuario').value.trim();
            const password = document.getElementById('password').value.trim();

            if (usuario === '' || password === '') {
                alert('Por favor complete todos los campos');
                return;
            }

            // Credenciales de prueba
            if (usuario === 'admin' && password === '1234') {
                alert('Bienvenido ' + usuario);
                window.location.href = "../menu/menu.html"; // Redirigir al menú
            } else {
                alert('Usuario o contraseña incorrectos');
                document.getElementById('password').value = '';
            }
        });
    }
    // Botón para cerrar sesión (si lo tienes en tu menú)
    const cerrarBtn = document.getElementById('cerrarSesionBtn');
    if (cerrarBtn) {
        cerrarBtn.addEventListener('click', function() {
            localStorage.removeItem('usuarioActual');
            window.location.href = 'index.html'; // Volver al login
        });
    }
});
