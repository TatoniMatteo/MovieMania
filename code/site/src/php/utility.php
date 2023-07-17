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

function getstars($personaggi)
{
    $stars = array();
    foreach ($personaggi as $personaggio) {
        if ($personaggio['star']) {
            $star = $personaggio;
            $first = true;
            foreach ($stars as $s) {
                if ($s['nome'] == $star['nome'] && $s['cognome'] == $star['cognome'] && $s['data_nascita'] == $star['data_nascita']) {
                    $first = false;
                    break;
                }
            }
            if ($first) {
                $stars[] = $star;
            }
        }
    }
    return $stars;
}

function thereAreMembri($personaggi)
{
    foreach ($personaggi as $personaggio) {
        if ($personaggio['categoria_ruolo'] == 3) {
            return true;
        }
    }
    return false;
}

function thereAreScrittori($personaggi)
{
    foreach ($personaggi as $personaggio) {
        if ($personaggio['ruolo'] == 'Scrittore') {
            return true;
        }
    }
    return false;
}


function thereAreRegisti($personaggi)
{
    foreach ($personaggi as $personaggio) {
        if ($personaggio['ruolo'] == 'Regista') {
            return true;
        }
    }
    return false;
}
