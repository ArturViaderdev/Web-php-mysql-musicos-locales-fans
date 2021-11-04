var x;
x = $(document);
x.ready(inicializarEventos);

$(document).ready(function () {
    $('#buscador').keyup(buscador);
    $(document).on('click', 'li', function () {
        $('#buscador').val($(this).text());
        $('#autobuscador').fadeOut();
    });
});


function buscador() {
    var query = $(this).val();
    if (query != '')
    {
        $.ajax({
            url: "mysql.php",
            method: "POST",
            data: {query: query},
            success: function (data)
            {
                $('#autobuscador').fadeIn();
                $('#autobuscador').html(data);
            }
        });
    } else {
        $('#autobuscador').fadeOut();
        $('#autobuscador').html("");
    }
}


function inicializarEventos() {
    /*autoCompletado();*/
    var x;
    /* x = $("#buscador2");
     x.click(presionBuscador);*/
    x = $("#provincia");
    x.change(cambiaprovincia);
    $("#email").keyup(comprobaremail);
}


function comprobaremail() {
    var prueba = 0;
    var email = $("#email").val();

    $.ajax({
        url: 'comprobaciones.php',
        method: 'POST',
        data: {email: email},
        dataType: 'json',
        success: function (data) {
            if (data['estado'] == 0) {
                document.getElementById('email').style.background = '#FFF';
            } else if (data['estado'] == 1) {
                prueba = 1;
                document.getElementById('email').style.background = '#FF5733';
            }
        },
    });
}

function erroremail() {
    var nombre = "isain";
    alert("entro");
}

function cambiaprovincia()
{
    var provincia = $("#provincia").val();
    var ciudad = $("#city");
    $.ajax({
        url: "provincias.php",
        method: "POST",
        data: {provincia: provincia},
        dataType: 'json',
        success: function (data)
        {
            ciudad.empty();
            for (var cont = 0; cont < data.length; cont++)
            {
                ciudad.append('<option value=' + data[cont]['id_ciudad'] + '>' + data[cont]['nombre'] + '</option>');
            }
        },
    });
}

function verifech()
{
    var fecha_aux = new Date(document.getElementById("fecha").value);
    var hoy = new Date();
    var Fecha1 = new Date(hoy.getUTCFullYear(), hoy.getMonth(), hoy.getDate() + 1);

    if (fecha_aux.getTime() < Fecha1.getTime())
    {
        alert("La fecha no puede ser anterior a mañana.");
        return false;
    } else
    {
        alert("ok");
        return true;
    }
}

function verificapass() {
    var pass1 = document.getElementById("pass1").value;
    var pass2 = document.getElementById("pass2").value;
    if (pass1 == pass2) {
        return true;
    } else
    {
        alert("Las contraseñas no son iguales");
        return false;
    }
}

function verificar() {
    var pass1 = document.getElementById("pass1").value;
    var pass2 = document.getElementById("pass2").value;
    if (pass1 != pass2) {
        alert("Las contraseñas no son iguales");
        return false;
    } else
    {
        return true;
    }
}

