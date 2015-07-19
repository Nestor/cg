<?php

namespace Melp\Cg\Common;

interface BufferInterface
{
    /**
     * @param string $str
     * @return self
     */
    public function append($str);

    /**
     * @param string $str
     * @return self
     */
    public function appendl($str = '');

    /**
     * @param string $str
     * @return self
     */
    public function indent($str = '    ');

    /**
     * @param string $str
     * @return self
     */
    public function outdent();

    /**
     * @param string $str
     * @return self
     */
    public function __toString();
}