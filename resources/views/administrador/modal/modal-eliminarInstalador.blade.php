<div id="modal-eliminarInstalador" uk-modal>
    <div class="uk-modal-dialog">
        <form method="post" action="{{route('eliminarInstalador')}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Eliminar Instalador del sistema</h2>
            </div>
            <div class="uk-modal-body">
                <p>Usted está a punto de eliminar al instalador: <span id="textoModalEliminarCobrador"
                                                                       class="uk-text-italic uk-text-uppercase"></span>
                </p>
                <p><strong>Para continuar escriba "Eliminar" en el cuadro de abajo</strong></p>
                <div class="uk-margin">
                    <input onkeyup="validar_eliminarInstalador()" class="uk-input uk-form-width-large"
                           id="input_confirmar" type="text">
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-danger" id="boton_eliminar_instalador" name="id_instalador"
                        type="submit" style="display: none;">Eliminar
                </button>
            </div>
        </form>
    </div>
</div>

@if (\App\Models\admin::getCurrentAdmin()->nivel!=1)
    <script>
        function validar_eliminarInstalador() {
            let boton_continuar = document.getElementById('boton_eliminar_instalador');
            let input_campoValidacion = document.getElementById('input_confirmar');
            if (input_campoValidacion.value.toUpperCase() == 'ELIMINAR') {
                boton_continuar.style.display = 'inline-block';
            } else {
                boton_continuar.style.display = 'none';
            }
        }
    </script>
@endif
