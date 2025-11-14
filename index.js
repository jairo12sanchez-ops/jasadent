/* CREDENCIALES DE INGRESO*/
if
        (document.getElementById('loginForm')){document.getElementById('loginForm').addEventListener('submit', function(event) {
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
                window.location.href = 'menu.html';
            } else {
                alert('Usuario o contraseña incorrectos');
                document.getElementById('password').value = '';
            }
        });
}
document.addEventListener('DOMContentLoaded', function() {
    const cerrarBtn = document.getElementById('cerrarSesionBtn');
    if (cerrarBtn) {
        cerrarBtn.addEventListener('click', function() {
            localStorage.removeItem('usuarioActual');
            window.location.href = 'index.html'; // o a la pantalla de login que prefieras
        });
    }
});
