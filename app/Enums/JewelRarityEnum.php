<?php

namespace App\Enums;

enum JewelRarityEnum: string
{
    case COMMON = 'common';
    case IMPROVED = 'improved';
    case MAGIC = 'magic';
    case EXTRAORDINARY = 'extraordinary';
    case LEGENDARY = 'legendary';
    case MYTHIC = 'mythic';
}
