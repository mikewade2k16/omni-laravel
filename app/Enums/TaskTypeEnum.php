<?php

namespace App\Enums;

enum TaskTypeEnum: string
{
    case DESIGN = 'design';
    case VIDEO = 'video';
    case FILME = 'filme';
    case COPY = 'copy';
    case D3 = '3D';
    case SITE = 'site';
    case PLANEJAMENTO = 'planejamento';
    case CRM = 'CRM';
    case TRAFEGO_PAGO = 'trafego pago';
}