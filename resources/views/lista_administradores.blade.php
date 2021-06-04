@extends(\Illuminate\Support\Facades\Auth::user()->userRole()=='admin' ? 'layouts.esqueletoAdmin':'layouts.esqueletoInstalador')

@section('estilos')
@endsection

@section('body')
    <!-- VENTANA EMERGENTE MODAL ELIMINAR COBRADOR -->
    @if (\Illuminate\Support\Facades\Auth::user()->userRole() == \App\Models\User::USER_ADMIN_TYPE)
        @if (\App\Models\admin::getCurrentAdmin()->nivel==3)
            @include('administrador.modal.modal-eliminarAdministrador')
        @endif
    @endif
    <!-- FIN VENTANA EMERGENTE MODAL ELIMINAR COBRADOR -->

    <section class="section__content section__content--p30 uk-margin-top">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- USER DATA-->
                    <div class="user-data m-b-20 rounded-top uk-border-rounded">
                        <h3 class="title-3">
                            <i class="zmdi zmdi-seat"></i>Administradores</h3>
                        <div class="table-data__tool container">
                            <div class="table-data__tool-left">
                                @if (\Illuminate\Support\Facades\Auth::user()->userRole() == \App\Models\User::USER_ADMIN_TYPE)
                                    @if (\App\Models\admin::getCurrentAdmin()->nivel==3)
                                        <label for="boton_nuevo_cobrador">&nbsp;</label>
                                        <a href="{{route('showCreateAdminForm')}}"
                                           class="btn btn-success btn-block"
                                           id="boton_nuevo_cobrador">
                                            <i class="fa fa-plus-circle"></i>&nbsp; Crear nuevo Administrador
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row p-4">
                            @foreach ($lista_admins as $admin)
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{$admin['name']}}</h5>
                                            @switch($admin['lvl'])
                                                @case(1)
                                            <p>
                                                <span class="text-info
                                                    "><strong>Rol:</strong>Controlador</span></p>
                                                @break
                                                @case(2)
                                                <p><span class="text-warning"><strong>Rol:</strong> Gestor</span></p>
                                                @break
                                                @case(3)
                                                <p><span class="text-danger"><strong>Rol:</strong> Super
                                                    Usuario</span></p>
                                                @break
                                            @endswitch
                                            @if (\Illuminate\Support\Facades\Auth::user()->userRole() == \App\Models\User::USER_ADMIN_TYPE)
                                                @if (\App\Models\admin::getCurrentAdmin()->nivel==3)
                                                    <p><span><strong>Fecha
                                                            de alta:</strong>{{substr($admin['created_at'],0,
                                                            10)}}</span></p>
                                                <br>
                                                    <div class="table-data-feature justify-content-center">
                                                            <form class="px-1"
                                                                  action="{{route('showEditarAdmin',['admin_id'=>$admin['id']])}}"
                                                                  method="get">
                                                            @csrf
                                                                <button class="item"
                                                                        type="submit"
                                                                        data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title=""
                                                                        data-original-title="Editar">
                                                                <i class="zmdi zmdi-edit"></i>
                                                            </button>
                                                        </form>
                                                            <button onclick="modalBorrarAdministrador('{{$admin['name']}}','{{$admin['id']}}')"
                                                                    class="item px-1"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    data-original-title="Eliminar">
                                                            <i class="zmdi zmdi-delete"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- END USER DATA-->
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    @if (\Illuminate\Support\Facades\Auth::user()->userRole() == \App\Models\User::USER_ADMIN_TYPE)
        @if (\App\Models\admin::getCurrentAdmin()->nivel==3)
            {{-- mostrar modal para eliminar un cobrador  --}}
            <script>
                function modalBorrarAdministrador(nombre, idadmin) {
                    let modal_eliminarAdministrador = document.getElementById("modal-eliminarAdministrador");
                    let texto = document.getElementById('textoModalEliminarAdministrador');
                    texto.innerText = nombre;
                    document.getElementById('boton_eliminar_admin').value = idadmin;
                    UIkit.modal(modal_eliminarAdministrador).show();
                }
            </script>
            {{--  FIN mostrar modal para eliminar un cobrador --}}

            {{--  activar el boton "eliminar cobrador" en el modal  --}}
            <script>
                function validar_eliminar() {
                    let boton_continuar = document.getElementById('boton_eliminar_admin');
                    let input_campoValidacion = document.getElementById('input_confirmar');
                    if (input_campoValidacion.value.toUpperCase() === 'ELIMINAR') {
                        boton_continuar.style.display = 'inline-block';
                    } else {
                        boton_continuar.style.display = 'none';
                    }
                }
            </script>
            {{-- FIN activar el boton "eliminar cobrador" en el modal  --}}

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
                        UIkit.notification('{{$error}}', {
                            status: 'danger',
                            pos: 'top-right',
                            timeout: 7000
                        });
                    </script>
                @endforeach
            @endif
            {{--    FIN MENSAJE DE ERROR  --}}
        @endif
    @endif

@endsection
