<?php

namespace App\Models\Entity;


class RolePermission extends \App\Models\RolePermissionService {

    private $id;
    private $roleid;
    private $permissionid;
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
    public function getRoleid()
    {
        return $this->roleid;
    }

    /**
     * @param mixed $roleid
     */
    public function setRoleid($roleid): void
    {
        $this->roleid = $roleid;
    }

    /**
     * @return mixed
     */
    public function getPermissionid()
    {
        return $this->permissionid;
    }

    /**
     * @param mixed $permissionid
     */
    public function setPermissionid($permissionid): void
    {
        $this->permissionid = $permissionid;
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