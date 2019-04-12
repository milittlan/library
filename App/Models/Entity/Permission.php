<?php

namespace App\Models\Entity;


class MOdule extends \App\Models\ModuleService {

    private $id;
    private $permission;
    private $moduleid;

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
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param mixed $permission
     */
    public function setPermission($permission): void
    {
        $this->permission = $permission;
    }

    /**
     * @return mixed
     */
    public function getModuleid()
    {
        return $this->moduleid;
    }

    /**
     * @param mixed $moduleid
     */
    public function setModuleid($moduleid): void
    {
        $this->moduleid = $moduleid;
    }


}