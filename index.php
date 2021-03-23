<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<form>
<?php
  for($Cont=1; $Cont<=5;$Cont++)
    echo "
        <label for='Nombre-$Cont'>Reloj $Cont:</label>
        <input type='text' id='txtReloj-$Cont' name='Nombre-$Cont' class='btnReloj' Clave='$Cont'>
        <input id='reloj-$Cont' style='width: 180px; background-color: black;font-size:50px;color: green; text-align: center' value='0:00'>
        <br>";
  ?>
</form>

</body>

<script>
const MINUTO = 1000;
var FechaInicial;
var FechaFinal;
var Cont;

$(document).on("keypress", ".btnReloj", function(e) {

  Cont = $(this).attr('Clave');
  var Tiempo = $(this).val();

  var code = (e.keyCode ? e.keyCode : e.which);
  if (code == 13 && Tiempo > 0) {
    console.log ('Iniciar Reloj ' + Cont + ' por ' + Tiempo +  ' minutos');

    //OBTENEMOS LA FECHA ACTUAL
    FechaInicial = new Date(Date.now());
    FechaFinal = new Date(Date.now());
    //LE SUMO LOS MINUTOS A LA FECHA FINAL  
    FechaFinal.setMinutes(FechaInicial.getMinutes() + parseInt( Tiempo)); //le sumo los minutos a la fecha de creacion
    //IMPRIMO LAS FECHAS INICIALES Y FINALES
    console.log('Fecha Inicial:' + FechaInicial);
    console.log('Fecha Final: ' + FechaFinal);

    actualizarCronometro();
    setInterval(actualizarCronometro, MINUTO ); // Refresh every second
          
  } //Fin del Si se presiona Enter
})

const MILLISECONDS_OF_A_MINUTE = MINUTO * 60;
const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;

function actualizarCronometro(Tiempo) {
    const NOW = new Date();
    const DURATION = FechaFinal - NOW;
    const REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
    const REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MINUTO);
    // Thanks Pablo Monteserín (https://pablomonteserin.com/cuenta-regresiva/)

    var TiempoRestante = REMAINING_MINUTES + ':' + REMAINING_SECONDS;
    console.log(Cont + ': ' + TiempoRestante);
    $("#reloj-" + Cont).val(TiempoRestante);
  
    if (TiempoRestante == '0:0') {
        console.log("Tiempo Terminado");
        //COMO DIABLOS LO PARO :-(
        return;
    }
}

</script>

</html>
