<?php

namespace Tests\Unit;

use Zerotoprod\OmdbApi\OmdbApiInterface;
use Zerotoprod\OmdbModels\Factories\SearchResultsFactory;
use Zerotoprod\OmdbModels\Factories\TitleFactory;
use Zerotoprod\OmdbModels\Title;

class OmdbApiFake implements OmdbApiInterface
{

    public function poster(string $imdbID): string
    {
        return 'https://img.omdbapi.com/?apikey=8f8423aa&i='.$imdbID;
    }

    public function byIdOrTitle(
        ?string $title = null,
        ?string $imdbID = null,
        ?string $type = null,
        ?int $year = null,
        ?bool $full_plot = false,
        mixed $callback = null,
        ?string $version = null,
        ?array $CURLOPT = [CURLOPT_TIMEOUT => 10]
    ): array {
        return TitleFactory::factory()->merge([
            Title::Title => $title,
            Title::imdbID => $imdbID,
            Title::Type => $type,
            Title::Year => $year,
        ])->context();
    }

    public function search(
        string $title,
        ?string $type = null,
        ?int $year = null,
        ?int $page = 1,
        mixed $callback = null,
        ?string $version = null,
        ?array $CURLOPT = [CURLOPT_TIMEOUT => 10]
    ): array {
        return SearchResultsFactory::factory()
            ->setSearch([
                TitleFactory::factory()->merge([
                    Title::Title => $title,
                    Title::Type => $type,
                    Title::Year => $year,
                ])->context()
            ])->context();
    }
}