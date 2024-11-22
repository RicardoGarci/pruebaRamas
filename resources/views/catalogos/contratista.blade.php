<x-app-layout>
    <x-slot name="header">
        {{ __('Catalogo de Contratistas') }}
    </x-slot>
                    <!-- Botón para agregar contratista -->
                    <div class="d-flex justify-content-end mb-4">
                            <button type="button"  data-bs-toggle="modal"
                                data-bs-target="#modalAgregarEnte" title="Agregar Contratista" 
                                class="btn btn-svg" style="">Agregar Contratista
                            </button>
                    </div>
                    <!-- Tabla de contratista -->
                    <table id="state-saving-datatable" class="table activate-select dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Contratista</th>
                                <th>Modulos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>

                    </table>

                    <!-- Modal para agregar CONTRATISTA -->
                    <x-modal id="modalAgregarEnte" title="Agregar Ente Público">
                        <form method="POST" action="">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nombre <small class="text-danger">*</small></label>
                                <input name="txtNombreLargo"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" type="text"
                                    class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomenclatura</label>
                                <input name="txtNombreCorto" type="text"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Cargo Público</label>
                                <input name="txtPuesto" type="text"
                                    placeholder="Ej: Director General, Secretario, etc." class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipo De Entidad <small class="text-danger">*</small></label>
                                <select name="slcTipoEnte" class="form-select">
                                    <option selected>Seleccione una opción</option>
                                    <option value="ENTIDAD">ENTIDAD/DEPENDENCIA</option>
                                    <option value="MUNICIPIO">MUNICIPIO</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Modulo <small class="text-danger">*</small></label>
                                <select name="slcDepartamento[]" id="slcDepartamentoAgregar" class="form-control"
                                    multiple>
                                 {{--    @foreach ($departamento as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->nombre }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary">Agregar</button>
                            </div>
                        </form>
                    </x-modal>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const eliminarButtons = document.querySelectorAll('.eliminar-button-ente');

            eliminarButtons.forEach(function(eliminarButton) {
                eliminarButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: 'Esta acción eliminará el registro. ¿Deseas continuar?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            eliminarButton.parentElement.submit();
                        }
                    });
                });
            });
        });
    </script>
</x-app-layout>
