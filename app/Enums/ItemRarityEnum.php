<?php

namespace App\Enums;

enum ItemRarityEnum: string
{
    case COMMON = 'common';
    case IMPROVED = 'improved';
    case MAGIC = 'magic';
    case EXTRAORDINARY = 'extraordinary';
    case LEGENDARY = 'legendary';
    case UNIQUE = 'unique';
    case MYTHIC = 'mythic';
}
