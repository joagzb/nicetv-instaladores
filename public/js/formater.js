/*
* obtener el nombre de un mes a partir de un numero 1..12
* */
function getMonthName(value) {
    let nombre = "enero";
    switch (value) {
        case 1:
            break;
        case 2:
            nombre = "febrero";
            break;
        case 3:
            nombre = "marzo";
            break;
        case 4:
            nombre = "abril";
            break;
        case 5:
            nombre = "mayo";
            break;
        case 6:
            nombre = "junio";
            break;
        case 7:
            nombre = "julio";
            break;
        case 8:
            nombre = "agosto";
            break;
        case 9:
            nombre = "septiembre";
            break;
        case 10:
            nombre = "octubre";
            break;
        case 11:
            nombre = "noviembre";
            break;
        case 12:
            nombre = "diciembre";
            break;
    }
    return nombre;
}
