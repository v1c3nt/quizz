<?php

namespace App\Service;

class Slugger
{
    private $sluggerToLower;

    public function __construct($sluggerToLower)
    {
        $this->sluggerToLower = $sluggerToLower;
    }
    
    public function slugify($strToConvert)
    {
        /*/dans tout les cas je vais devoir supprimer les espace + tag html
        $strToConvert = trim(strip_tags($strToConvert));
        //si sluggerToLower est a true je souhaite obligatoirement une chaine en minuscule
        if ($this->sluggerToLower) {
            $strToConvert = strtolower($strToConvert);
        }*/
        $convertedString = preg_replace('/[^a-zA-Z0-9]+(?:-[a-zA-Z0-9]+)*/', '-', $strToConvert);

        return $convertedString;
    }
}
