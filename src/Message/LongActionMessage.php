<?php

namespace App\Message;

final class LongActionMessage
{
    private bool $withError;

    /**
     * @param bool $withError
     */
    public function __construct(bool $withError)
    {
        $this->withError = $withError;
    }

    public function isWithError(): bool
    {
        return $this->withError;
    }

    public function setWithError(bool $withError): self
    {
        $this->withError = $withError;
        return $this;
    }

}
