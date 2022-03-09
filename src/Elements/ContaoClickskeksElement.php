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

namespace Clickpress\ContaoClickskeksBundle\Elements;

use Contao\BackendTemplate;
use Contao\ContentElement;
use Contao\PageModel;
use Contao\System;

class ContaoClickskeksElement extends ContentElement
{
    protected $strTemplate = 'ce_clickskeks_disclaimer';
    protected string $strDisclaimerUrl = 'https://static.clickskeks.at/%s/%s/%s/disclaimer.js';

    /**
     * Compile the content element.
     */
    public function compile(): void
    {
        $request = System::getContainer()->get('request_stack')->getCurrentRequest();

        if ($request && System::getContainer()->get('contao.routing.scope_matcher')->isBackendRequest($request)) {
            $this->strTemplate = 'be_wildcard';
            $this->Template = new BackendTemplate($this->strTemplate);
            $this->Template->title = 'Clickskeks disclaimer element';
        } else {

            global $objPage;
            $objRootPage = PageModel::findByPk($objPage->rootId);

            if (null === $objRootPage || null === $objRootPage->clickskeks_active || null === $objRootPage->clickskeks_api_key) {
                return;
            }

            $html = sprintf(
                $this->strDisclaimerUrl,
                substr($objRootPage->clickskeks_api_key, 0, 2),
                substr($objRootPage->clickskeks_api_key, 2, 2),
                $objRootPage->clickskeks_api_key
            );

            $this->Template->clickskeks_diclaimer_url = $html;
        }
    }
}
