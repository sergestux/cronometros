<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<form>
<?php
$TAM=10;

for($Cont=1; $Cont<=$TAM;$Cont++)
  echo "
      <label for='Nombre-$Cont'>Reloj $Cont:</label>
      <input type='text' id='txtReloj-$Cont' name='Nombre-$Cont' class='btnReloj' Clave='$Cont'>
      <input id='reloj-$Cont' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>";
?>
</form>

</body>

<script>

  const MINUTO = 1000;
  const MILLISECONDS_OF_A_MINUTE = MINUTO * 60;
  const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;

  //var TAM=>   //TRAIGO LA VARIABLE DE PHP
  const TAM=<?=$TAM;?>;
  
  var Cronometros= new Array();
  Cronometros['FechaIni'] = new Array(TAM);   //Fecha inicial
  Cronometros['FechaFin']= new Array(TAM);    //Fecha Final
  Cronometros['Activo']= new Array(TAM);      //Si debo seguir restando el tiempo o ya terminó
  Cronometros['Division']= new Array(TAM);     //Para partir el tiempo en intervalos y se pueda cambiar de color
 
  setInterval(actualizarCronometros, MINUTO); // Refresh every second

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
      Cronometros['FechaIni'][Cont]=FechaInicial;  
      Cronometros['FechaFin'][Cont]=FechaFinal;     
      Cronometros['Activo'][Cont]=true; //Activo el cronometro
      Cronometros['Division'][Cont]=parseInt((FechaFinal-FechaInicial)/5);

    } //Fin del Si se presiona Enter
})

function actualizarCronometros(Tiempo) {

  //Recorro todos los timers
  for(Cont=1; Cont<=TAM; Cont++)
  {    
    if(Cronometros['Activo'][Cont])
    {
      var DURATION = Cronometros['FechaFin'][Cont] - Cronometros['FechaIni'][Cont];   //Duracion en segundos
      var REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
      var REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MINUTO);
    
      
      var TiempoRestante = REMAINING_MINUTES.toString().padStart(2,'0') + ':' + REMAINING_SECONDS.toString().padStart(2,'0');
      
      $("#reloj-" + Cont).val(TiempoRestante);
      Cronometros['FechaFin'][Cont].setSeconds(Cronometros['FechaFin'][Cont].getSeconds()-1);  //Le resto un segundo a la fecha final

      if (TiempoRestante == '00:00') {
        console.log("Tiempo Terminado, reloj: " + Cont);        
        Cronometros['Activo'][Cont]=false;
        
      }

      //DECIDO QUE COLOR DEBE TENER EL CRONOMETRO
      Division=Cronometros['Division'][Cont];
      console.log('Cont ' + Cont + ': ' + TiempoRestante);  
      if (DURATION> (Division*2))
        console.log('VERDE');
      else
      {
        if (DURATION> Division)
          console.log('NARANJA');
        else
          console.log('ROJO');
      }
    }  

  }  

}

</script>

</html>
