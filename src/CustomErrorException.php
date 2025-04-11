<?php

namespace IPorto\LaravelErrorHelper;

use Exception;

class CustomErrorException extends Exception
{
    protected array $extraData;

    public function __construct(string $message = "", array $extraData = [], int $code = 500, Exception $previous = null)
    {
        $this->extraData = $extraData;
        parent::__construct($message, $code, $previous);
    }

    public function getExtraData(): array
    {
        return $this->extraData;
    }
}