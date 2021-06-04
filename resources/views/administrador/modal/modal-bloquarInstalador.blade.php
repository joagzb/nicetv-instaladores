<div id="modal-bloquearInstalador" uk-modal>
    <div class="uk-modal-dialog">
        <form method="post" action="{{route('bloquearInstalador')}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Bloquear Instalador</h2>
            </div>
            <div class="uk-modal-body">
                <p>Usted está a punto de bloquear al instalador: <span id="textoModalBloquearInstalador" class="uk-text-italic uk-text-uppercase"></span> </p>
                <p><strong>Para continuar escriba "Bloquear" en el cuadro de abajo</strong></p>
                <div class="uk-margin">
                    <input onkeyup="validar_bloquearInstalador()" class="uk-input uk-form-width-large" id="input_validar_bloqueo" type="text">
                </div>
            </div>
            <input id="input_idinstalador" name="id_instalador" type="hidden">
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-danger" id="boton_bloquear_cobrador" type="submit" style="display: none;">Bloquear</button>
            </div>
        </form>
    </div>
</div>


<script>
    function validar_bloquearInstalador() {
        let boton_continuar = document.getElementById('boton_bloquear_cobrador');
        let input_campoValidacion = document.getElementById('input_validar_bloqueo');
        if (input_campoValidacion.value.toUpperCase() == 'BLOQUEAR') {
            boton_continuar.style.display = 'inline-block';
        } else {
            boton_continuar.style.display = 'none';
        }
    }
</script>
