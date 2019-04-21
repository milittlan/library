<?php

namespace App\Models\Entity;


class Role extends \App\Models\RoleService{

    private $id;
    private $name;
    private $machinename;
    private $description;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getMachinename()
    {
        return $this->machinename;
    }

    /**
     * @param mixed $name
     */
    public function setMachinename($machinename): void
    {
        $this->machinename = $machinename;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

}