<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Container\ContainerInterface as Container;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\Translation\TranslatorInterface as Translator;

use App\Entity\Portal;

use App\Controller\Library\Abstracts\PagefulController;

use App\Utility\StaticLibrary;

/**
 * Class HomepageController
 *
 * @package App\Controller\Front
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class HomepageController extends PagefulController
{
    /**
     * Render Homepage
     *
     * @param Request $request
     * @return RedirectResponse|Response|array
     * @Route("/",
     *         methods={"GET"},
     *         name="homepage_index"
     * )
     * @Template()
     */
    public function index(Request $request)
    {
        $portals = $this->getDoctrine()->getRepository(Portal::class)->getEnabled();

        # @TODO: $this->get('app.seo')->generateForIndexPage()
        $seo = null;

        return [
            'portals' => $portals,
            'seo' => $seo
        ];
    }

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
    public function renderHeader(
        Request $request,
        Translator $translator,
        string $route,
        array $routeParams,
        string $url
    ): Response
    {
        $user = $this->getUser();

        # @TODO: menu
        # @TODO: $backLink -> check if it's own link
//        $selfContainer = $this->get('app.self.container');
//        $prevUrl = $selfContainer->previousUrl();
        $backLink = null;

        $queryParameters = StaticLibrary::cutUrlQueryParameters($url);
        $langSwitcher = $this->get('app.lang.switcher')
            ->init($request)
            ->setRoute($route)
            ->setRouteParameters($routeParams)
            ->setQueryParameters($queryParameters)
            ->getSwitcher();

        return $this->render('homepage/header.html.twig', [
            'user' => $user,
            'language_switcher' => $langSwitcher,
            'back_link' => $backLink
        ]);
    }

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
    public function renderFooter(
        Request $request,
        Translator $translator,
        string $route,
        array $routeParams,
        string $url
    ): Response
    {
        $user = $this->getUser();

        # @TODO: $footerItems

        $queryParameters = StaticLibrary::cutUrlQueryParameters($url);
        $langSwitcher = $this->get('app.lang.switcher')
            ->init($request)
            ->setRoute($route)
            ->setRouteParameters($routeParams)
            ->setQueryParameters($queryParameters)
            ->getSwitcher();

        return $this->render('homepage/footer.html.twig', [
            'user' => $user,
            'language_switcher' => $langSwitcher
        ]);
    }
}
