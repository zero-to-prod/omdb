<?php

namespace Zerotoprod\Omdb;

use Zerotoprod\OmdbApi\OmdbApi;
use Zerotoprod\OmdbApi\OmdbApiInterface;
use Zerotoprod\OmdbModels\Error;
use Zerotoprod\OmdbModels\SearchResults;
use Zerotoprod\OmdbModels\Title;
use Zerotoprod\OmdbModels\Type;

/**
 * A wrapper for https://www.omdbapi.com/
 */
class Omdb
{

    /**
     * Inject a OmdbApi Instance
     *
     * @link https://github.com/zero-to-prod/omdb
     * @see  https://github.com/zero-to-prod/omdb-api
     */
    public function __construct(private readonly OmdbApiInterface $OmdbApi)
    {
    }

    /**
     * Instantiates a new instance
     *
     * @param  string  $apikey
     * @param  string  $base_url
     * @param  string  $img_url
     *
     * @return Omdb
     * @link https://github.com/zero-to-prod/omdb
     * @see  https://github.com/zero-to-prod/omdb-api
     */
    public static function from(
        string $apikey,
        string $base_url = 'https://www.omdbapi.com/',
        string $img_url = 'https://img.omdbapi.com/'
    ): Omdb {
        return new self(new OmdbApi($apikey, $base_url, $img_url));
    }

    /**
     * Returns the Poster Image.
     *
     * @link  https://github.com/zero-to-prod/omdb
     * @see   https://www.omdbapi.com/
     * @see   https://github.com/zero-to-prod/omdb-api
     */
    public function poster(string $imdbID): string
    {
        return $this->OmdbApi->poster($imdbID);
    }

    /**
     * Retrieve detailed information about a specific movie, TV series, or episode by either its IMDb ID or title.
     *
     * @param  string|null  $title      *Optional. Production title to search for (e.g. 'Avatar'). *Either `$t` or `$i` must be specified.
     * @param  string|null  $imdb_id    *Optional. A valid IMDb ID (e.g. 'tt1285016'). *Either `$t` or `$i` must be specified.
     * @param  Type|null    $Type       Optional. Type of result to return (movie, series, episode)
     * @param  int|null     $year       Optional. Year of release.
     * @param  bool         $full_plot  Optional. Return short or full plot.
     * @param  mixed|null   $callback   Optional. JSONP callback name.
     * @param  string|null  $version    Optional. API version (reserved for future use).
     * @param  array        $CURLOPT    cURL options.
     *
     * @return Error|Title
     * @link  https://github.com/zero-to-prod/omdb
     * @see   https://github.com/zero-to-prod/omdb-api
     */
    public function byIdOrTitle(
        ?string $title = null,
        ?string $imdb_id = null,
        ?Type $Type = null,
        ?int $year = null,
        ?bool $full_plot = false,
        mixed $callback = null,
        ?string $version = null,
        array $CURLOPT = [CURLOPT_TIMEOUT => 10]
    ): Error|Title {
        $response = $this->OmdbApi->byIdOrTitle(
            $title,
            $imdb_id,
            $Type?->value,
            $year,
            $full_plot,
            $callback,
            $version,
            $CURLOPT
        );

        return isset($response[Error::ErrorType])
            ? Error::from($response)
            : Title::from($response);
    }

    /**
     * Search for multiple titles using a keyword.
     *
     * @param  string       $title     Required. Production title to search for (e.g. 'Avatar').
     * @param  Type|null    $Type      Optional. Type of result to return (movie, series, episode)
     * @param  int|null     $year      Optional. Year of release.
     * @param  int          $page      Optional. Search page number.
     * @param  mixed|null   $callback  Optional. JSONP callback name.
     * @param  string|null  $version   Optional. API version (reserved for future use).
     * @param  array        $CURLOPT   cURL options.
     *
     * @return Error|SearchResults
     * @link  https://github.com/zero-to-prod/omdb
     * @see   https://github.com/zero-to-prod/omdb-api
     */
    public function search(
        string $title,
        ?Type $Type = null,
        ?int $year = null,
        ?int $page = 1,
        mixed $callback = null,
        ?string $version = null,
        array $CURLOPT = [CURLOPT_TIMEOUT => 10]

    ): Error|SearchResults {
        $response = $this->OmdbApi->search(
            $title,
            $Type?->value,
            $year,
            $page,
            $callback,
            $version,
            $CURLOPT
        );

        return isset($response[Error::ErrorType])
            ? Error::from($response)
            : SearchResults::from($response);
    }
}