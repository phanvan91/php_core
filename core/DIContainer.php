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
    protected $namespace = "App\\controllers\\";


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
        $classReflection = new ReflectionClass($class);

        $constructorParams = $classReflection->getConstructor()?->getParameters() ?? [];
        $dependencies = [];

        /*
         * loop with constructor parameters or dependency
         */
        foreach ($constructorParams as $constructorParam) {

            $type = $constructorParam->getType();

            if ($type && $type instanceof ReflectionNamedType) {

                // make instance of this class :
                $paramInstance = $constructorParam->getClass()->newInstance();

                // push to $dependencies array
                array_push($dependencies, $paramInstance);

            } else {

                $name = $constructorParam->getName(); // get the name of param

                // check this param value exist in $parameters
                if (array_key_exists($name, $parameters)) { // if exist

                    // push  value to $dependencies sequencially
                    array_push($dependencies, $parameters[$name]);

                } else { // if not exist

                    if (!$constructorParam->isOptional()) { // check if not optional
                        throw new Exception("Can not resolve parameters");
                    }

                }

            }

        }
        // finally pass dependancy and param to class instance
        return $classReflection->newInstance(...$dependencies);
    }
}