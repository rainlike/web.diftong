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
     * @param string $name
     * @return RedirectResponse|Response|array
     * @Route("/{name}",
     *         methods={"GET"},
     *         name="portal_show"
     * )
     * @Template()
     */
    public function show(
        Request $request,
        Translator $translator,
        string $name
    ) {
        $portal = $this->getDoctrine()->getRepository(Portal::class)->findOneBy(['slug' => $name]);
        if (!$portal) {
            throw new NotFoundHttpException($translator->trans('front.404', [], 'errors'));
        }

        $generalTheories = $this->getDoctrine()->getRepository(Theory::class)
            ->getGeneralTheories($portal->getId());
        $topics = $this->getDoctrine()->getRepository(Topic::class)
            ->getGeneralTheories($portal->getId());

        var_dump($generalTheories);exit;

        return [
            'portal' => $portal
        ];
    }
}