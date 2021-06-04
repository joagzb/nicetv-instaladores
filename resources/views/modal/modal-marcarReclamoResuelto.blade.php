<div id="modal-marcarReclamoResuelto" uk-modal>
    <div class="uk-modal-dialog">
        <form method="post" action="{{route('post_resolverReclamo',['Arg_idreclamo'=>encrypt($detalle_reclamo->id)])}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Resolver reclamo</h2>
            </div>
            <div class="uk-modal-body">
                <h5>Antes de marcar el reclamo como resuelto, valide los datos de contacto del cliente y escriba un
                    detalle a continuación</h5>
                <div class="uk-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="input_dni" class="control-label mb-1">DNI:</label>
                                <span class="uk-margin-small-top float-right" role="alert">
                                         confirmar DNI <label class="switch switch-3d switch-warning switch-pill">
                                            <input onchange="confirmDNI()" id="check_dni" name="check_dni"
                                                   type="checkbox" class="switch-input">
                                            <span class="switch-label"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </span>
                                <input id="input_dni" name="dni" type="text" class="form-control"
                                       pattern="[0-9]+" minlength="8" maxlength="14"
                                       title="Campo obligatorio. Ingrese solo números"
                                       value="{{$detalle_reclamo->cliente_info->dni}}" required>

                            </div>
                            <div class="form-group">
                                <label for="input_email" class="control-label mb-1">EMAIL:</label>
                                <span class="uk-margin-small-top float-right" role="alert">
                                        confirmar EMAIL <label class="switch switch-3d switch-warning switch-pill">
                                            <input onchange="confirmEMAIL()" id="check_email" name="check_email"
                                                   type="checkbox" class="switch-input">
                                            <span class="switch-label"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </span>
                                <input id="input_email" name="email" type="email" class="form-control"
                                       minlength="4" maxlength="80"
                                       value="{{$detalle_reclamo->cliente_info->mail}}" required>
                            </div>
                            <div class="form-group">
                                <label for="input_telefono" class="control-label mb-1">TELÉFONO:</label>
                                <span class="uk-margin-small-top float-right" role="alert">
                                        confirmar TELÉFONO <label class="switch switch-3d switch-warning switch-pill">
                                            <input onchange="confirmTELEFONO()" id="check_telefono"
                                                   name="check_telefono" type="checkbox" class="switch-input">
                                            <span class="switch-label"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </span>
                                <input id="input_telefono" name="telefono" type="tel" class="form-control"
                                       pattern="[0-9]+" minlength="6" maxlength="16"
                                       value="{{$detalle_reclamo->cliente_info->telefono}}"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="input_detalle" class="control-label mb-1">motivo del
                                    problema:</label>
                                <textarea class="uk-textarea" name="detalle" id="input_detalle" rows="2"
                                          maxlength="80" required></textarea>
                            </div>
                            <div>
                                <button id="payment-button" type="submit" class="btn btn-lg btn-info btn-block"
                                        disabled="">
                                    <i class="fa fa-lock fa-lg"></i>&nbsp;
                                    <span id="payment-button-amount">RESOLVER</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
            </div>
        </form>
    </div>
</div>


<script>
    /*
    * confirmar los campos DNI,EMAIL y TELEFONO con el Switch
    * */
    function confirmDNI() {
        let input_dni = document.getElementById('input_dni');
        if (document.getElementById('check_dni').checked === true) {
            input_dni.readOnly = true;
        } else {
            input_dni.readOnly = false;
        }
        checks_verified();
    }

    function confirmEMAIL() {
        let input_email = document.getElementById('input_email');
        if (document.getElementById('check_email').checked === true) {
            input_email.readOnly = true;
        } else {
            input_email.readOnly = false;
        }
        checks_verified();
    }

    function confirmTELEFONO() {
        let input_telefono = document.getElementById('input_telefono');
        if (document.getElementById('check_telefono').checked === true) {
            input_telefono.readOnly = true;
        } else {
            input_telefono.readOnly = false;
        }
        checks_verified();
    }

    /*
    * verifica que todos los campos estas marcados como correctos
    * */
    function checks_verified() {
        let button_pay = document.getElementById('payment-button');
        let check_telefono = document.getElementById('check_telefono');
        let check_email = document.getElementById('check_email');
        let check_dni = document.getElementById('check_dni');

        if (check_dni.checked === true && check_email.checked === true && check_telefono.checked === true) {
            button_pay.disabled = false;
        } else {
            button_pay.disabled = true;
        }
    }
</script>
