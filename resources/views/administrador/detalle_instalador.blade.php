@extends('layouts.esqueletoAdmin')

@section('estilos')
    <style>
        .tab-title {
            font-size: 18px;
        }

        .dark-table-header {
            background-color: #0d1c29;
            color: floralwhite;
        }

        .uk-card-nicetv {
            background-color: #001C33;
            color: white;
        }

        .click-focus{
            cursor: pointer;
        }
    </style>
@endsection

@section('body')
    <div class="section__content section__content--p30 uk-margin-top">
        <div class="container-fluid">
            <button type="button"
                    id="boton_volver"
                    class="btn btn-warning btn m-b-15">
                <i class="fa fa-arrow-left"></i> Volver al Listado
            </button>
            <div class="row uk-margin-top">
                <div class="col-12">
                    <div class="user-data rounded-top uk-border-rounded">
                        <ul class="container uk-margin-small uk-flex-center"
                            uk-tab="animation:uk-animation-fade">
                            <li><a href="#"><span class="tab-title"><i class="zmdi zmdi-account"></i>
                                            Detalles del usuario</span></a></li>
                            <li><a href="#"><span class="tab-title"><i class="zmdi zmdi-time-restore"></i>
                                        Reclamos solucionados</span></a></li>
                        </ul>
                        <ul class="uk-switcher uk-margin">

                            <li>
                                <div class="uk-child-width-1-2@l uk-grid-match uk-container col col-12"
                                     uk-grid>
                                    <div>
                                        <div class="uk-card uk-card-small uk-card-nicetv uk-card-body uk-light">
                                            <h3 class="uk-card-title uk-text-normal">Alta de usuario</h3>
                                            <p><u>Fecha de alta de usuario:</u></p>
                                            <p class="text-center uk-text-meta"> {{ substr($detalle_instalador->created_at,0,10) }}</p>
                                            <p><u>Administrador responsable del alta:</u></p>
                                            <p class="text-center uk-text-meta">
                                                {{$detalle_instalador->admin_responsable->name}}
                                                - {{$detalle_instalador->admin_responsable->email}}
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="uk-card uk-card-small uk-card-nicetv uk-card-body uk-light">
                                            <h3 class="uk-card-title uk-text-normal">Datos personales</h3>
                                            <p><u>Nombre:</u></p>
                                            <p class="text-center uk-text-meta"> {{ $detalle_instalador->usuario->name }}</p>
                                            <p><u>Email:</u></p>
                                            <p class="text-center uk-text-meta"> {{ $detalle_instalador->usuario->email }}</p>
                                            <p><u>Telefono:</u></p>
                                            <p class="text-center uk-text-meta"> {{ $detalle_instalador->usuario->telefono }}</p>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="filters m-b-45">
                                    <div class="container-fluid uk-grid-small uk-child-width-1-2@l uk-margin-bottom"
                                         uk-grid>
                                        <div>
                                            <label for="selector_modo_filtro">Filtrar resultados por:</label>
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false"
                                                                value="0"
                                                                id="modo_filtro"
                                                                class="dropdown-toggle btn
                                                            btn-outline-secondary">Nro. Abonado
                                                        </button>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       id="input_filtro"
                                                       onkeyup="filtrarDatos()"
                                                       class="form-control uk-width-1-2">
                                            </div>
                                        </div>
                                        <form
                                            action="{{route('HistoricToCSV',['instalador_id'=>\Illuminate\Support\Facades\Route::current()->parameters()['instalador_id']])}}"
                                            method="post">
                                            @csrf
                                            <div>
                                                <div uk-grid>
                                                    <div class="rs-select2--light rs-select2--sm uk-width-expand">
                                                        <label for="selecctor_periodo">Filtrar por fecha de reclamo:</label>
                                                        <select class="js-select2"
                                                                id="selector_periodo1"
                                                                onchange="filtrar_fecha()">
                                                            <option value="0"
                                                                    selected="selected">Todo
                                                            </option>
                                                            <option value="1">Semana</option>
                                                            <option value="2">Mes</option>
                                                            <option value="3">3 Meses</option>
                                                        </select>
                                                        <div class="dropDownSelect2"></div>
                                                    </div>
                                                    <input type="hidden"
                                                           id="input_selector_periodo1"
                                                           value="{{\Carbon\Carbon::create(1990,1,1)->toDate()->format('Ymd')}}"
                                                           name="fecha_desde">
                                                </div>
                                            </div>
                                            <div>
                                                <br>
                                                <button type="submit"
                                                        name="modo_exportacion"
                                                        value="historico"
                                                        class="btn btn-success btn-block uk-width-expand ">
                                                    <i class="fa fa-magic"></i>&nbsp; EXPORTAR ESTA TABLA
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive text-center">
                                    <table class="table table table-hover"
                                           id="myTable">
                                        <thead class="dark-table-header uk-text-bolder">
                                        <tr>
                                            <th>Fecha de reclamo</th>
                                            <th>Fecha resuelto</th>
                                            <th># Abonado</th>
                                            <th>Cliente</th>
                                            <th>Localidad</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($detalle_instalador->historial_reclamos_atendidos as $reclamo)
                                            <tr class="click-focus" onclick="window.location='{{ route('showDetalleReclamoAdmin',['idreclamo'=>$reclamo->id_reclamo]) }}'">
                                                <td>
                                                    {{$reclamo->fecha_reclamo}}
                                                </td>
                                                <td>
                                                    {{$reclamo->fecha_operacion}}
                                                </td>
                                                <td>
                                                    {{$reclamo->cliente_nroabonado}}
                                                </td>
                                                <td>
                                                    <div class="table-data__info">
                                                        <h6>{{$reclamo->nombre_apellido_abonado}}</h6>
                                                        <span>
                                                <a href="#">motivo: {{$reclamo->motivo}}</a>
                                            </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$reclamo->Localidad}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        /*
        * volver a la pagina anterior si se hace click sobre el boton "cancelar"
        * */
        document.getElementById('boton_volver').onclick = () => {
            window.history.go(-1);
        }
    </script>

    {{--  FILTOS DEL PANEL DE COBRANZAS  --}}

    <script>
        /*
        * filtrar los datos segun dni o codigo de cuenta
        * */
        function filtrarDatos() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("input_filtro");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            tipo_filtro = document.getElementById("modo_filtro");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td_codigo_cuenta = tr[i].getElementsByTagName("td")[2];
                if (filter) {
                    if (td_codigo_cuenta) {
                        if (tipo_filtro.value == 0) {
                            txtValue_codigo_cuenta = td_codigo_cuenta.textContent || td_codigo_cuenta.innerText;
                            txtValue_codigo_cuenta = txtValue_codigo_cuenta.trim().toUpperCase();
                            if (txtValue_codigo_cuenta.includes(filter)) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                    }
                } else {
                    tr[i].style.display = "";
                }
            }
        }

        /*
        * filtrar los resultados de la tabla por periodos
        * */
        function filtrar_fecha() {
            let modo_filtro = document.getElementById("selector_periodo1").value;
            let from;
            let to = formatDate(Date.now());
            switch (modo_filtro) {
                case "1":
                    from = formatDate(new Date().setDate(new Date().getDate() - 7));
                    break;
                case "2":
                    from = formatDate(new Date(new Date().getFullYear(), new Date().getMonth(), 1));
                    break;
                case "3":
                    from = formatDate(new Date().setDate(new Date().getDate() - 90));
                    break;
                default:
                    from = '1970-01-01';
                    to = '2999-12-31';
                    break;
            }

            if (!from && !to) { // no value for from and to
                return;
            }

            document.getElementById('input_selector_periodo1').value = from;

            from = from || '1970-01-01'; // default from to a old date if it is not set
            to = to || '2999-12-31';

            var dateFrom = moment(from);
            var dateTo = moment(to);

            $('#myTable tbody tr').each(function (i, tr) {
                var val = $(tr).find("td:nth-child(2)").text();
                var dateVal = moment(val, "YYYY/MM/DD");
                var visible = (dateVal.isBetween(dateFrom, dateTo, null, [])) ? "" : "none"; // [] for inclusive
                $(tr).css('display', visible);
            });
        }

        /*
        * convierte una fecha en milisegundos a formato YYYY-MM-DD
        * */
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [year, month, day].join('-');
        }
    </script>
    {{--  END FILTOS DEL PANEL DE COBRANZAS  --}}
@endsection
