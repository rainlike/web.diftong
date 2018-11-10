<?php
declare(strict_types=1);

namespace App\Entity\Library;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Library\Traits\Id as IdField;
use App\Entity\Library\Traits\Created as CreatedField;
use App\Entity\Library\Traits\Updated as UpdatedField;
use App\Entity\Library\Traits\Enabled as EnabledField;

/**
 * Class Basic
 *
 * @package App\Entity\Library
 * @author Alexander Saveliev <alex@spbcrew.com>
 * @ORM\MappedSuperclass()
 */
abstract class Basic
{
    use IdField;
    use EnabledField;
    use CreatedField;
    use UpdatedField;
}
