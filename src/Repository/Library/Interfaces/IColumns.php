<?php
/**
 * IColumns Interface
 * Marks repositories which should have method for extracting columns from entity
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

/** Interface IColumns */
interface IColumns
{
    /**
     * Get columns from entity
     *
     * @param int $id
     * @param array $columns
     * @return array|null|mixed
     */
    public function getColumns(int $id, array $columns): ?array;

    /**
     * Get query for entity columns
     *
     * @param int $id
     * @param array $columns
     * @return Query
     */
    public function getColumnsQuery(int $id, array $columns): Query;
}
