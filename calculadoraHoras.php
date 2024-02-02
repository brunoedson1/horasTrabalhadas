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

}