<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class UserName
{
    private string $value;

    public function __construct(string $value)
    {
        $trimmed = trim($value);

        if (empty($trimmed)) {
            throw new InvalidArgumentException('El nombre de usuario no puede estar vacío');
        }

        if (strlen($trimmed) > 255) {
            throw new InvalidArgumentException('El nombre de usuario no puede tener más de 255 caracteres');
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
}