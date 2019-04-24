<?php

namespace App\Models\Entity;


class RolePermission extends \App\Models\RolePermissionService {

    private $role_id;
    private $permission_id;

    /**
     * @return mixed
     */
    public function getRoleId()
    {
        return $this->role_id;
    }

    /**
     * @param mixed $role_id
     */
    public function setRoleId($role_id): void
    {
        $this->role_id = $role_id;
    }

    /**
     * @return mixed
     */
    public function getPermissionId()
    {
        return $this->permission_id;
    }

    /**
     * @param mixed $permission_id
     */
    public function setPermissionId($permission_id): void
    {
        $this->permission_id = $permission_id;
    }



}