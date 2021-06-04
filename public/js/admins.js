
/*
* obtener con ajax las localidades de una provincia a partir de un idProvincia
* */
function fetchLocalidades(idProvincia) {
    $.ajax({
        type:'GET',
        url:'/admin/home/cobradores/create/localidades/'+idProvincia,
        dataType: 'JSON',
        contentType: "application/json",
        success:function(response_localidades) {
            $.map(response_localidades, function(val, key) {
                let option = '<option value="';
                option += val.idpadre;
                option += '">';
                option += val.padre;
                option += '</option>';
                $('#input_select_localidad').append(option);
            });
            document.querySelector('#input_select_localidad').fstdropdown.rebind();
        }
    });
}

/*
mostrar el formulario de direccion si se trata de un local fisico
* */
function onRadioFisicoChange(value){

    if(value==1){
        document.getElementById('div_form_local_fisico').style.display="block";
        makeThemRequiredInput(true);
    }else{
        document.getElementById('div_form_local_fisico').style.display="none";
        makeThemRequiredInput(false);
    }
}

/*
* hacer que los input con la clase .changeRequired se hagan obligatorios o no
* */
function makeThemRequiredInput(bandera){
    const rbs = document.querySelectorAll('.ChangeRequired');
    for (const rb of rbs) {
        if (bandera) {
            rb.required=true;
        }else{
            rb.required=false;
        }
    }
}
