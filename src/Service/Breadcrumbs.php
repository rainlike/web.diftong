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
use App\Entity\Portal;

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
     * @param bool $toParent
     * @param bool $withCurrent
     * @return array|null
     * @throws NonUniqueResultException
     */
    public function getBreadcrumbs(int $id, bool $withCurrent = false, bool $toParent = false): ?array
    {
        $repository = $this->em->getRepository(Theory::class);

        $theory = $repository->find($id);
        if (!$theory) {
            return null;
        }

        $portal = $theory->getPortal();
        $portalUltimateUri = $portal->getUltimateUri();

        $breadcrumbs = [];

        if ($withCurrent) {
            $currentBreadcrumb = [];
            $currentBreadcrumb['title'] = $theory->getTitle();
            $currentBreadcrumb['link'] = $this->router->generate(
                'theory_show',
                [
                    'uri' => $theory->getUltimateUri(),
                    'portal_uri' => $portalUltimateUri
                ]
            );

            $breadcrumbs[] = $currentBreadcrumb;
        }

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
                        'portal_uri' => $portalUltimateUri
                    ]
                );

                $breadcrumbs[] = $breadcrumb;
            }
        }

        $portalBreadcrumb = [
            'title' => $portal->getTitle(),
            'link' => $this->router->generate(
                'portal_show',
                ['uri' => $portalUltimateUri]
            )
        ];
        $breadcrumbs[] = $portalBreadcrumb;

        return $toParent
            ? $breadcrumbs
            : \array_reverse($breadcrumbs);
    }

    /**
     * Transform Theory/Portal entity to breadcrumb item
     *
     * @param Portal|Theory $target
     * @return array|null
     */
    public function transformToBreadcrumb($target): ?array
    {
        if (!($target instanceof Portal) || !($target instanceof Theory)) {
            return null;
        }

        $isPortal = $target instanceof Portal;

        $breadcrumb = [];
        $breadcrumb['title'] = $target->getTitle();

        $linkParams = $isPortal
            ? ['uri' => $target->getUltimateUri()]
            : [
                'uri' => $target->getUltimateUri(),
                'portal_uri' => $target->getPortal()->getUltimateUri()
            ];

        $breadcrumb['link'] = $this->router->generate('theory_show', $linkParams);

        return $breadcrumb;
    }
}
