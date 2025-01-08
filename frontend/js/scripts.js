// JavaScript para el frontend

/**
 * registro de usuarios
 */
document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = {
        first_name: document.getElementById('first_name').value,
        last_name: document.getElementById('last_name').value,
        email: document.getElementById('email').value,
        phone: document.getElementById('phone').value,
        password: document.getElementById('password').value
    };

    fetch('http://localhost/backend/index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
            } else {
                alert('Registro fallido');
            }
        })
        .catch(error => console.error('Error:', error));
});

/**
 * inicio de sesion
 */
document.getElementById('loginForm').addEventListener('submit', function (event){
    event.preventDefault();

    const formData = {
        email: document.getElementById('email').value,
        password: document.getElementById('password').value
    };

    fetch( 'http://localhost/backend/auth.php', {
        method: 'POST',

        /**
         * continuar con los parametros para enviar datos del formulario al backend y lugeo recibirlos
         */
    })
})