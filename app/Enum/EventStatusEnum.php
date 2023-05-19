<?php

namespace App\Enum;

enum EventStatusEnum: string {
    case ANNOUNCEMENT = 'Анонс';
    case CURRENT = 'Текущий';
    case FINISH = 'Завершённый';

}

