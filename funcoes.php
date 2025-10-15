<?php
function validaCPF($CPF = null) {
    // Verifica se um número foi informado
    if (empty($CPF)) {
        return false;
    }

    // Elimina possível máscara
    $CPF = preg_replace("/[^0-9]/", "", $CPF);
    $CPF = str_pad($CPF, 11, '0', STR_PAD_LEFT);

    // Verifica se o número de dígitos informados é igual a 11
    if (strlen($CPF) != 11) {
        return false;
    }
    // Verifica se nenhuma das sequências inválidas foi digitada
    elseif (
        $CPF == '00000000000' || $CPF == '11111111111' || 
        $CPF == '22222222222' || $CPF == '33333333333' || 
        $CPF == '44444444444' || $CPF == '55555555555' || 
        $CPF == '66666666666' || $CPF == '77777777777' || 
        $CPF == '88888888888' || $CPF == '99999999999'
    ) {
        return false;
    } else {
        // Calcula os dígitos verificadores para verificar se o CPF é válido
        for ($t = 9; $t < 11; $t++) {
            for ($c = 0, $d = 0; $c < $t; $c++) {
                $d += $CPF[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($CPF[$c] != $d) {
                return false;
            }
        }
        echo("CPF cadastrado com sucesso! <br>");
        return true;
    }
}



?>
