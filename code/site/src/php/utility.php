<?php

function troncaStringa($stringa, $limite)
{
    if (strlen($stringa) <= $limite) {
        return $stringa;
    }

    $ultimaOccorrenzaSpazio = strrpos(substr($stringa, 0, $limite), ' ');
    $stringaTroncata = substr($stringa, 0, $ultimaOccorrenzaSpazio);
    $stringaTroncata .= ' ...';

    return $stringaTroncata;
}
