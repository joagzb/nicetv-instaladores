<div id="modal-cambiarDatosinstalador" uk-modal>
    <div class="uk-modal-dialog">
        <form method="post"
              action="{{route('EditarInstalador',['instalador_id'=>\Illuminate\Support\Facades\Route::current()->parameters()['instalador_id']])}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Cambiar datos personales</h2>
            </div>
            <div class="uk-modal-body">
                <p>Usted está a punto de cambiar los datos del usuario instalador: <span
                                                                                       class="uk-text-italic uk-text-uppercase">{{$instalador->usuario->name}}</span>
                </p>
                <div class="uk-margin">
                    <div class="form-group">
                        <label for="input_telefono" class=" form-control-label">Teléfono</label>
                        <input type="tel" id="input_telefono" name="input_telefono" value="{{$instalador->usuario->telefono}}"
                               class="form-control" required>
                        <small class="form-text text-muted">(campo obligatorio) @error('input_telefono')
                            {{ $message }}
                            @enderror</small>
                    </div>
                    <div class="form-group">
                        <label for="email-input" class=" form-control-label">Email</label>
                        <input type="email" id="email-input" name="email-input" value="{{$instalador->usuario->email}}"
                               class="form-control" required>
                        <small class="help-block form-text">(campo obligatorio) @error('email-input')
                            {{ $message }}
                            @enderror</small>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-danger" value="3" name="op" type="submit">Confirmar</button>
            </div>
        </form>
    </div>
</div>
