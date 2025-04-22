<?php
// File: DIContainer.php
namespace Core;
use ReflectionClass;
use Exception;
use Closure;
use ReflectionNamedType;
use ReflectionMethod;

class DIContainer
{
    /**
     * The container's  instance.
     *
     * @var static
     */
    protected static $instance;

    /**
     * the class name with namespace
     *
     * @var string
     */
    protected $callbackClass;

    /**
     * the method name of provided class
     *
     * @var string
     */
    protected $callbackMethod;

    /**
     * method separator of a class. when pass class and method as string
     */
    protected $methodSeparator = '@';

    /**
     * namespace  for  class. when pass class and method as string
     *
     * @var string
     */
    protected $namespace = "App\\Controllers\\";

    protected $bindings = [];
    protected $instances = [];

    /**
     *   get Singleton instance of the class
     *
     * @return static
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }

        return static::$instance;
    }

    /**
     * @param $callable -- string class and method name with separator @
     * @param  array  $parameters
     */
    public function call($callable, $parameters = [])
    {
        // set class name with namespace and method name
        $this->resolveCallback($callable);

        // initiate ReflectionMethod with class and method
        $methodReflection = new ReflectionMethod($this->callbackClass, $this->callbackMethod);

        // get all dependencies/parameters
        $methodParams = $methodReflection->getParameters();


        $dependencies = [];

        // loop with dependencies/parameters
        foreach ($methodParams as $param) {

            $type = $param->getType(); // check type

            if ($type && $type instanceof ReflectionNamedType) { /// if parameter is a class

                $name = $param->getClass()->newInstance(); // create insrance
                array_push($dependencies, $name); // push  to $dependencies array

            } else {  /// Normal parameter

                $name = $param->getName();

                if (array_key_exists($name, $parameters)) { // check exist in $parameters

                    array_push($dependencies, $parameters[$name]); // push  to $dependencies array

                } else { // if not exist

                    if (!$param->isOptional()) { // check if not optional
                        throw new Exception("Can not resolve parameters");
                    }
                }

            }

        }

        // make class instance
        $initClass = $this->make($this->callbackClass, $parameters);

        // call method with $dependencies/parameters
        return $methodReflection->invoke($initClass, ...$dependencies);
    }


    /**
     * separate class and method name
     * @param $callback
     */
    private function resolveCallback($callback)
    {
        //separate class and method
        $segments = $callback;
        if(!is_array($callback)) {
            $segments = explode($this->methodSeparator, $callback);
        }
        // set class name with namespace
        $this->callbackClass = $this->namespace.$segments[0];

        // set method name . if method name not provided then default method __invoke
        $this->callbackMethod = isset($segments[1]) ? $segments[1] : '__invoke';
    }

    /**
     * instantiate class with dependency and return class instance
     * @param $class - class name
     * @param $parameters (optional) -- parameters as array . If constructor need any parameter
     */
    public function make($class, $parameters = [])
    {
        if (isset($this->instances[$class])) {
            return $this->instances[$class];
        }

        $concrete = $this->getConcrete($class);
        
        if ($this->isBuildable($concrete, $class)) {
            $object = $this->build($concrete);
        } else {
            $object = $this->make($concrete);
        }

        if (isset($this->instances[$class])) {
            $this->instances[$class] = $object;
        }

        return $object;
    }

    protected function getConcrete($abstract)
    {
        if (isset($this->bindings[$abstract])) {
            return $this->bindings[$abstract];
        }
        return $abstract;
    }

    protected function isBuildable($concrete, $abstract)
    {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    protected function build($concrete)
    {
        if ($concrete instanceof Closure) {
            return $concrete($this);
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            throw new Exception("Target [$concrete] is not instantiable.");
        }

        $constructor = $reflector->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();
        $instances = $this->resolveDependencies($dependencies);

        return $reflector->newInstanceArgs($instances);
    }

    protected function resolveDependencies($dependencies)
    {
        $results = [];

        foreach ($dependencies as $dependency) {
            $type = $dependency->getType();

            if ($type && !$type->isBuiltin()) {
                $results[] = $this->make($type->getName());
            } else {
                if ($dependency->isDefaultValueAvailable()) {
                    $results[] = $dependency->getDefaultValue();
                } else {
                    throw new Exception("Can not resolve dependency {$dependency->name}");
                }
            }
        }

        return $results;
    }

    public function bind($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }
        $this->bindings[$abstract] = $concrete;
    }

    public function singleton($abstract, $concrete = null)
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }
        $this->bindings[$abstract] = $concrete;
        $this->instances[$abstract] = null;
    }
}