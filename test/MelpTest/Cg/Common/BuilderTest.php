<?php
/**
 * @author Gerard van Helden <gerard@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */

namespace MelpTest\Cg\Common
{
    class BuilderTest extends \PHPUnit_Framework_TestCase
    {
        public $builder;

        function setUp()
        {
            $this->builder = new \Melp\Cg\Common\Builder(array('MelpTest\Cg\Common\Assets'));
        }

        function testBuilderCallsAppendChild()
        {
            $a = $this->builder->A()->B()->end()->peek();

            $this->assertTrue(count($a->childNodes) == 1);
            $this->assertInstanceOf('MelpTest\Cg\Common\Assets\B', $a->childNodes[0]);
        }


        function testMethodCall()
        {
            $a = $this->builder->A()->setSomething('foo')->peek();
            $this->assertEquals('foo', $a->getSomething());
        }

        function testAttributeCall()
        {
            $a = $this->builder->A()->foo('bar')->peek();
            $this->assertEquals('bar', $a['foo']);
        }


        /**
         * @expectedException \UnexpectedValueException
         */
        function testEmptyStack()
        {
            $this->builder->A()->end()->end();
        }

        /**
         * @expectedException \UnexpectedValueException
         */
        function testEmptyStackPeek()
        {
            $this->builder->A()->end()->peek();
        }
    }
}

namespace MelpTest\Cg\Common\Assets {
    use Melp\Cg\Common\BufferInterface;
    use Melp\Cg\Common\Node;

    class A extends Node
    {
        public $b;
        public $children;
        public $parent;
        public $something;

        function addB(B $b)
        {
            $this->b[] = $b;
        }


        function addChildren(A $a)
        {
            $this->children[] = $a;
        }


        function setParent(A $a)
        {
            $this->parent = $a;
        }


        function customSetter(B $b)
        {
            $this->customSet = $b;
        }


        function setSomething($something)
        {
            $this->something = $something;
        }


        function getSomething()
        {
            return $this->something;
        }

        public function write(BufferInterface $buffer)
        {
        }
    }

    class B extends Node
    {
        public $a;

        function setA(A $a)
        {
            $this->a = $a;
        }

        public function write(BufferInterface $buffer)
        {
        }
    }
}
