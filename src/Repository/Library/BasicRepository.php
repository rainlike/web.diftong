<?php
declare(strict_types=1);

namespace App\Repository\Library;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

use Symfony\Bridge\Doctrine\RegistryInterface as Registry;

/**
 * Class BasicRepository
 *
 * @package App\Repository\Library
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class BasicRepository extends ServiceEntityRepository
{
    /**
     * BasicRepository constructor
     *
     * @param Registry $registry
     */
    public function __construct(Registry $registry)
    {
        parent::__construct($registry, static::class);
    }
}
