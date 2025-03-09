<?php

declare(strict_types=1);

namespace Saloon\Traits\RequestProperties;

use Saloon\Repositories\IntegerStore;

trait HasDelay
{
    /**
     * Request Delay
     */
    protected IntegerStore $delay;

    /**
     * Delay repository
     */
    public function delay(): IntegerStore
    {
        return $this->delay ??= new IntegerStore($this->defaultDelay());
    }

    /**
     * Default Delay
     */
    protected function defaultDelay(): ?int
    {
        return null;
    }
}
