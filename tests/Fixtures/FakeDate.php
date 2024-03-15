<?php

declare(strict_types=1);

namespace Tests\Fixtures;

use DateTime;
use Exception;

class FakeDate
{
    /**
     * @throws Exception
     */
    public static function aFakeDate(): DateTime
    {
        return new DateTime(date('Y-m-d H:i:s'));
    }
}