// procedimientos.js

// Función para crear oficio
function crearOficio(idSolicitudFk, procedimientoId) {
    $.ajax({
        url: createOficioRoute + '/' + idSolicitudFk,
        type: 'POST',
        data: {
            _token: csrfToken,
            id_procedimiento: procedimientoId
        },
        success: function(response) {
            var idOficio = response.id_oficio;
            // Crear el modal dinámicamente
            const modalHtml = `
                <div class="modal fade" id="efirma-${procedimientoId}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Firma electrónica</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form id="firmaForm" action="/firmar-documento" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="id_oficio" value="${idOficio}">
                                    <input type="hidden" name="tipo" value="MINUTA DE OBSERVACIONES">

                                    <div class="form-group">
                                        <label for="certificado">Certificado (.cer):</label>
                                        <input type="file" name="certificado" accept=".cer" id="certificado" class="form-control certificado-input" required>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="llave">Llave (.key):</label>
                                        <input type="file" name="llave" accept=".key" class="form-control" required>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="password">Contraseña:</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div><br><hr>
                                    <div class="form-group">
                                        <label for="estatus">Estatus:</label>
                                        <input type="text" name="estatus" id="estatus" class="form-control" readonly>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="rfc">RFC:</label>
                                        <input type="text" name="rfc" id="rfc" class="form-control" readonly>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="razon_social">Razón Social:</label>
                                        <input type="text" name="razon_social" id="razon_social" class="form-control" readonly>
                                    </div>
                                    <input type="text" name="numero_certificado" id="numero_certificado" class="form-control" hidden readonly>
                                    <br>
                                    <div class="alert alert-danger" id="errorMensaje" style="display: none; color: red;">
                                        El certificado no es válido para firmar documentos.
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="firmarBtn" disabled>Firmar Documento</button>
                                </form>
                                <!-- Loader -->
                                <div class="overlay" style="display: none;"></div>
                                <div class="loader" style="display: none;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);

            const modalElement = document.getElementById(`efirma-${procedimientoId}`);
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            // Eliminar el modal del DOM al cerrarlo
            modalElement.addEventListener('hidden.bs.modal', function () {
                modalElement.remove();
            });

            // Manejar el evento change del input certificado
            const certificadoInput = modalElement.querySelector('.certificado-input');
            certificadoInput.addEventListener('change', function() {
                const modalContent = this.closest('.modal-content');
                const loader = modalContent.querySelector('.loader');
                const overlay = modalContent.querySelector('.overlay');

                // Mostrar loader y overlay
                overlay.style.display = 'block';
                loader.style.display = 'block';

                let formData = new FormData();
                formData.append('certificado', this.files[0]);

                fetch(validarCertificadoRoute, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Ocultar loader y overlay
                    overlay.style.display = 'none';
                    loader.style.display = 'none';

                    if (data.error) {
                        alert(data.error);
                    } else {
                        modalContent.querySelector('#estatus').value = data.estatus;
                        modalContent.querySelector('#rfc').value = data.rfc;
                        modalContent.querySelector('#razon_social').value = data.razon_social;
                        modalContent.querySelector('#numero_certificado').value = data.numero_certificado;

                        const firmarBtn = modalContent.querySelector('#firmarBtn');
                        const errorMensaje = modalContent.querySelector('#errorMensaje');

                        if (data.estatus === 'Certificado Válido') {
                            firmarBtn.disabled = false;
                            errorMensaje.style.display = 'none';
                        } else {
                            firmarBtn.disabled = true;
                            errorMensaje.style.display = 'block';
                            errorMensaje.innerText = 'El certificado no es válido para firmar documentos.';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    overlay.style.display = 'none';
                    loader.style.display = 'none';
                });
            });
        },
        error: function(xhr) {
            console.error(xhr.responseText);
        }
    });
}

// Lógica para el botón de asignación
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.assign-button').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const idProcedimiento = this.getAttribute('data-id');

            const options = usuarios.map(usuario => `
                <option value="${usuario.id}">${usuario.name}</option>
            `).join('');

            // Crear el modal dinámicamente
            const modalHtml = `
                <div class="modal fade" id="assignModal-${idProcedimiento}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Asignar/Reasignar Procedimiento</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/procedimientos/asignar" method="POST" id="form-assign-${idProcedimiento}">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="procedimiento_id" value="${idProcedimiento}">
                                    <div class="form-group">
                                        <label for="user_id">Selecciona Usuario</label>
                                        <select class="form-control" name="user_id" required>
                                            ${options}
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" form="form-assign-${idProcedimiento}">Asignar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            document.body.insertAdjacentHTML('beforeend', modalHtml);

            const modalElement = document.getElementById(`assignModal-${idProcedimiento}`);
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            modalElement.addEventListener('hidden.bs.modal', function () {
                modalElement.remove();
            });
        });
    });
});
