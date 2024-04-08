<?php

namespace Source\Models\templates;

use Source\Models\MainModel;

/**
 * Habitat Object
 * @var 
 */

class HabitatModel extends MainModel
{
    //propriétés

    /** 
     * name of habitat
     * @var string
     */
    public $name;

    /**
     * picture of habitat
     * @var 
     */
    public $picture;

    /**
     * decription of habitat
     * @var string
     */
    public $description;

    /**
     * Animal liste in habitat
     * @var string
     */
    public $listAnimal;
}