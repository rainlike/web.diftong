<?php
declare(strict_types=1);

namespace App\Repository\Library\Interfaces;

use Doctrine\ORM\Query;

/**
 * Interface IEnabled
 *
 * @package App\Repository\Library\Interfaces
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
interface IEnabled
{
    /**
     * Get enabled records
     *
     * @return array|null|mixed
     */
    public function getEnabled(): ?array;

    /**
     * Get query for enabled records
     *
     * @return Query
     */
    public function getEnabledQuery(): Query;

    /**
     * Find enabled record
     *
     * @param string $targetField
     * @param string $targetValue
     * @return mixed|null
     */
    public function findEnabled(string $targetField, string $targetValue);

    /**
     * Get query for enabled record
     *
     * @param string $targetField
     * @param string $targetValue
     * @return Query
     */
    public function findEnabledQuery(string $targetField, string $targetValue): Query;
}
