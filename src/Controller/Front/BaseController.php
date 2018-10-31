<?php
declare(strict_types=1);

namespace App\Controller\Front;

use Psr\Container\ContainerInterface as Container;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;

use Symfony\Component\Translation\Exception\InvalidArgumentException;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Class BaseController
 *
 * @package App\Controller\Front
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class BaseController extends Controller
{
    /**
     * Render Index page
     *
     * @param Request $request
     * @return RedirectResponse|Response|array
     * @throws RouteNotFoundException
     * @throws MissingMandatoryParametersException
     * @throws InvalidParameterException|InvalidArgumentException
     * @Route("/",
     *         methods={"GET"},
     *         name="front_index_page"
     * )
     * @Template()
     */
    public function index(Request $request)
    {
        $temp = 1;

        return [
            'temp' => $temp
        ];
    }
}
