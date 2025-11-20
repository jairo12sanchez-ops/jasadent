document.addEventListener('DOMContentLoaded', function () {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const usuario = document.getElementById('usuario').value.trim();
            const password = document.getElementById('password').value.trim();

            if (usuario === '' || password === '') {
                alert('Por favor complete todos los campos');
                return;
            }

            // Enviar credenciales al backend
            fetch('login.php', {
                method: 'POST',
                body: JSON.stringify({ usuario: usuario, password: password }),
                headers: { 'Content-Type': 'application/json' }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        console.log('Redirecting to:', data.redirect);
                        window.location.href = data.redirect;
                    } else {
                        alert('Error: ' + data.error);
                        document.getElementById('password').value = '';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error de conexión');
                });
        });
    }
    // Botón para cerrar sesión (si lo tienes en tu menú)
    const cerrarBtn = document.getElementById('cerrarSesionBtn');
    if (cerrarBtn) {
        cerrarBtn.addEventListener('click', function () {
            localStorage.removeItem('usuarioActual');
            window.location.href = 'index.html'; // Volver al login
        });
    }
});
