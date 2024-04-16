<?php

namespace App\Service;

interface ServiceInterface{
    public function create(Object $objet);
    public function update(Object $objet);
    public function delete(int $id);
    public function findOneBy(int  $id):Object;
    public function findAll():array;
}
