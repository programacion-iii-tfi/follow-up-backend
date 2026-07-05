<?php

namespace App\Domain\Shared\ValueObjects;

use InvalidArgumentException;
use DateTimeImmutable;

class FechaFormateada
{
    private DateTimeImmutable $fecha;

    public function __construct(string $fecha)
    {
        // Acepta dd/mm/yyyy
        $parsed = DateTimeImmutable::createFromFormat('d/m/Y', $fecha);

        if (!$parsed) {
            throw new InvalidArgumentException("Fecha inválida: {$fecha}. Formato esperado: dd/mm/yyyy");
        }

        $this->fecha = $parsed;
    }

    // Para guardar en la DB
    public function toDatabase(): string
    {
        return $this->fecha->format('Y-m-d');
    }

    // Para devolver al frontend
    public function toDisplay(): string
    {
        return $this->fecha->format('d/m/Y');
    }

    // Para trabajar con la fecha en el dominio
    public function toDateTime(): DateTimeImmutable
    {
        return $this->fecha;
    }

    public function toYears(): string
    {
        return strval($this->fecha->format('Y'));
    }

    // Para construir desde la DB (yyyy-mm-dd)
    public static function fromDatabase(string|\DateTimeInterface $fecha): self
    {
        $instance = new self('01/01/2000'); // instancia temporal

        if ($fecha instanceof \DateTimeInterface) {
            $instance->fecha = \DateTimeImmutable::createFromInterface($fecha);
            return $instance;
        }

        // Acepta tanto "Y-m-d" como "Y-m-d H:i:s" por si Eloquent devuelve con hora
        $parsed = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $fecha)
            ?: DateTimeImmutable::createFromFormat('Y-m-d', $fecha);

        if (!$parsed) {
            throw new InvalidArgumentException("Fecha inválida desde DB: {$fecha}");
        }

        $instance->fecha = $parsed;
        return $instance;
    }
}