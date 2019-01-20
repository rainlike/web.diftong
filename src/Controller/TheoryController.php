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

use App\Entity\Theory;

/** @package App\Controller */
class TheoryController extends AbstractController
{
    /**
     * Render Theory page
     *
     * @param Request $request
     * @param Translator $translator
     * @param string $portal_name
     * @param string $slug
     * @return RedirectResponse|Response|array
     * @Route("/{portal_name}/{slug}",
     *         methods={"GET"},
     *         name="theory_show"
     * )
     * @Template()
     */
    public function show(
        Request $request,
        Translator $translator,
        string $portal_name,
        string $slug
    ) {
        return [];
    }
}
