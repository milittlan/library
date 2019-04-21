<?php

namespace App\Models\Entity;


class Permission extends \App\Models\ModuleService {

    private $id;
    private $name;
    private $module;
    private $machinename;

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
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     */
    public function setModule($module): void
    {
        $this->module = $module;
    }

    /**
     * @return mixed
     */
    public function getMachinename()
    {
        return $this->machinename;
    }

    /**
     * @param mixed $machinename
     */
    public function setMachinename($machinename): void
    {
        $this->machinename = $machinename;
    }

}