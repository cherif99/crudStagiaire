<?php
namespace App\Service;


class FullnameService{
    function getFullname(string $nom, string $prenom){

        return $prenom.'  '.$nom;
    }
}