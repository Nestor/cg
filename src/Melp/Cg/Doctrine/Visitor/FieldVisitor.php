<?php

namespace Melp\Cg\Doctrine\Visitor;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\NodeInterface;
use Melp\Cg\Common\VisitorInterface;
use Melp\Cg\Doctrine\Node\Entity;
use Melp\Cg\Doctrine\Node\Field;
use Melp\Cg\Php\Node\DocComment;
use Melp\Cg\Php\Node\Method;
use Melp\Cg\Php\Node\Namespacex;
use Melp\Cg\Php\Patterns\Node\Accessor;
use Melp\Cg\Php\Patterns\Node\Mutator;

class FieldVisitor implements VisitorInterface
{
    public function visit(NodeInterface $node)
    {
        if ($node instanceof Entity) {
            for ($i = count($node->childNodes) -1; $i >= 0; $i --) {
                if ($node->childNodes[$i] instanceof Field) {
                    $field = $node->childNodes[$i];
                    if ($field['getter'] !== false) {
                        array_splice($node->childNodes, $i + 1, 0, array(new Accessor($field['name'])));
                    }
                    if ($field['setter'] !== false) {
                        array_splice($node->childNodes, $i + 1, 0, array(new Mutator($field['name'])));
                    }
                    if ($i > 0 && $node->childNodes[$i -1] instanceof DocComment) {
                        trigger_error('Not implemented yet: changing existing doccomments');
                    } else {
                        $docComment = new DocComment();

                        if (isset($field['id'])) {
                            $docComment->appendChild(new Raw("@ORM\\Id\n"));
                            if ($field['id'] === 'auto') {
                                $docComment->appendChild(new Raw("@ORM\\GeneratedValue(strategy=\"AUTO\")\n"));
                            }
                        }
                        $docComment->appendChild(new Raw("@ORM\\Column(type=\"{$field['type']}\")\n"));
                        array_splice($node->childNodes, $i, 0, array($docComment));
                    }
                }
            }
        }
    }
}