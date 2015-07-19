<?php

namespace Melp\Cg\Php\Parser;

use Melp\Cg\Common\Node\Raw;
use Melp\Cg\Common\ScannerInterface;
use Melp\Cg\Php\Node\Comment;

class CommentParser extends Parser
{
    private $pattern = '!(#|/[/*])!A';

    public function match(ScannerInterface $scanner)
    {
        return $scanner->matchr($this->pattern);
    }

    public function parse(ScannerInterface $scanner)
    {
        $ret = new Comment();
        $type = $scanner->expectr($this->pattern)[0];
        $ret['type']= $type;
        switch ($type) {
            case '//':
            case '#':
                $ret->appendChild(new Raw($scanner->scanUntil(["\n"])));
                $scanner->expect("\n");
                break;
            case '/*';
                $ret->appendChild(new Raw($scanner->scanUntil(['*/']), true));
                $scanner->expect('*/');
        }
        return $ret;
    }
}