<?php

namespace Mimisk\Stagebox\Enums;

enum StageboxColor: string
{
    case BLACK = 'black';
    case BROWN = 'brown';
    case RED = 'red';
    case ORANGE = 'orange';
    case YELLOW = 'yellow';
    case GREEN = 'green';
    case BLUE = 'blue';
    case VIOLET = 'violet';
    case GREY = 'grey';
    case WHITE = 'white';

    public function hex(): string
    {
        return match ($this) {
            self::BLACK => '#000000',
            self::BROWN => '#8B4513',
            self::RED => '#FF0000',
            self::ORANGE => '#FFA500',
            self::YELLOW => '#FFFF00',
            self::GREEN => '#008000',
            self::BLUE => '#0000FF',
            self::VIOLET => '#8A2BE2',
            self::GREY => '#808080',
            self::WHITE => '#FFFFFF',
        };
    }
}
