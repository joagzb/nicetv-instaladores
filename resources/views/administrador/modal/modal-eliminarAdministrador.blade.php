<div id="modal-eliminarAdministrador" uk-modal>
    <div class="uk-modal-dialog">
        <form method="post" action="{{route('eliminarAdministrador')}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Eliminar Administrador</h2>
            </div>
            <div class="uk-modal-body">
                <p>Usted está a punto de eliminar al administrador: <span id="textoModalEliminarAdministrador" class="uk-text-italic uk-text-uppercase"></span> </p>
                <p><strong>Para continuar escriba "Eliminar" en el cuadro de abajo</strong></p>
                <div class="uk-margin">
                    <input onkeyup="validar_eliminar()" class="uk-input uk-form-width-large" id="input_confirmar" type="text">
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-danger" id="boton_eliminar_admin" name="id_admin" type="submit" style="display: none;">Eliminar</button>
            </div>
        </form>
    </div>
</div>
