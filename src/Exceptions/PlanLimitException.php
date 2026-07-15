<?php

namespace Lix\Exceptions;

final class PlanLimitException extends LixException
{
    private array|null $errorData = null;

    public function getErrorData(): ?array
    {
        return $this->errorData;
    }

    public function setErrorData(?array $errorData): self
    {
        $this->errorData = $errorData;
        return $this;
    }
}
