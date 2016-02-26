<?php
declare(strict_types=1);

namespace CodeEdu\Acl\Entities;


class Permission
{

    protected $name;

    public function __construct(string $name = null)
    {
        $this->name = $name;
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
     * @return Permission
     */
    public function setName(string $name): Permission
    {
        $this->name = $name;
        return $this;
    }



}