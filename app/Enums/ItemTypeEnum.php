<?php

namespace App\Enums;

enum ItemTypeEnum: string
{
    case AMULET = 'amulet';
    case CAPE = 'cape';
    case BELT = 'belt';
    case RING = 'ring';
    case ADORNMENT = 'adornment';
    case MAIN_HAND = 'main_hand';
    case OFF_HAND = 'off_hand';
    case DOUBLE_HANDED = 'double_handed';
    case HELMET = 'helmet';
    case SHOULDERS = 'shoulders';
    case TORSO = 'torso';
    case GLOVES = 'gloves';
    case BOOTS = 'boots';
}
