<?php
/**
 * Breadcrumbs Service
 * Provides methods for build breadcrumbs
 *
 * @package App\Service
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Service;

use Doctrine\ORM\NonUniqueResultException;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface as Router;

use Doctrine\ORM\EntityManagerInterface as EntityManager;

use App\Entity\Theory;

/** Class Breadcrumbs */
class Breadcrumbs
{
    /** @var Router */
    private $router;

    /** @var EntityManager */
    private $em;

    /**
     * Breadcrumbs constructor
     *
     * @param Router $router
     * @param EntityManager $em
     */
    public function __construct(
        EntityManager $em,
        Router $router
    ) {
        $this->router = $router;
        $this->em = $em;
    }

    /**
     * Get breadcrumbs for Theory
     *
     * @param int $id
     * @param bool $reverse
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getBreadcrumbs(int $id, bool $reverse = false): ?array
    {
        $repository = $this->em->getRepository(Theory::class);

        $theory = $repository->find($id);
        if (!$theory) {
            return null;
        }

        $portal = $theory->getPortal();

        $breadcrumbs = [];

        $parents = $repository->getParents($id);
        if ($parents) {
            foreach ($parents as $key => $parent) {
                if (!$parent['enabled']) {
                    continue;
                }

                $breadcrumb = [];
                $breadcrumb['title'] = $parent['title'];
                $breadcrumb['link'] = $this->router->generate(
                    'theory_show',
                    [
                        'uri' => $repository->find($parent['id'])->getUltimateUri(),
                        'portal_uri' => $portal->getUltimateUri()
                    ]
                );

                $breadcrumbs[] = $breadcrumb;
            }
        }

        $portalBreadcrumb = [
            'title' => $portal->getTitle(),
            'link' => $this->router->generate(
                'portal_show',
                ['uri' => $portal->getUltimateUri()]
            )
        ];
        $breadcrumbs[] = $portalBreadcrumb;

        return $reverse
            ? \array_reverse($breadcrumbs)
            : $breadcrumbs;
    }
}
