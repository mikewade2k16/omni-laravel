<?php

namespace App\Enums;

enum CampaignStatusEnum: string
{
    case ATIVA = 'ativa';
    case EM_PAUSA = 'em_pausa';
    case CONCLUIDA = 'concluida';
    case CANCELADA = 'cancelada';
}