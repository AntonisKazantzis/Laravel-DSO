<?php

namespace App\Enums;

enum RuneRarityEnum: string
{
    case COMMON = 'common';
    case IMPROVED = 'improved';
    case MAGIC = 'magic';
    case EXTRAORDINARY = 'extraordinary';
    case LEGENDARY = 'legendary';
    case UNIQUE = 'unique';
}
