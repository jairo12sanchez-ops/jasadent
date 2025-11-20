//boton guardar y crear un paciente//
function guardarUsuario() {
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;

    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return;
    }

    var datos = {
        tipo_documento: document.getElementById('tipo_documento').value,
        numero_documento: document.getElementById('numero_documento').value,
        nombres: document.getElementById('nombres').value,
        apellidos: document.getElementById('apellidos').value,
        direccion: document.getElementById('direccion').value,
        telefono: document.getElementById('telefono').value,
        email: document.getElementById('email').value,
        password: password,
        rol: document.getElementById('rol').value
    };

    fetch('usuarios.php', {
        method: 'POST',
        body: JSON.stringify(datos),
        headers: { 'Content-Type': 'application/json' }
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Usuario guardado con ID: ' + data.id_usuario);
                document.getElementById('id_usuario').value = data.id_usuario;
            } else {
                alert('Error: ' + data.error);
            }
        });
}
//botton regresar al menu//
function regresarAlMenu() { window.location.href = '../menu/menu.html'; }
