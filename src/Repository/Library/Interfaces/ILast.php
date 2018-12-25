<?php
/**
 * ILast Interface
 * Marks repositories which should has method for getting the last record
 *
 * @package App\Repository\Library\Interfaces
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Repository\Library\Interfaces;

use Doctrine\ORM\Query;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Library\Interfaces\ILastable;

/** Interface ILast */
interface ILast
{
    /**
     * Get the last record
     *
     * @return ILastable|null
     */
    public function getLast();

    /**
     * Get query for getting last record
     *
     * @return Query
     */
    public function getLastQuery(): Query;

    /**
     * Get lasts records
     *
     * @param int $count
     * @return array|ArrayCollection
     */
    public function getLasts(int $count);

    /**
     * Get query for getting lasts records
     *
     * @param int $count
     * @return Query
     */
    public function getLastsQuery(int $count): Query;
}
