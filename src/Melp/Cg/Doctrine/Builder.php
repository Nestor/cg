<?php


namespace Melp\Cg\Doctrine;

use Melp\Cg\Php\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
    public function __construct()
    {
        parent::__construct([__NAMESPACE__ . '\\Node']);
    }
}