<?php
declare(strict_types=1);

namespace CodeEdu\Acl;


use CodeEdu\Acl\Contracts\UserAcl;
use CodeEdu\Acl\Entities\Resource;
use CodeEdu\Acl\Entities\Role;

class Acl
{
    protected $roles;
    protected $resources;
    protected $user;

    /**
     * Acl constructor.
     * @param array $roles
     */
    public function __construct(array $roles, array $resources)
    {
        foreach($roles as $role) {
            if(!$role instanceof Role) {
                throw new \InvalidArgumentException("Invalid Role");
            }
        }
        $this->roles = $roles;

        foreach($resources as $resource) {
            if(!$resource instanceof Resource) {
                throw new \InvalidArgumentException("Invalid Resource");
            }
        }
        $this->resources = $resources;
    }

    /**
     * @param UserAcl $user
     * @return Acl
     */
    public function setUser(UserAcl $user): Acl
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        foreach ($this->roles as $r) {
            if($r->getName() == $role) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param string $role
     * @param string $permission
     * @return bool
     */
    public function hasPermission(string $role, string $permission): bool
    {
        foreach($this->roles as $r) {
            if($r->getName() == $role) {
                foreach($r->getPermissions() as $p) {
                    if($p->getName() == $permission) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    /**
     * @param string $permission
     * @param UserAcl|null $user
     * @return bool
     */
    public function can(string $permission, UserAcl $user = null): bool
    {
        if($user) {
            return $this->hasPermission($user->getRole(), $permission);
        }

        if($this->user) {
            return $this->hasPermission($this->user->getRole(), $permission);
        }

        return false;
    }

    /**
     * @param string $permission
     * @param UserAcl|null $user
     * @return bool
     */
    public function cannot(string $permission, UserAcl $user = null): bool
    {
        return !$this->can($permission, $user);
    }

    /**
     * @param $resource
     * @param UserAcl|null $user
     * @return bool
     */
    public function isOwner($resource, UserAcl $user = null): bool
    {
        if($user) {
            $this->setUser($user);
        }

        foreach($this->resources as $r) {
            if(is_a($resource, $r->getName())) {
                if($user) {
                    return $resource->{$r->getOwnerField()}() == $user->getId();
                }

                return $resource->{$r->getOwnerField()}() == $this->user->getId();

            }
        }
        return false;
    }
}