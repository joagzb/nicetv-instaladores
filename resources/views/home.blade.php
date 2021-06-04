@extends('layouts.esqueletoInstalador')

@section('estilos')
    <link href="{{ asset('css/cobrador_estilos_home.css') }}"
          rel="stylesheet"
          media="all">
@endsection

@section('body')
    <div class="container-fluid">
        <section class="section__content section__content--p30">
                <div class="row uk-margin-top">
                    <div class="col-12">
                        @if($habilitado)
                        <div class="user-data rounded-top uk-border-rounded">
                            <ul class="container uk-margin-small uk-flex-center"
                                uk-tab="animation:uk-animation-fade">
                                <li><a href="#"><span class="tab-title"><i class="zmdi zmdi-fire"></i>
                                            Prioridad</span></a></li>
                                <li><a href="#"><span class="tab-title">Reclamos pendientes</span></a></li>
                            </ul>
                            <ul class="uk-switcher uk-margin">
                                <li>
                                    <div class="table-responsive uk-margin-top">
                                        <table class="table table-sm table-hover table-earning">
                                            <thead>
                                            <tr>
                                                <th>Fecha de reclamo</th>
                                                <th>Abonado</th>
                                                <th>Localidad</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($reclamos_prioridad as $reclamo)
                                                <tr class="click-focus" onclick="window.location='{{ route
                                                ('showDetalleReclamo',['Arg_idreclamo'=>encrypt($reclamo->id)]) }}'">
                                                    <td>{{$reclamo->fechareclamo}}</td>
                                                    <td>{{$reclamo->idabonado}}</td>
                                                    <td>
                                                        @if (isset($reclamo->localidad))
                                                            {{$reclamo->localidad->padre}} - {{$reclamo->localidad->ciudad}}
                                                        @else
                                                            no definido
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                                <li>
                                    <div class="container-fluid uk-grid-small uk-child-width-1-3@l uk-margin-top uk-margin-bottom"
                                         uk-grid>
                                        <div>
                                            <label for="selector_modo_filtro">Buscar por:</label>
                                            <div class="input-group">
                                                <div class="input-group-btn">
                                                    <div class="btn-group">
                                                        <button type="button"
                                                                data-toggle="dropdown"
                                                                aria-haspopup="true"
                                                                aria-expanded="false"
                                                                value="0"
                                                                id="boton_opcion_filtro1"
                                                                class="dropdown-toggle btn
                                                                    btn-outline-secondary">Abonado
                                                        </button>
                                                    </div>
                                                </div>
                                                <input type="text"
                                                       id="input_filtro1"
                                                       onkeyup="filtrarDatos()"
                                                       class="form-control uk-width-1-2">
                                            </div>
                                        </div>
                                        <form method="post"
                                              action="">
                                            @csrf
                                            <div>
                                                <div uk-grid>
                                                    <div class="rs-select2--light rs-select2--sm uk-width-expand">
                                                        <label for="selecctor_periodo">Filtrar por fecha de reclamo:</label>
                                                        <select class="js-select2"
                                                                id="selector_periodo1"
                                                                onchange="filtrar_fecha()">
                                                            <option value="0"
                                                                    selected="selected">Todo</option>
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
                                        </form>
                                        <form method="post"
                                              action="">
                                            @csrf
                                            <div>
                                                <div uk-grid>
                                                    <div class="rs-select2--light rs-select2--sm uk-width-expand">
                                                        <label for="selecctor_periodo">Filtrar por localidad:</label>
                                                        <select class="js-select2"
                                                                id="selector_localidad"
                                                                onchange="filtrarDatosLocalidad()">
                                                            <option value="0"
                                                                    selected="selected">..</option>
                                                            <option value="no definido">no definido</option>
                                                            @foreach($localidades as $localidad)
                                                                <option value="{{$localidad}}">{{$localidad}}</option>
                                                            @endforeach
                                                        </select>
                                                        <div class="dropDownSelect2"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="table-responsive table-data">
                                        <table id="myTable1"
                                               class="table table-sm table-hover table-earning">
                                            <thead>
                                            <tr>
                                                <th>Fecha de reclamo</th>
                                                <th>Abonado</th>
                                                <th>Localidad</th>
                                                <th>Provincia</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($reclamos as $reclamo)
                                                <tr class="click-focus" onclick="window.location='{{ route
                                                ('showDetalleReclamo',['Arg_idreclamo'=>encrypt($reclamo->id)]) }}'">
                                                    <td>{{$reclamo->fechareclamo}}</td>
                                                    <td>{{$reclamo->idabonado}}</td>
                                                    <td>
                                                        @if (isset($reclamo->localidad))
                                                            {{$reclamo->localidad->padre}}
                                                        @else
                                                            no definido
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($reclamo->localidad))
                                                            {{$reclamo->localidad->ciudad}}
                                                        @else
                                                            no definido
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </li>
                            </ul>

                        </div>

                        @else
                            <div class="user-data rounded-top uk-border-rounded">
                                <div class="container uk-padding text-center">
                                    <h4>Su cuenta no se encuentra habilitada para continuar operando.
                                        Comuniquese con un administrador y resuelva su situación.</h4>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{--  FILTRO DE DATOS  --}}
    <script>
        /*
        * filtrar los datos segun dni o codigo de cuenta
        * */
        function filtrarDatos() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("input_filtro1");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable1");
            tr = table.getElementsByTagName("tr");
            tipo_filtro = document.getElementById("boton_opcion_filtro1");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td_codigo_cuenta = tr[i].getElementsByTagName("td")[1];
                if (filter) {
                    if (td_codigo_cuenta) {
                        if (tipo_filtro.value == 0) {
                            txtValue_codigo_cuenta = td_codigo_cuenta.textContent || td_codigo_cuenta.innerText;
                            txtValue_codigo_cuenta = txtValue_codigo_cuenta.trim();
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
        * filtrar los datos segun la localidad
        * */
        function filtrarDatosLocalidad() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("selector_localidad");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable1");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td_localidad = tr[i].getElementsByTagName("td")[2];
                if (filter && input.value != 0) {
                    if (td_localidad) {
                        if (input.value != 0) {
                            txtValue_codigo_cuenta = td_localidad.textContent || td_localidad.innerText;
                            txtValue_codigo_cuenta = txtValue_codigo_cuenta.trim().toUpperCase();
                            if (txtValue_codigo_cuenta === filter) {
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

            $('#myTable1 tbody tr').each(function (i, tr) {
                var val = $(tr).find("td:nth-child(1)").text();
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

    {{--     MENSAJE OK  --}}
    @if(\Illuminate\Support\Facades\Session::has('ok'))
        <script>
            UIkit.notification("{{ \Illuminate\Support\Facades\Session::get('ok') }}", {
                status: 'success',
                pos: 'top-right',
                timeout: 3000
            });
        </script>
    @endif
    {{--    FIN MENSAJE OK    --}}
    {{--     MENSAJE DE ERROR  --}}
    @if(\Illuminate\Support\Facades\Session::has('error'))
        <script>
            UIkit.notification('{{ \Illuminate\Support\Facades\Session::get('error')}}', {
                status: 'danger',
                pos: 'top-right',
                timeout: 7000
            });
        </script>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script>
                UIkit.notification('{{ $error }}', {
                    status: 'danger',
                    pos: 'top-right',
                    timeout: 7000
                });
            </script>
        @endforeach
    @endif
    {{--    FIN MENSAJE DE ERROR  --}}
@endsection
