<?php

namespace Source\Models\templates;

use Source\Models\MainModel;

/**
 * Habitat Object
 * @var 
 */

class AnimalModel extends MainModel
{
    protected $name;
    protected $breed;
    protected $id_Habitat;

    /**
     * Init Animal model on table Animal
     */
    public function __construct()
    {
        $this->table = 'Animal';
    }
}