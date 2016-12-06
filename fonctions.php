<?php
function wLogRead($path,$param) { // Fonction d'inscription dans la logs 
    $fp = fopen ($path."data/".$param.".log", "a+");
    $ligne = fgetcsv($fp, 1024);
    fclose ($fp);

    return $ligne[0];     
}

function wCountAdd($path,$param,$sMessage) { // Fonction d'inscription dans la logs 
    $fp = fopen ($path."data/".$param.".log", "a+");
    if (fwrite ($fp, $sMessage.(chr(13)))) {
            return true;
    } else {
            return false;
    }
    fclose ($fp);      
}

function wCountErase($path,$param) { // Fonction d'inscription dans la logs
    $fp = unlink($path."data/".$param.".log");     
}

#Fonction séparateur de millier avec espace
function numFormat($num){
    $numFormat = strrev(wordwrap(strrev($num), 3, ' ', true));

    return $numFormat;
}

