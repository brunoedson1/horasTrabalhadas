<?php
header("Content-Type: application/jason");

//recebendo dados do POST
function calcularHorasDiurnasENoturnas($inicio, $fim)
{
    //converter os horários para objetos DateTime
    $inicio = DateTime::createFromFormat('H:i', $inicio);
    $fim = DateTime::createFromFormat('H:i', $fim);

    //verificar se o período ultrapassa a meia-noite
    if ($inicio > $fim) {
        $fim->modify('+1 day');
    }

    //definir o horário de início e fim do horário noturno
    $inicioNoturno = DateTime::createFromFormat('H:i', '22:00');
    $fimNoturno = DateTime::createFromFormat('H:i', '05:00')->modify('+1 day');

    //definir o horário de início e fim do horário noturno
    $inicioNoturno = DateTime::createFromFormat('H:i', '22:00');
    $fimNoturno = DateTime::createFromFormat('H:i', '05:00')->modify('+1 day');

    //verificando se o período ultrapassa 24 horas
    $diff = $inicio->diff($fim);
    if ($diff->days > 0 || $diff->invert == 1 || $diff->format('%R%H%i') === '+0000') {
        return "O período não pode exceder 24 horas.";
    }

    //inicializar os contadores de horas diurnas e noturnas
    $horasDiurnas = 0;
    $horasNoturnas = 0;

    //iterar sobre cada hora do período
    $intervalo = new DateInterval('PT1H');
    $periodo = new DatePeriod($inicio, $intervalo, $fim);
    foreach ($periodo as $hora) {
        //verificar se a hora está dentro do horário noturno
        if ($hora >= $inicioNoturno && $hora < $fimNoturno) {
            $horasNoturnas++;
        } else {
            $horasDiurnas++;
        }
    }

    if ($fim < $inicio) {
        $horasDiurnas -= 12;
        $horasNoturnas += 12;
    }

    $resultado = [
        'diurnas' => sprintf('%02d:%02d', floor($horasDiurnas), ($horasDiurnas - floor($horasDiurnas)) * 60),
        'noturnas' => sprintf('%02d:%02d', floor($horasNoturnas), ($horasNoturnas - floor($horasNoturnas)) * 60)
    ];

    return $resultado;
}

//verificar se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //receber os dados do período de trabalho
    $dados = json_decode(file_get_contents("php://input"), true);

    //calcular as horas diurnas e noturnas
    $resultado = calcularHorasDiurnasENoturnas($dados['horaInicio'], $dados['horaFim']);

    //enviar o resultado como JSON
    echo json_encode($resultado);
}