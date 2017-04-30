<?php

namespace Nurmanhabib\ActorManager\Exceptions;

class UnfulfilledRequireException extends Exception
{
    public function __construct($require)
    {
        parent::__construct('Require set value with ' . $this->methodRequire($require) . ' method.');
    }

    protected function methodRequire($require)
    {
        $method = str_replace('_', ' ', $require);
        $method = ucwords($method);
        $method = str_replace(' ', '', $method);
        $method = 'set' . $method . '()';

        return $method;
    }
}
