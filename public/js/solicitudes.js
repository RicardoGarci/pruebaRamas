function loadDataFirmaN(id_solicitud_fk, tipo) {
    $.ajax({
        url: `/oficio/${id_solicitud_fk}/${tipo}`,
        method: 'GET',
        success: function(response) {
            _token: csrfToken,
            console.log("Respuesta AJAX:", response);

            // Tipos permitidos
            const tiposPermitidos = ['OPINION NORMATIVA', 'SOLICITUD CANCELACION', 'CANCELACION', 'NOTIFICACION'];

            // Verificar si el tipo recibido está dentro de los tipos permitidos
            if (tiposPermitidos.includes(tipo)) {
                // Crear el modal dinámicamente solo si los datos están presentes
                if (response.id_oficio && response.tipo_oficio) {
                    // Generar el HTML del modal
                    const modalHtml = `
                        <div class="modal fade" id="efirma-${response.id_oficio}" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Firma electrónica</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="firmaForm" action="/firmar-documento" method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="${csrfToken}">
                                            <input type="hidden" name="id_oficio" value="${response.id_oficio}">
                                            <input type="hidden" name="tipo" value="${response.tipo_oficio}">
                                            
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
                    
                    // Insertar el modal en el cuerpo del documento
                    document.body.insertAdjacentHTML('beforeend', modalHtml);
                    
                    const modalElement = document.getElementById(`efirma-${response.id_oficio}`);
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();

                    // Eliminar el modal al cerrarlo
                    modalElement.addEventListener('hidden.bs.modal', function () {
                        modalElement.remove();
                    });

                    // Configurar el evento change para validar el certificado
                    const certificadoInput = modalElement.querySelector('.certificado-input');
                    certificadoInput.addEventListener('change', function() {
                        const modalContent = this.closest('.modal-content');
                        const loader = modalContent.querySelector('.loader');
                        const overlay = modalContent.querySelector('.overlay');

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
                } else {
                    console.error('No se encontraron los datos necesarios en la respuesta:', data);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
        }
    });
}


//Modal de acuses
function acuseModal(id_solicitud_fk) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log(id_solicitud_fk);

    $.ajax({
        url: `/oficio/${id_solicitud_fk}`,
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            console.log("Respuesta AJAX:", response);
            console.log("Respuesta AJAX:", response.estatus);

            // Generar el HTML del modal solo si existen los datos
            let modalHtml = `
                <div class="modal fade" id="modalAcuse${id_solicitud_fk}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Acuses</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <h5>Tipo de Acuse</h5>`;

            if (response.estatus !== 'INICIADO') {
                modalHtml += `
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p>SOLICITUD ENVIADA</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <a type="button" class="btn btn-primary" href="/solicitud/solicitud-enviada/${id_solicitud_fk}" target="_blank">
                                <i class="ri-file-download-line"></i> Ver Documentación
                            </a>
                        </div>
                    </div>
                    <br>`;
            }

            // response.oficios.forEach(oficio => {
            //     if (oficio.e_firma !== null && oficio.tipo_oficio !== 'MINUTA DE OBSERVACIONES') {
            //         modalHtml += `
            //             <div class="row mb-3">
            //                 <div class="col-md-6">
            //                     <p>${oficio.tipo_oficio}</p>
            //                 </div>
            //                 <div class="col-md-6 text-end">
            //                     <a type="button" class="btn btn-primary" href="/oficiosAcuses/${oficio.id_oficio}" target="_blank">
            //                         <i class="ri-file-download-line"></i> Ver Documentación
            //                     </a>
            //                 </div>
            //             </div>`;
            //     }
            // });

            modalHtml += `
                            </div>
                        </div>
                    </div>
                </div>`;

            // Agregar el modal al DOM
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            console.log(modalHtml);

            // Mostrar el modal
            const modalElement = document.getElementById(`modalAcuse${id_solicitud_fk}`);
            const modal = new bootstrap.Modal(modalElement);
            modal.show();

            // Eliminar el modal del DOM después de cerrarlo
            modalElement.addEventListener('hidden.bs.modal', function () {
                modalElement.remove();
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la petición AJAX:", textStatus, errorThrown);
        }
    });
}



//Modal para agregar texto a los oficios
function loadTextoAdicionalN(id_solicitud_fk, tipo) {
    console.log('ID DE LA SOLICITUD', id_solicitud_fk);
    console.log('TIPO DE OFICIO', tipo);
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch(`/oficio/${id_solicitud_fk}`, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Respuesta AJAX:", data);

        const modalHtml = `
            <div class="modal fade" id="modalOficiodeNotificacionAgregarTexto${id_solicitud_fk}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Notificación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="generarTextoNotificacion${id_solicitud_fk}" enctype="multipart/form-data" target="_blank" onsubmit="return validarFormularioSolicitud(${id_solicitud_fk}, 'NOTIFICACION')">
                                <input type="hidden" name="_token" value="${csrfToken}">
                                <div class="form-group">
                                    <label for="observaciones">Texto Adicional</label>
                                    <textarea id="simplemde-notificacion-${id_solicitud_fk}" class="form-control" name="textoAdicional" rows="3">${data.notificacion?.texto || ''}</textarea>
                                    <input type="hidden" id="hidden-html-notificacion-${id_solicitud_fk}" name="normativa_html">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Generar oficio de notificación</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        const modalElement = document.getElementById(`modalOficiodeNotificacionAgregarTexto${id_solicitud_fk}`);
        const modal = new bootstrap.Modal(modalElement);
        modal.show();

        // Configurar SimpleMDE al mostrar el modal
        modalElement.addEventListener('shown.bs.modal', function () {
            const textarea = document.getElementById(`simplemde-notificacion-${id_solicitud_fk}`);
            if (textarea && !textarea.simpleMDE) {
                const simpleMDE = new SimpleMDE({ element: textarea });
                textarea.simpleMDE = simpleMDE;
            }
        });

        modalElement.addEventListener('hidden.bs.modal', function () {
            modalElement.remove();
        });
    })
    .catch(error => {
        console.error("Error en la petición AJAX:", error);
    });
}

function loadTextoAdicional(id_solicitud, tipo) {
    const overlay = document.getElementById('overlay');
    const loader = document.getElementById('loader');

    overlay.style.display = 'block';
    loader.style.display = 'block';

    $.ajax({
        url: `/oficio/${id_solicitud}/${tipo}`,
        method: 'GET',
        success: function(data) {
            const modalSelectors = {
                'OPINION NORMATIVA': '#modalOpinionNormativa' + id_solicitud,
                'SOLICITUD CANCELACION': '#modalCancelarSolicitud' + id_solicitud,
                'CANCELACION': '#modalCancelarFinal' + id_solicitud,
                'NOTIFICACION': '#modalOficiodeNotificacionAgregarTexto' + id_solicitud
            };

            const textFields = {
                'OPINION NORMATIVA': { selector: 'textarea[name="textoAdicional"]', value: data.texto },
                'SOLICITUD CANCELACION': [
                    { selector: 'input[name="noficioExterno"]', value: data.numero_oficio },
                    { selector: 'textarea[name="textoAdicionalCancelado"]', value: data.texto }
                ],
                'CANCELACION': { selector: 'textarea[name="textoAdicionalCanceladoFinal"]', value: data.texto },
                'NOTIFICACION': { selector: 'textarea[name="textoAdicional"]', value: data.texto }
            };

            const modal = $(modalSelectors[tipo]);
            if (modal) {
                const fields = Array.isArray(textFields[tipo]) ? textFields[tipo] : [textFields[tipo]];
                fields.forEach(field => {
                    modal.find(field.selector).val(field.value);
                });
                modal.modal('show');
            }

            overlay.style.display = 'none';
            loader.style.display = 'none';
        },
        error: function() {
            overlay.style.display = 'none';
            loader.style.display = 'none';
        }
    });
}

// Inicializar el editor SimpleMDE con turndown
document.addEventListener('DOMContentLoaded', function() {
    var turndownService = new TurndownService();
    document.querySelectorAll('.modal').forEach(function(modal) {
        modal.addEventListener('shown.bs.modal', function(event) {
            var textareas = modal.querySelectorAll('textarea[id^="simplemde-"]');
            textareas.forEach(function(textarea) {
                if (textarea && !textarea.simpleMDE) {
                    var simpleMDE = new SimpleMDE({ element: textarea });
                    var htmlContent = textarea.value;
                    if (htmlContent) {
                        var markdownContent = turndownService.turndown(htmlContent);
                        simpleMDE.value(markdownContent);
                    }
                    textarea.simpleMDE = simpleMDE;
                }
            });
        });
    });
});



