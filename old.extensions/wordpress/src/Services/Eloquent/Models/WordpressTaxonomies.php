<?php

namespace LzoMedia\Wordpress\Models;

use Carbon\Carbon;
use Corcel\Model\Post;
use Corcel\Model\Taxonomy;
use Illuminate\Database\Query\Builder;

/**
 *  @package Development\Extractor\Models
 * Autocomplete the Builder methods (for example where(), get(), find(), findOrFail() etc...)
 *  * @mixin Builder
 */
class WordpressTaxonomies extends Taxonomy
{
}
