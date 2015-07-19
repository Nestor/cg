<?php

namespace Melp\Cg\Doctrine\Node;

use Melp\Cg\Php\Node\Property;

class Field extends Property
{
    protected $attributes = ['attr' => ['private'], 'setter' => true, 'getter' => true];
}