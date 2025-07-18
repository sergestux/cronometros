<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cronómetros</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        .timer-display {
            font-family: 'Courier New', monospace;
            font-weight: bold;
            text-align: center;
            border-radius: 8px;
            padding: 10px 0;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .timer-green {
            background-color: #1a2e19;
            color: #4ade80;
            border: 2px solid #22c55e;
        }
        
        .timer-orange {
            background-color: #2e2119;
            color: #fdba74;
            border: 2px solid #f97316;
        }
        
        .timer-red {
            background-color: #2e1919;
            color: #f87171;
            border: 2px solid #ef4444;
            animation: pulse 1s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }
        
        .timer-card {
            transition: transform 0.3s ease;
        }
        
        .timer-card:hover {
            transform: translateY(-5px);
        }
        
        .timer-input-group {
            margin-bottom: 15px;
        }
        
        .btn-start {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .btn-start:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }
        
        .header-section {
            background: linear-gradient(135deg, #0d6efd, #0dcaf0);
            color: white;
            border-radius: 0 0 20px 20px;
            padding: 20px 0;
            margin-bottom: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .active-status {
            background-color: #22c55e;
            box-shadow: 0 0 8px #22c55e;
        }
        
        .inactive-status {
            background-color: #64748b;
        }
        
        .instructions {
            background-color: #e9ecef;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Encabezado -->
    <div class="header-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1><i class="bi bi-stopwatch"></i> Sistema de Cronómetros</h1>
                    <p class="lead">Controla múltiples temporizadores simultáneamente</p>
                </div>
                <div class="col-md-4 text-end">
                    <div class="d-inline-block bg-white text-dark p-2 rounded">
                        <i class="bi bi-clock"></i> <span id="current-time"><?php echo date('H:i:s'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container">
        <!-- Instrucciones -->
        <div class="instructions">
            <div class="row">
                <div class="col-md-6">
                    <h4><i class="bi bi-info-circle"></i> Instrucciones:</h4>
                    <ol>
                        <li>Ingresa el tiempo en minutos para cada reloj</li>
                        <li>Presiona Enter para iniciar el temporizador</li>
                        <li>El color del reloj cambiará según el tiempo restante</li>
                    </ol>
                </div>
                <div class="col-md-6">
                    <h4><i class="bi bi-palette"></i> Indicadores de color:</h4>
                    <ul class="list-group">
                        <li class="list-group-item d-flex align-items-center">
                            <span class="status-indicator active-status"></span> Tiempo restante > 60%
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <span class="status-indicator" style="background-color: #fdba74;"></span> Tiempo restante entre 20% y 60%
                        </li>
                        <li class="list-group-item d-flex align-items-center">
                            <span class="status-indicator" style="background-color: #f87171;"></span> Tiempo restante < 20%
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row">
            <?php
            $TAM = 10;
            
            for($Cont = 1; $Cont <= $TAM; $Cont++):
            ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card timer-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-stopwatch"></i> Reloj <?php echo $Cont; ?>
                        </h5>
                        <span class="status-indicator inactive-status" id="status-<?php echo $Cont; ?>"></span>
                    </div>
                    <div class="card-body">
                        <div class="timer-input-group input-group mb-3">
                            <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            <input type="number" 
                                   id="txtReloj-<?php echo $Cont; ?>" 
                                   class="form-control btnReloj" 
                                   placeholder="Minutos" 
                                   Clave="<?php echo $Cont; ?>"
                                   min="1"
                                   max="120">
                            <button class="btn btn-start" onclick="startTimer(<?php echo $Cont; ?>)">
                                <i class="bi bi-play-fill"></i> Iniciar
                            </button>
                        </div>
                        
                        <div class="timer-display timer-green" id="reloj-<?php echo $Cont; ?>">
                            00:00
                        </div>
                        
                        <div class="progress mb-2" style="height: 8px;">
                            <div id="progress-<?php echo $Cont; ?>" 
                                 class="progress-bar bg-success" 
                                 role="progressbar" 
                                 style="width: 100%;"></div>
                        </div>
                        
                        <div class="text-center">
                            <small class="text-muted" id="time-info-<?php echo $Cont; ?>">
                                No iniciado
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        
        <div class="footer text-center">
            <p>Sistema de Cronómetros &copy; <?php echo date('Y'); ?> | Desarrollado con PHP, JavaScript y Bootstrap</p>
        </div>
    </div>
    
    <!-- Bootstrap JS y dependencias -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const MINUTO = 1000;
        const MILLISECONDS_OF_A_MINUTE = MINUTO * 60;
        const MILLISECONDS_OF_A_HOUR = MILLISECONDS_OF_A_MINUTE * 60;

        const TAM = <?php echo $TAM; ?>;
        
        var Cronometros = {
            FechaIni: new Array(TAM + 1).fill(null),
            FechaFin: new Array(TAM + 1).fill(null),
            Activo: new Array(TAM + 1).fill(false),
            Division: new Array(TAM + 1).fill(0),
            OriginalDuration: new Array(TAM + 1).fill(0)
        };

        // Actualizar la hora actual
        function updateCurrentTime() {
            const now = new Date();
            const timeStr = now.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit', second:'2-digit'});
            $('#current-time').text(timeStr);
        }
        
        setInterval(updateCurrentTime, 1000);
        updateCurrentTime();
        
        // Iniciar timer con botón
        function startTimer(Cont) {
            const input = $('#txtReloj-' + Cont);
            const Tiempo = input.val();
            
            if(Tiempo > 0) {
                console.log('Iniciar Reloj ' + Cont + ' por ' + Tiempo + ' minutos');
                
                const FechaInicial = new Date(Date.now());
                const FechaFinal = new Date(Date.now());
                FechaFinal.setMinutes(FechaInicial.getMinutes() + parseInt(Tiempo));
                
                console.log('Fecha Inicial:' + FechaInicial);
                console.log('Fecha Final: ' + FechaFinal);
                
                Cronometros.FechaIni[Cont] = FechaInicial;  
                Cronometros.FechaFin[Cont] = FechaFinal;     
                Cronometros.Activo[Cont] = true;
                Cronometros.Division[Cont] = parseInt((FechaFinal - FechaInicial) / 5);
                Cronometros.OriginalDuration[Cont] = FechaFinal - FechaInicial;
                
                // Actualizar UI
                $('#status-' + Cont).removeClass('inactive-status').addClass('active-status');
                $('#time-info-' + Cont).html(`Finaliza a las <strong>${FechaFinal.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'})}</strong>`);
            }
        }
        
        $(document).on("keypress", ".btnReloj", function(e) {
            const code = (e.keyCode ? e.keyCode : e.which);
            if (code == 13) {
                const Cont = $(this).attr('Clave');
                startTimer(Cont);
            }
        });

        setInterval(actualizarCronometros, MINUTO); // Actualizar cada minuto

        function actualizarCronometros() {
            for(let Cont = 1; Cont <= TAM; Cont++) {    
                if(Cronometros.Activo[Cont]) {
                    const now = new Date();
                    const DURATION = Cronometros.FechaFin[Cont] - now;
                    
                    if(DURATION <= 0) {
                        console.log("Tiempo Terminado, reloj: " + Cont);        
                        Cronometros.Activo[Cont] = false;
                        $('#reloj-' + Cont).text('00:00');
                        $('#status-' + Cont).removeClass('active-status').addClass('inactive-status');
                        $('#time-info-' + Cont).html('<span class="text-danger">Tiempo finalizado</span>');
                        continue;
                    }
                    
                    const REMAINING_MINUTES = Math.floor((DURATION % MILLISECONDS_OF_A_HOUR) / MILLISECONDS_OF_A_MINUTE);
                    const REMAINING_SECONDS = Math.floor((DURATION % MILLISECONDS_OF_A_MINUTE) / MINUTO);
                    
                    const TiempoRestante = REMAINING_MINUTES.toString().padStart(2, '0') + ':' + REMAINING_SECONDS.toString().padStart(2, '0');
                    $("#reloj-" + Cont).text(TiempoRestante);
                    
                    // Actualizar barra de progreso
                    const progressPercent = (DURATION / Cronometros.OriginalDuration[Cont]) * 100;
                    $('#progress-' + Cont).css('width', progressPercent + '%');
                    
                    // Cambiar colores según tiempo restante
                    const Division = Cronometros.Division[Cont];
                    const timerDisplay = $('#reloj-' + Cont);
                    
                    if (DURATION > (Division * 2)) {
                        timerDisplay.removeClass('timer-orange timer-red').addClass('timer-green');
                        $('#progress-' + Cont).removeClass('bg-warning bg-danger').addClass('bg-success');
                    } else if (DURATION > Division) {
                        timerDisplay.removeClass('timer-green timer-red').addClass('timer-orange');
                        $('#progress-' + Cont).removeClass('bg-success bg-danger').addClass('bg-warning');
                    } else {
                        timerDisplay.removeClass('timer-green timer-orange').addClass('timer-red');
                        $('#progress-' + Cont).removeClass('bg-success bg-warning').addClass('bg-danger');
                    }
                }  
            }  
        }
    </script>
</body>
</html>
