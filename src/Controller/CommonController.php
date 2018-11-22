<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommonController
 *
 * @package App\Controller
 * @author Alexander Saveliev <alex@spbcrew.com>
 */
class CommonController extends Controller
{
    /**
     * Redirect URLs with a trailing slash
     *
     * @param Request $request
     * @return RedirectResponse
     * @Route("/{url}",
     *         methods={"GET"},
     *         name="remove_trailing_slash",
     *         requirements={"url" = ".*\/$"}
     * )
     */
    public function removeTrailingSlash(Request $request): RedirectResponse
    {
        $pathInfo = $request->getPathInfo();
        $requestUri = $request->getRequestUri();

        $url = \str_replace($pathInfo, \rtrim($pathInfo, ' /'), $requestUri);

        return $this->redirect($url, 301);
    }
}
