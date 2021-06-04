<div id="modal-selectCobradorAPI" uk-modal>
    <div class="uk-modal-dialog">
        <form method="get"
              action="{{route('showCreateInstaladorOptions',['option'=>'nuevo'])}}">
            @csrf
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Importar usuario de Plataforma de cobradores</h2>
            </div>
            <div class="uk-modal-body">
                <div class="uk-margin">
                    <div class="form-row mt-4">
                        <div class="col-12 col-sm-12">
                            <label for="input_select_tecnico"
                                   class=" form-control-label">Técnico</label>
                            <select name="userCobrador"
                                    id="input_select_tecnico"
                                    class="form-control fstdropdown-select"
                                    required>
                                <option value="-1">...</option>
                                @foreach($usersCobradores as $tecnico)
                                    <option value="{{ $tecnico['id'] }}">{{$tecnico['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancelar</button>
                <button class="uk-button uk-button-primary" type="submit">Importar</button>
            </div>
        </form>
    </div>
</div>
