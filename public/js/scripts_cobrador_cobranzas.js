/*
* ENVIAR EL FORMULARIO Y ESPERAR PETICION AJAX DEL ABONADO
* SOLICITADO
* */
function onSubmitSearchAbonado() {
    // variables de control de inputs
    let select_localidad_id = document.getElementById('select_localidad').value;
    let select_modo_busqueda = document.getElementById('input_modo_busqueda').value;
    let input_valor_modo = document.getElementById('input_valor').value;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
        url: '/home/Payment/search',
        data: {
            input_select_localidad: select_localidad_id,
            input_modo_busqueda: select_modo_busqueda,
            input_valor: input_valor_modo
        },
        dataType: 'JSON',
        contentType: "application/json",
        success: function (response_abonado) {

            // ocultar tabla de resultados antes de realizarse la busqueda
            document.getElementById('div_table_cuentas').style.display = "none";
            document.getElementById('div_error_busqueda').style.display = "none";

            // checkear la respuesta del servidor. SI es error, se muestra el mensaje del mismo
            // si NO es error, se muestran los resultados de busqueda que son las deudas del
            //cliente
            if (!response_abonado['error']) {
                let table_deudas = document.getElementById('div_table_cuentas');
                table_deudas.style.display = "block";

                let nombre;
                let apellido;
                let nroabonado;
                $.each(response_abonado['cliente'], function (idx, value) {
                    nombre = value.nombre;
                    apellido = value.apellido;
                    nroabonado = value.nroabonado;
                });

                $.map(response_abonado['cuentas'], function (val, key) {
                    let td = '<tr>';
                    td += '';
                    td += '<input type="hidden" name="input_nroabonado" value="' + nroabonado + '">';
                    td += '<input type="hidden" name="input_cuenta" value="' + val.id + '">';
                    td += '<td>' + nombre + ' ' + apellido + '</td>';
                    td += '<td>' + nroabonado + '</td>';
                    td += '<td> $' + val.total + '</td>';
                    td += '<td>' + getMonthName(val.mes) + ' ' + val.anho + '</td>';
                    td += '<td><form method="get" action="/home/Payment/detail">' +
                        '<input type="hidden" name="asdlkj" value="' + nroabonado + '">' +
                        '<input type="hidden" name="qwepoi" value="' + val.id + '">' +
                        '<button type="submit" class="btn btn-warning btn-sm">\n' +
                        '                                    Cobrar\n' +
                        '                                </button></form></td>';
                    td += '</tr>';
                    $('#cuerpo_tabla_cuentas').append(td);
                });

            } else {
                //mostrar el mensaje de error recibido del servidor
                let div_error = document.getElementById('div_error_busqueda');
                div_error.style.display = "block";
                $.map(response_abonado, function (val, key) {
                    let td = val;
                    $('#id_cuerpo_error').html(td);
                });
            }

            //volver a habilitar el boton de enviar formulario despues de 3 segundos de haber recibido una respuesta del servidor
            setTimeout(function () {
                document.getElementById('form_search_buttonSubmit').disabled = false;
            }, 2500);
        },
        beforeSend: function () {
            //borrar el contenido del cuerpo de la tabla de deudas antes de insertar los datos que van en el
            $('#cuerpo_tabla_cuentas').html('');

            //deshabilitar el boton de enviar formulario para que el usuario no presione varias veces rapidamente
            document.getElementById('form_search_buttonSubmit').disabled = true;

        },
        error: function (error) {
            console.log(error)
        }

    });
}

