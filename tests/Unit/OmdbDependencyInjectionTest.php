<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;
use Zerotoprod\Omdb\Omdb;

class OmdbDependencyInjectionTest extends TestCase
{
    #[Test] public function poster(): void
    {
        $Omdb = new Omdb(new OmdbApiFake());

        self::assertEquals('test', substr($Omdb->poster('test'), -4));
    }

    #[Test] public function byIdOrTitle(): void
    {
        $Omdb = new Omdb(new OmdbApiFake());

        self::assertEquals('Avatar', $Omdb->byIdOrTitle('Avatar')->Title);
    }

    #[Test] public function search(): void
    {
        $Omdb = new Omdb(new OmdbApiFake());

        self::assertEquals('Avatar', reset($Omdb->search('Avatar')->Search)->Title);
    }
}