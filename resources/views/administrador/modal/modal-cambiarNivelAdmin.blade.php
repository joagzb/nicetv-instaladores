<div id="modal-cambiarNivelAdmin" uk-modal>
    <div class="uk-modal-dialog">
        <form method="post" action="{{route('editarAdmin',['admin_id'=>\Illuminate\Support\Facades\Route::current()->parameters()['admin_id']])}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Cambiar el nivel de autoridad</h2>
            </div>
            <div class="uk-modal-body">
                <p>Usted está a punto de cambiar el nivel de autoridad del administrador: {{\App\Models\User::find(\Illuminate\Support\Facades\Route::current()->parameters()['admin_id'])->name}}<span id="textoModalEliminarCobrador" class="uk-text-italic uk-text-uppercase"></span> </p>
                    <ul>
                        <li><i>nivel 1: controlar los movimientos de los instaladores</i></li>
                        <li><i>nivel 2: crear, modificar y eliminar instaladores</i></li>
                        <li><i>nivel 3: crear y eliminar Administradores</i></li>
                    </ul>
                <div class="uk-margin">
                    <div class="uk-form-label">Seleccione nivel</div>
                    <div class="uk-form-controls">
                        <label><input class="uk-radio" type="radio" name="radio1" value="1"> Nivel 1</label><br>
                        <label><input class="uk-radio" type="radio" name="radio1" value="2"> Nivel 2</label><br>
                        <label><input class="uk-radio" type="radio" name="radio1" value="3"> Nivel 3</label>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-danger" value="2" name="op" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>
