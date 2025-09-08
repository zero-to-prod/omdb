<?php

namespace Zerotoprod\Omdb\Helpers;

use Zerotoprod\DataModelHelper\DataModelHelper;
use Zerotoprod\Transformable\Transformable;

/**
 * @link https://github.com/zero-to-prod/omdb
 */
trait DataModel
{
    use \Zerotoprod\DataModel\DataModel;
    use Transformable;
    use DataModelHelper;
}