<?php
/**
 * IExistForPortal Interface
 * Marks repositories which should have method for checking of self-existing for portal
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

/** Interface IExistForPortal */
interface IExistForPortal
{
    /**
     * Check if at least one target of this record exist for portal
     *
     * @param int $id
     * @return bool
     */
    public function existForPortal(int $id): ?bool;

    /**
     * Get query for check that at least one target of this record exist for portal
     *
     * @param int $id
     * @return Query
     */
    public function existForPortalQuery(int $id): Query;
}
