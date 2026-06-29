<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class UserName
{
    private string $value;

    public function __construct(string $tipo, string $dni, string $anio)
    {
        $tipo_trimmed = trim($tipo);
        $dni_trimmed = trim($dni);
        $anio_trimmed = trim($anio);

        if (empty($tipo_trimmed)) {
            throw new InvalidArgumentException('El tipo de usuario no puede estar vacío');
        }

        if (empty($dni_trimmed)) {
            throw new InvalidArgumentException('El dni no puede estar vacío');
        }

        if (empty($anio_trimmed)) {
            throw new InvalidArgumentException('El año de ingreso no puede estar vacío');
        }

        if (strlen($tipo_trimmed) > 5) {
            throw new InvalidArgumentException('El tipo de usuario no puede tener más de 5 caracteres');
        }

        if (strlen($dni_trimmed) > 9) {
            throw new InvalidArgumentException('El dni no puede tener más de 9 caracteres');
        }

        if (strlen($anio_trimmed) > 4) {
            throw new InvalidArgumentException('El año de ingreso no puede tener más de 4 caracteres');
        }

        $default_value = $this->defaultValue($tipo_trimmed, $dni_trimmed, $anio_trimmed);
        $this->value = $default_value;
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

    private function defaultValue(string $tipo, string $dni, string $anio): string
    {
        return sprintf('%s-%s-%s', strtoupper($tipo), strtoupper($dni), strtoupper($anio));
    }
}