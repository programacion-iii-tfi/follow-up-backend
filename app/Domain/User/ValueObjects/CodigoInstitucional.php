<?php

namespace App\Domain\User\ValueObjects;

use InvalidArgumentException;

class CodigoInstitucional
{
    private string $value;

    public function __construct()
    {
        $codigoInst = $this->generateCodigo();

        if (empty($codigoInst)) {
            throw new InvalidArgumentException('El código institucional no puede estar vacío');
        }

        $this->value = $codigoInst;
    }

    public static function fromString(string $value): self
    {
        if (empty(trim($value))) {
            throw new InvalidArgumentException('El código institucional no puede estar vacío');
        }

        // Evita pasar por el constructor normal, que siempre genera un código nuevo
        $instance = (new \ReflectionClass(self::class))->newInstanceWithoutConstructor();
        $instance->value = $value;

        return $instance;
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

    private function generateCodigo(): string
    {
        return sprintf('ALU-%s-%s', strtoupper(uniqid()), strtoupper(substr(md5((string)microtime(true)), 0, 5)));
    }
}