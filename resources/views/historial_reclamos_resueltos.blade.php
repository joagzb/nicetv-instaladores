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
                    <!-- USER DATA-->
                    <div class="user-data m-b-20 rounded-top uk-border-rounded">
                        <h3 class="title-3">
                            <i class="zmdi zmdi-time uk-margin-bottom"></i>Historial de reclamos atendidos</h3>
                        <form action="{{route('exportHistorial')}}" method="post">
                            @csrf
                            <div class="container-fluid uk-grid-small uk-child-width-1-2@l uk-margin-bottom" uk-grid>
                                <div>
                                    <div uk-grid>
                                        <div class="rs-select2--light rs-select2--sm uk-width-expand">
                                            <label for="selecctor_periodo">Filtrar por fecha de reclamo:</label>
                                            <select class="js-select2" id="selector_periodo1"
                                                    onchange="filtrar_fecha()">
                                                <option value="0" selected="selected">Todo</option>
                                                <option value="1">Semana</option>
                                                <option value="2">Mes</option>
                                                <option value="3">3 Meses</option>
                                            </select>
                                            <div class="dropDownSelect2"></div>
                                        </div>
                                        <input type="hidden" id="input_selector_periodo1"
                                               value="{{\Carbon\Carbon::create(1990,1,1)->toDate()->format('Ymd')}}"
                                               name="fecha_desde">
                                    </div>
                                </div>
                                <div>
                                    <div uk-grid>
                                        <div class="rs-select2--light rs-select2--sm uk-width-expand">
                                            <label for="selecctor_periodo">&nbsp;</label>
                                            <button type="submit" name="modo_exportacion" value="historico"
                                                    class="btn btn-outline-success btn-block "
                                            >
                                                EXPORTAR RESUMEN
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive table-hover table-data">
                            <table class="table table-sm" id="myTable1">
                                <thead>
                                <tr>
                                    <td>Fecha de reclamo</td>
                                    <td>Fecha resuelto</td>
                                    <td>Abonado</td>
                                    <td>Localidad</td>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($historial_reclamos as $reclamo)
                                    <tr class="click-focus" onclick="window.location='{{ route('showDetalleHistorial',
                                    ['idreclamo'=>encrypt($reclamo->id)]) }}'">
                                        <td>
                                            {{$reclamo->fecha_reclamo}}
                                        </td>
                                        <td>
                                            {{$reclamo->fecha_operacion}}
                                        </td>
                                        <td>
                                            <div class="table-data__info">
                                                <h6>{{$reclamo->cliente_nroabonado}} - {{$reclamo->nombre_apellido_abonado}}
                                                </h6>
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
                    </div>
                    <!-- END USER DATA-->
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
{{--  FILTRADO DE DATOS  --}}
    <script>
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
@endsection
