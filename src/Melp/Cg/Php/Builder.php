<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
    public function __construct(array $namespaces = [])
    {
        parent::__construct(array_merge([__NAMESPACE__ . '\\Node'], $namespaces));
    }
}