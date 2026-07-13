<?php

namespace App\Domain\User\Entities;

use App\Domain\User\ValueObjects\TurnoEscolar;

class CursoDivisionTurno
{
    private string $value;

    public function __construct(
        private readonly ?int $id, // 💡 Clave: Acepta null para registros nuevos
        private readonly int $curso,
        private readonly string $division,
        private readonly TurnoEscolar $turno,
        private readonly int $capacidad_maxima = 30, // 💡 Valor por defecto
    ) {
        $this->validate();
        $this->value = "{$this->curso}°{$this->division} - {$this->turno->value}";
    }

    private function validate(): void
    {
        if ($this->curso < 1 || $this->curso > 7) {
            throw new \InvalidArgumentException("Año inválido: {$this->curso}");
        }

        if (!preg_match('/^[A-Z]$/', $this->division)) {
            throw new \InvalidArgumentException("División inválida: {$this->division}");
        }
    }

    public function id(): ?int { return $this->id; }
    public function value(): string { return $this->value; }
    public function curso(): int { return $this->curso; }
    public function division(): string { return $this->division; }
    public function turno(): TurnoEscolar { return $this->turno; }
    public function capacidadMaxima(): int { return $this->capacidad_maxima; }

    // Reconstitución desde BD, siguiendo tu patrón para VOs que generan valor en el constructor
    public static function fromString(string $stored): self
    {
        // Usamos una expresión regular más flexible que tolera espacios intermedios (\s*)
        // e ignorancia de mayúsculas/minúsculas (/i) si fuera necesario
        if (!preg_match('/^(\d+)°\s*([A-Z])\s*-\s*(.+)$/i', $stored, $matches)) {
            throw new \InvalidArgumentException("Formato de curso/división inválido: {$stored}");
        }

        $curso = (int) $matches[1];
        $division = strtoupper($matches[2]); // Aseguramos que la división esté en mayúscula
        
        // Al asumir que TurnoEscolar es un Backed Enum (por el uso de $turno->value)
        // intentamos convertir el string capturado ("Mañana", "Tarde", etc.) a su caso correspondiente
        try {
            $turno = TurnoEscolar::from($matches[3]);
        } catch (\ValueError $e) {
            throw new \InvalidArgumentException("Turno escolar no válido: {$matches[3]}");
        }

        // Invocamos al constructor nativo de forma limpia
        return new self(
            id: 0, // 💡 Aquí podrías pasar un ID real si lo tuvieras, o dejarlo en 0 si es solo para reconstituir
            curso: $curso,
            division: $division,
            turno: $turno
        );
    }

    public function equals(CursoDivisionTurno $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}