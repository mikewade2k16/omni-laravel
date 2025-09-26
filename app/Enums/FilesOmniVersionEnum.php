<?php

namespace App\Enums;

enum FilesOmniVersionEnum: string
{
    case PREVIEW = 'preview';
    case FINAL = 'final';
    case FOR_COLOR = 'for_color';
}