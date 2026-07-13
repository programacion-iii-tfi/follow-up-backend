<?php

namespace App\Domain\User\ValueObjects;

enum TurnoEscolar: string
{
    case MANANA = 'Mañana';
    case TARDE = 'Tarde';
}