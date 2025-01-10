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
            if (data.token) {
                alert(data.token);
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Error:', error));
});