import '../../js/bootstrap';
import Alpine from 'alpinejs';
import axios from 'axios';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.axios = axios;
window.Swal = Swal;
console.log("app.js is loaded correctly");

Alpine.start();

// Lógica para manejar las notificaciones de éxito y error con SweetAlert2
function mostrarAlerta(tipo, titulo, mensaje) {
    Swal.fire({
        icon: tipo,
        title: titulo,
        text: mensaje,
        showConfirmButton: false,
        timer: 2000
    });
}

// Función para manejar formularios AJAX
function enviarFormulario(formulario, metodo, url, datos) {
    axios({
        method: metodo,
        url: url,
        data: datos,
    }).then(function(response) {
        if (response.data.success) {
            mostrarAlerta('success', 'Éxito', response.data.message);
        } else {
            mostrarAlerta('error', 'Error', response.data.message);
        }
    }).catch(function(error) {
        console.error('Error:', error);
        mostrarAlerta('error', 'Error', 'Ha ocurrido un problema. Inténtalo de nuevo.');
    });
}

export { enviarFormulario, mostrarAlerta };
