<?php

namespace Lix\Exceptions;

final class ValidationException extends LixException
{
    public function __construct(public $data = [])
    {}
}
