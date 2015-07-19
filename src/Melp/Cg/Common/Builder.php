<?php
/**
 * @author Gerard van Helden <gerard@zicht.nl>
 * @copyright Zicht Online <http://zicht.nl>
 */
namespace Melp\Cg\Common;

/**
 * Fixture builder helper class. Provides a fluent interface for building fixture objects in Doctrine ORM.
 */
class Builder
{
    /**
     * Constructor, initializes the builder object. To use the builder, call Builder::create(...)
     *
     * @param string $namespaces
     */
    public function __construct(array $namespaces)
    {
        $this->namespaces = array_merge([__NAMESPACE__ . '\\Node'], $namespaces);
        $this->stack    = array();
    }



    /**
     * Implements the builder / fluent interface for building fixture objects.
     *
     * @param string $method
     * @param array $args
     * @return Builder
     *
     * @throws \BadMethodCallException
     */
    public function __call($method, $args)
    {
        if ($className = $this->resolve($method)) {
            $class = new \ReflectionClass($className);
            if ($args) {
                $child = $class->newInstanceArgs($args);
            } else {
                $child = $class->newInstance();
            }
            $this->push($child);
        } elseif (method_exists($this->current(), $method)) {
            call_user_func_array(array($this->current(), $method), $args);
        } else {
            if (!count($args)) {
                $this->current()[$method] = true;
            } else {
                $this->current()[$method] = array_shift($args);
            }
        }
        return $this;
    }


    /**
     * Resolve the entity name to any of the configured namespaces.
     * Returns null if not found.
     *
     * @param string $entity
     * @return null|string
     */
    private function resolve($entity)
    {
        foreach ($this->namespaces as $namespace) {
            $className = $namespace . '\\' . ucfirst($entity);
            if (class_exists($className)) {
                return $className;
            }
        }
        return null;
    }


    /**
     * Returns the top of the stack.
     *
     * @return mixed
     */
    protected function current()
    {
        if (count($this->stack)) {
            return $this->stack[count($this->stack) -1];
        }
        return null;
    }


    /**
     * Pushes an object onto the stack
     *
     * @param $entity
     */
    protected function push($entity)
    {
        $this->stack[]= $entity;
    }


    /**
     * Returns one level up in the tree.
     *
     * @param null $setter
     * @return Builder
     */
    public function end()
    {
        if (!count($this->stack)) {
            throw new \UnexpectedValueException("Stack is empty. Did you call end() too many times?");
        }
        $current = array_pop($this->stack);
        if ($parent = $this->peek()) {
            $parent->appendChild($current);
        }
        return $this;
    }


    /**
     * Returns the object that is currently the subject of building
     *
     * @return mixed
     * @throws \UnexpectedValueException
     */
    public function peek()
    {
        if (!$this->current()) {
            throw new \UnexpectedValueException("The stack is empty. You should probably peek() before the last end() call.");
        }
        return $this->current();
    }
}