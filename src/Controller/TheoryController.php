<?php
/**
 * Theory Controller
 * Contains actions for separate & common pages of Theories
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

use App\Service\Breadcrumbs;

use App\Entity\Theory;

/** @package App\Controller */
class TheoryController extends AbstractController
{
    /**
     * Render Theory page
     *
     * @param Request $request
     * @param Translator $translator
     * @param Breadcrumbs $breadcrumbsSrv
     * @param string $portal_uri
     * @param string $uri
     * @return RedirectResponse|Response|array
     * @throws NonUniqueResultException
     * @Route("/{portal_uri}/{uri}",
     *         methods={"GET"},
     *         name="theory_show"
     * )
     * @Template()
     */
    public function show(
        Request $request,
        Translator $translator,
        Breadcrumbs $breadcrumbsSrv,
        string $portal_uri,
        string $uri
    ) {
        $repository = $this->getDoctrine()->getRepository(Theory::class);

        $theory = $repository->findByUltimateUri($uri, true, $portal_uri);
        if (!$theory) {
            throw new NotFoundHttpException($translator->trans('front.404', [], 'errors'));
        }

        $breadcrumbs = $breadcrumbsSrv->getBreadcrumbs($theory->getId());

        $next = $theory->getNext();
        $nextTheory = $next
            ? [
                'caption' => $next->getCaption(),
                'uri' => $next->getUltimateUri()
            ]
            : null;

        $previous = $theory->getPrevious();
        $previousTheory = $previous
            ? [
                'caption' => $previous->getCaption(),
                'uri' => $previous->getUltimateUri()
            ]
            : null;

        $tableOfContent = null;
        $tableOfContentTitle = null;
        if ($theory->getGeneral() || $theory->isPreGeneral()) {
            $tableOfContent = $repository->getAllChildren($theory->getId());
            $tableOfContentTitle = $theory->getCaption();
        } else {
            $preGeneralTheory = $this->getDoctrine()->getRepository(Theory::class)
                ->getPreGeneralParent($theory->getId());
            $tableOfContent = $repository->getAllChildren($preGeneralTheory['id']);
            $tableOfContentTitle = $preGeneralTheory['caption'];
        }

        return [
            'theory' => $theory,
            'portal_uri' => $portal_uri,
            'previous' => $previousTheory,
            'next' => $nextTheory,
            'breadcrumbs' => $breadcrumbs,
            'table_of_content' => $tableOfContent,
            'table_of_content_title' => $tableOfContentTitle
        ];
    }
}
