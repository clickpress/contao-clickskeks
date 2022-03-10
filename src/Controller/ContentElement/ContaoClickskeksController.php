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
use Contao\PageModel;
use Contao\System;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @ContentElement(category="texts")
 */
class ContaoClickskeksController extends AbstractContentElementController
{
    protected string $strDisclaimerUrl = 'https://static.clickskeks.at/%s/%s/%s/disclaimer.js';

    protected function getResponse(Template $template, ContentModel $model, Request $request): ?Response
    {
        global $objPage;
        $objRootPage = PageModel::findByPk($objPage->rootId);
        $html = sprintf(
            $this->strDisclaimerUrl,
            substr($objRootPage->clickskeks_api_key, 0, 2),
            substr($objRootPage->clickskeks_api_key, 2, 2),
            $objRootPage->clickskeks_api_key
        );
        
        $template->clickskeks_disclaimer_url = $html;
        dump($model);

        return $template->getResponse();
    }
}
