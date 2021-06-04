@extends('layouts.esqueletoAdmin')

@section('estilos')
    <style>
        .dark-table-header {
            background-color: #0d1c29;
            color: floralwhite;
        }
    </style>
@endsection

@section('body')
    <!-- VENTANA EMERGENTE MODAL ELIMINAR INSTALADOR -->
    @if (\App\Models\admin::getCurrentAdmin()->nivel!=1)
        @include('administrador.modal.modal-eliminarInstalador')
    @endif
    <!-- FIN VENTANA EMERGENTE MODAL ELIMINAR INSTALADOR -->
    <!-- VENTANA EMERGENTE MODAL BLOQUEAR INSTALADOR -->
    @include('administrador.modal.modal-bloquarInstalador')
    <!-- FIN VENTANA EMERGENTE MODAL BLOQUEAR INSTALADOR -->

    <section class="section__content section__content--p30 uk-margin-top">
        <div class="user-data m-b-30">
            <h3 class="title-3">
                <i class="zmdi zmdi-account-calendar"></i>Instaladores</h3>
            <div class="table-data__tool container-fluid">
                <div class="table-data__tool-left">
                    <label for="boton_nuevo_cobrador">&nbsp;</label>
                    <a href="{{route('showCreateInstaladorOptions',['option'=>'wrapper'])}}" class="btn
                    btn-success
                    btn-block"
                       id="boton_nuevo_cobrador">
                        <i class="fa fa-plus-circle"></i> Crear nuevo Instalador
                    </a>
                </div>
                <div class="table-data__tool-right">
                    <div class="row form-group">
                        <div class="col col-md-12">
                            <label for="filtro_busqueda_cobrador">filtrar por:</label>
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <div class="btn-group">
                                        <button type="button" id="boton_opcion_filtro" value="0"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                class="dropdown-toggle btn btn-outline-secondary">nombre
                                        </button>
                                        <div tabindex="-1" aria-hidden="true" role="menu" class="dropdown-menu">
                                            <button onclick="onFiltroItemClick(0,'nombre')" type="button"
                                                    tabindex="0" class="dropdown-item">nombre
                                            </button>
                                            <button onclick="onFiltroItemClick(1,'email')" type="button"
                                                    tabindex="1" class="dropdown-item">email
                                            </button>
                                            <button onclick="onFiltroItemClick(2,'telefono')" type="button"
                                                    tabindex="2" class="dropdown-item">teléfono
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <input type="text" onkeyup="filtrarDatos()" id="input_filtro" placeholder=".."
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-table-responsive">
                <table class="table text-center" id="myTable">
                    <thead class="dark-table-header uk-text-bolder">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($lista_instaladores as $instalador)
                        <tr class="tr-shadow">
                            <td>
                                <div class="table-data__info">
                                    <h6>{{$instalador->name}}</h6>
                                    @if ($instalador->habilitado==0)
                                        <span class="uk-label uk-label-warning">bloqueado</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="block-email">{{$instalador->email}}</span>
                            </td>
                            <td><span class="block-email">{{$instalador->telefono}}</span></td>
                            <td>
                                <div class="table-data-feature justify-content-center">
                                    <form
                                        action="{{route('showDetailInstalador',['instalador_id'=>$instalador->id])}}"
                                        method="get">
                                        @csrf
                                        <button class="item" type="submit"
                                                data-toggle="tooltip"
                                                data-placement="top" title=""
                                                data-original-title="Más detalles sobre este usuario">
                                            <i class="zmdi zmdi-alert-circle"></i>
                                        </button>
                                    </form>
                                    @if (\App\Models\admin::getCurrentAdmin()->nivel!=1)
                                        <form class="px-1"
                                              action="{{route('showEditarInstalador',['instalador_id'=>$instalador->id])}}"
                                              method="get">
                                            @csrf
                                            <button class="item" type="submit"
                                                    data-toggle="tooltip"
                                                    data-placement="top" title=""
                                                    data-original-title="Editar este usuario">
                                                <i class="zmdi zmdi-edit"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if ($instalador->habilitado==1)
                                        <button
                                            onclick="modalBloquearInstalador('{{$instalador->name}}','{{$instalador->id}}')"
                                            class="item px-1" data-toggle="tooltip" data-placement="top" title=""
                                            data-original-title="bloquear">
                                            <i class="zmdi zmdi-block"></i>
                                        </button>
                                    @else
                                        <form action="{{route('bloquearInstalador')}}" method="post" class="px-1">
                                            @csrf
                                            <button
                                                type="submit"
                                                name="id_instalador" value="{{$instalador->id}}"
                                                class="item " data-toggle="tooltip" data-placement="top"
                                                title=""
                                                data-original-title="Habilitar">
                                                <i class="zmdi zmdi-case-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    @if (\App\Models\admin::getCurrentAdmin()->nivel!=1)
                                        <button
                                            onclick="modalBorrarInstalador('{{$instalador->name}}','{{$instalador->id}}')"
                                            class="item" data-toggle="tooltip" data-placement="top"
                                            data-original-title="Eliminar">
                                            <i class="zmdi zmdi-delete"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection

@section('scripts')
    {{--  cambiar el valor del filtro de busqueda en base al modo seleccionado  --}}
    <script>
        function onFiltroItemClick(itemNumber, itemName) {
            document.getElementById('boton_opcion_filtro').value = itemNumber;
            document.getElementById('boton_opcion_filtro').innerText = itemName;
        }
    </script>
    {{-- FIN cambiar el valor del filtro de busqueda en base al modo seleccionado  --}}

    {{-- mostrar modal para eliminar un cobrador  --}}
    @if (\App\Models\admin::getCurrentAdmin()->nivel!=1)
        <script>
            function modalBorrarInstalador(nombre, idcobrador) {
                let modal_eliminarCobrador = document.getElementById("modal-eliminarInstalador");
                let texto = document.getElementById('textoModalEliminarCobrador');
                texto.innerText = nombre;
                document.getElementById('boton_eliminar_instalador').value = idcobrador;
                UIkit.modal(modal_eliminarCobrador).show();
            }
        </script>
    @endif
    {{--  FIN mostrar modal para eliminar un cobrador --}}

    {{--  modal bloquear cobrador  --}}
    <script>
        function modalBloquearInstalador(nombre, idcobrador) {
            let modal_bloquearInstalador = document.getElementById("modal-bloquearInstalador");
            let texto = document.getElementById('textoModalBloquearInstalador');
            texto.innerText = nombre;
            document.getElementById('input_idinstalador').value = idcobrador;
            UIkit.modal(modal_bloquearInstalador).show();
        }
    </script>
    {{--  FIN modal bloquear cobrador  --}}

    {{--  script para filtrar datos de tabla segun campo busqueda  --}}
    <script>
        function filtrarDatos() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("input_filtro");
            filter = input.value.toUpperCase();
            table = document.getElementById("myTable");
            tr = table.getElementsByTagName("tr");
            tipo_filtro = document.getElementById("boton_opcion_filtro");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td_nombre = tr[i].getElementsByTagName("td")[0];
                td_email = tr[i].getElementsByTagName("td")[1];
                td_telefono = tr[i].getElementsByTagName("td")[2];
                if (filter) {
                    if (td_nombre || td_email || td_telefono) {
                        if (tipo_filtro.value == 0) {
                            txtValue_nombre = td_nombre.textContent || td_nombre.innerText;
                            txtValue_nombre = txtValue_nombre.trim().toUpperCase();
                            if (txtValue_nombre.includes(filter)) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                        if (tipo_filtro.value == 1) {
                            txtValue_email = td_email.textContent || td_email.innerText;
                            txtValue_email = txtValue_email.trim().toUpperCase();
                            if (txtValue_email.includes(filter)) {
                                tr[i].style.display = "";
                            } else {
                                tr[i].style.display = "none";
                            }
                        }
                        if (tipo_filtro.value == 2) {
                            txtValue_telefono = td_telefono.textContent || td_telefono.innerText;
                            txtValue_telefono = txtValue_telefono.trim().toUpperCase();
                            if (txtValue_telefono.includes(filter)) {
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
    </script>
    {{--  FIN script para filtrar datos de tabla segun campo busqueda  --}}

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
