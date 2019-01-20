<?php
/**
 * Basic Trait
 * Share basic methods for repositories
 *
 * @package App\Repository\Library\Traits
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Repository\Library\Traits;

use App\Repository\Library\Magic\MagicCallable;

/** Trait Basic */
trait Basic
{
    use Enabled;
    use Columns;
    use MagicCallable;
}
