<div id="modal-cambiarContraseñainstalador" uk-modal>
    <div class="uk-modal-dialog">
        <form method="post" action="{{route('EditarInstalador',['instalador_id'=>\Illuminate\Support\Facades\Route::current()->parameters()['instalador_id']])}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Cambiar contraseña</h2>
            </div>
            <div class="uk-modal-body">
                <p>Usted está a punto de cambiar la contraseña del instalador: <span id="textoModalEliminarCobrador" class="uk-text-italic uk-text-uppercase"></span> </p>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Nueva contraseña</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="input_contraseña" type="text" placeholder="..." required>
                    </div>
                </div>
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">Confirme contraseña</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" name="input_confirmar_contraseña" type="text" placeholder="..." required>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-danger" value="1" name="op" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>
