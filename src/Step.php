<?php

namespace Camillebaronnet\ETL;

class Step
{
    private $className;

    private $arguments;

    private $instance;

    public function __construct($className, $arguments)
    {
        $this->className = $className;
        $this->arguments = $arguments;
    }

    public function getInstance()
    {
        if(null !== $this->instance){
            return $this->instance;
        }

        $this->instance = new $this->className;
        foreach($this->arguments as $field => $value){
            $this->instance->$field = $value;
        }

        return $this->instance;
    }

    public function destroyInstance(): void
    {
        if(null !== $this->instance){
            unset($this->instance);
        }
    }
}
