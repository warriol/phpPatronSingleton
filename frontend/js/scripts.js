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
 * listar usuarios
 */
document.getElementById('listUsersButton').addEventListener('click', function() {
    fetch('http://localhost/backend/index.php')
        .then(response => response.json())
        .then(data => {
            const usersTableBody = document.getElementById('usersTable').getElementsByTagName('tbody')[0];
            usersTableBody.innerHTML = ''; // Limpiar la tabla antes de agregar nuevos datos

            data.forEach(user => {
                const row = usersTableBody.insertRow();
                row.insertCell(0).textContent = user.id;
                row.insertCell(1).textContent = user.first_name;
                row.insertCell(2).textContent = user.last_name;
                row.insertCell(3).textContent = user.email;
                row.insertCell(4).textContent = user.phone;
            });
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
                alert('Credenciales incorrectas');
            }
        })
        .catch(error => console.error('Error:', error));
});