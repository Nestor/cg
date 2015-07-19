<?php

namespace Melp\Cg\Php;

use Melp\Cg\Common\Builder as BaseBuilder;

class Builder extends BaseBuilder
{
    public function __construct()
    {
        parent::__construct([__NAMESPACE__ . '\\Node']);
    }

}