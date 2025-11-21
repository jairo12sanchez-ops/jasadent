//boton guardar y crear un usuario//
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
                document.getElementById('formUsuario').reset();
                // document.getElementById('id_usuario').value = data.id_usuario; // Optional: keep ID or clear it too? Usually reset clears everything.
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al guardar usuario: ' + error.message);
        });
}
// Función para buscar usuario por número de documento
function buscarUsuario() {
    var numeroDocumento = document.getElementById('numero_documento').value;

    if (!numeroDocumento) {
        // Si el campo está vacío, intentar pedirlo por prompt o alertar
        // Pero mejor usamos el campo si ya tiene algo, si no, pedimos que lo llenen
        var input = prompt("Ingrese el número de documento a buscar:");
        if (input) {
            document.getElementById('numero_documento').value = input;
            numeroDocumento = input;
        } else {
            return; // Cancelado o vacío
        }
    }

    fetch('buscar_usuario.php?numero_documento=' + numeroDocumento)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                var u = data.usuario;
                document.getElementById('id_usuario').value = u.id_usuarios;
                document.getElementById('tipo_documento').value = u.tipo_documento;
                document.getElementById('numero_documento').value = u.numero_documento;
                document.getElementById('nombres').value = u.nombres;
                document.getElementById('apellidos').value = u.apellidos;
                document.getElementById('direccion').value = u.direccion;
                document.getElementById('telefono').value = u.telefono;
                document.getElementById('email').value = u.email;
                document.getElementById('rol').value = u.rol;

                // Limpiar contraseñas para evitar confusión
                document.getElementById('password').value = '';
                document.getElementById('confirm_password').value = '';

                alert('Usuario encontrado.');
            } else {
                alert('Error: ' + data.error);
                // Limpiar ID para evitar ediciones accidentales de otro usuario
                document.getElementById('id_usuario').value = '';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al buscar usuario.');
        });
}

// Función para editar usuario existente
function editarUsuario() {
    var idUsuario = document.getElementById('id_usuario').value;

    if (!idUsuario) {
        alert('Por favor, busque un usuario primero para poder editarlo.');
        return;
    }

    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;

    if (password && password !== confirmPassword) {
        alert('Las contraseñas no coinciden');
        return;
    }

    var datos = {
        id_usuario: idUsuario,
        tipo_documento: document.getElementById('tipo_documento').value,
        numero_documento: document.getElementById('numero_documento').value,
        nombres: document.getElementById('nombres').value,
        apellidos: document.getElementById('apellidos').value,
        direccion: document.getElementById('direccion').value,
        telefono: document.getElementById('telefono').value,
        email: document.getElementById('email').value,
        password: password, // Puede estar vacío si no se cambia
        rol: document.getElementById('rol').value
    };

    fetch('editar_usuario.php', {
        method: 'POST',
        body: JSON.stringify(datos),
        headers: { 'Content-Type': 'application/json' }
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Usuario actualizado correctamente.');
                // Opcional: limpiar formulario o dejarlo para seguir editando
                // document.getElementById('formUsuario').reset();
            } else {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al editar usuario: ' + error.message);
        });
}

function eliminarUsuario() {
    alert('Funcionalidad de eliminar aún no implementada.');
}

//botton regresar al menu//
function regresarAlMenu() { window.location.href = '../menu/menu.html'; }
