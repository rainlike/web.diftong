<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Container\ContainerInterface as Container;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

/**
 * Class HomepageController
 *
 * @package App\Controller\Front
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class HomepageController extends Controller
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
}
