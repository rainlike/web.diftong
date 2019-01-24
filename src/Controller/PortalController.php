<?php
/**
 * Portal Controller
 * Contains functionality for Portals
 *
 * @package App\Controller
 * @version 1.0.0
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @copyright 2018 spbcrew.com (https://www.spbcrew.com)
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\NonUniqueResultException;

use Psr\Container\ContainerInterface as Container;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Contracts\Translation\TranslatorInterface as Translator;

use App\Entity\Topic;
use App\Entity\Lyric;
use App\Entity\Portal;
use App\Entity\Theory;
use App\Entity\Article;

/** @package App\Controller */
class PortalController extends AbstractController
{
    /**
     * Render main page of Portal
     *
     * @param Request $request
     * @param Translator $translator
     * @param string $uri
     * @return RedirectResponse|Response|array
     * @throws DBALException
     * @throws NonUniqueResultException
     * @Route("/{uri}",
     *         methods={"GET"},
     *         name="portal_show"
     * )
     * @Template()
     */
    public function show(
        Request $request,
        Translator $translator,
        string $uri
    ) {
        $repository = $this->getDoctrine()->getRepository(Portal::class);

        $portal = $repository->findByUltimateUri($uri, true);
        if (!$portal) {
            throw new NotFoundHttpException($translator->trans('front.404', [], 'errors'));
        }

        $generalTheories = $this->getDoctrine()->getRepository(Theory::class)
            ->getGeneralTheories($portal->getId());

        $tableOfContent = $this->getDoctrine()->getRepository(Theory::class)
            ->getPortalTheoriesTree($portal->getId());

        $hasTopics = $this->getDoctrine()->getRepository(Topic::class)
            ->existForPortal($portal->getId());
        $hasArticles = $this->getDoctrine()->getRepository(Article::class)
            ->existForPortal($portal->getId());
        $hasLyrics = $this->getDoctrine()->getRepository(Lyric::class)
            ->existForPortal($portal->getId());

        return [
            'portal' => $portal,
            'general_theories' => $generalTheories,
            'has_topics' => $hasTopics,
            'has_articles' => $hasArticles,
            'has_lyrics' => $hasLyrics,
            'table_of_content' => $tableOfContent
        ];
    }
}
