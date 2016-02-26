<?php
declare(strict_types=1);

namespace CodeEdu\Acl\Entities;


class Role
{

    protected $name;
    protected $permissions;

    public function __construct(string $name = null)
    {
        $this->name = $name;
        $this->permissions = [];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Role
     */
    public function setName(string $name): Role
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    /**
     * @param Permission $permission
     * @return Role
     */
    public function addPermission(Permission $permission): Role
    {
        $this->permissions[] = $permission;
        return $this;
    }



}