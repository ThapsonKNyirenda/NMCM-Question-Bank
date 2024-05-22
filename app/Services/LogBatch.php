<?php

namespace App\Services;

use Ramsey\Uuid\Uuid;

class LogBatch
{
    public ?string $uuid = null;

    public int $transactions = 0;

    protected function generateUuid(): string
    {
        return Uuid::uuid4()->toString();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

}
