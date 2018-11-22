<?php
declare(strict_types=1);

namespace App\Controller\Library\Abstracts;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Translation\TranslatorInterface as Translator;

/**
 * Class PagefulController
 *
 * @package App\Controller\Library\Abstracts
 */
abstract class PagefulController extends Controller
{
    /**
     * Render header
     *
     * @param Request $request
     * @param Translator $translator
     * @param string $route
     * @param array $routeParams
     * @param string $url
     * @return Response
     */
    abstract public function renderHeader(
        Request $request,
        Translator $translator,
        string $route,
        array $routeParams,
        string $url
    ): Response;

    /**
     * Render footer
     *
     * @param Request $request
     * @param Translator $translator
     * @param string $route
     * @param array $routeParams
     * @param string $url
     * @return Response
     */
    abstract public function renderFooter(
        Request $request,
        Translator $translator,
        string $route,
        array $routeParams,
        string $url
    ): Response;
}
