<!DOCTYPE html>
<html>
<head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<form>

      <label for='Nombre-1'>Reloj 1:</label>
      <input type='text' id='txtReloj-1' name='Nombre-1' class='btnReloj' Clave='1'>
      <input id='reloj-1' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-2'>Reloj 2:</label>
      <input type='text' id='txtReloj-2' name='Nombre-2' class='btnReloj' Clave='2'>
      <input id='reloj-2' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-3'>Reloj 3:</label>
      <input type='text' id='txtReloj-3' name='Nombre-3' class='btnReloj' Clave='3'>
      <input id='reloj-3' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-4'>Reloj 4:</label>
      <input type='text' id='txtReloj-4' name='Nombre-4' class='btnReloj' Clave='4'>
      <input id='reloj-4' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-5'>Reloj 5:</label>
      <input type='text' id='txtReloj-5' name='Nombre-5' class='btnReloj' Clave='5'>
      <input id='reloj-5' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-6'>Reloj 6:</label>
      <input type='text' id='txtReloj-6' name='Nombre-6' class='btnReloj' Clave='6'>
      <input id='reloj-6' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-7'>Reloj 7:</label>
      <input type='text' id='txtReloj-7' name='Nombre-7' class='btnReloj' Clave='7'>
      <input id='reloj-7' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-8'>Reloj 8:</label>
      <input type='text' id='txtReloj-8' name='Nombre-8' class='btnReloj' Clave='8'>
      <input id='reloj-8' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-9'>Reloj 9:</label>
      <input type='text' id='txtReloj-9' name='Nombre-9' class='btnReloj' Clave='9'>
      <input id='reloj-9' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br>
      <label for='Nombre-10'>Reloj 10:</label>
      <input type='text' id='txtReloj-10' name='Nombre-10' class='btnReloj' Clave='10'>
      <input id='reloj-10' style='width: 100px; background-color: black;font-size:40px;color: green; text-align: center' value='00:00'>
      <br></form>

</body>

<script>

  const MINUTO = 1000;
  const MILLISECONDS_OF_A_MINUTE = MINUTO * 60;
  const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;

  //var TAM=>   //TRAIGO LA VARIABLE DE PHP
  const TAM=10;
  
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
