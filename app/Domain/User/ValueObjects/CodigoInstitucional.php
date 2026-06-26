<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class CodigoInstitucional
{
    private string $value;

    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if (empty($trimmed)) {
            throw new InvalidArgumentException('El código institucional no puede estar vacío');
        }

        if (strlen($trimmed) > 15) {
            throw new InvalidArgumentException('El código institucional no puede tener más de 15 caracteres');
        }

        $this->value = $trimmed;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function generateCodigo(): string
    {
        return sprintf('ALU-%s-%s', strtoupper(uniqid()), strtoupper(substr(md5((string)microtime(true)), 0, 5)));
    }
}