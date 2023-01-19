<?php


declare(strict_types=1);

/*
 * This file is part of Contao Clickskeks Bundle.
 *
 * (c) Stefan Schulz-Lauterbach (https://clickpress.de)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clickpress\ContaoClickskeksBundle\Controller\ContentElement;

use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\ServiceAnnotation\ContentElement;
use Contao\ContentModel;
use Contao\BackendTemplate;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\PageModel;
use Contao\System;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @ContentElement(category="texts")
 */
class ContaoClickskeksController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {

        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $template = new BackendTemplate('be_wildcard');
            return $template->getResponse();
        }

        $rootPage = $this->getPageModel();
        $objRootPage = PageModel::findByPk($rootPage->rootId);

        // check if a specific language is set to the bar
        if($objRootPage->clickskeks_language) {
            $template->clickskeks_language = $objRootPage->clickskeks_language;
        }

        return $template->getResponse();
    }
}
