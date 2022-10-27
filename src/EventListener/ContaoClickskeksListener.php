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

namespace Clickpress\ContaoClickskeksBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\DataContainer;
use Contao\LayoutModel;
use Contao\PageModel;
use Contao\PageRegular;
use Database;
use Terminal42\ServiceAnnotationBundle\ServiceAnnotationInterface;


/**
 * ContaoClickskeksListener
 *
 * Inject the clickskeks script into head
 *
 * @author Stefan Schulz-Lauterbach <ssl@clickpress.de>
 */

class ContaoClickskeksListener implements ServiceAnnotationInterface
{

    private string $html =  '<script src="https://mein.clickskeks.at/app.js?apiKey=%s&amp;domain=%s%s" referrerpolicy="origin"></script>';

    /**
     * @Hook("modifyFrontendPage")
     */
    public function __invoke(string $buffer, string $templateName): string
    {

        if (strpos($templateName, 'fe_', 0) !== 0) {
            return $buffer;
        }

        global $objPage;
        $objRootPage = PageModel::findByPk($objPage->rootId);

        // check if null, to prevent that the bar is loaded, even if the checkbox 'activate clickskeks' is not checked
        if (null === $objRootPage || null === $objRootPage->clickskeks_active || null === $objRootPage->clickskeks_api_key || null === $objRootPage->clickskeks_domain_key || null === $objRootPage->clickskeks_language) {
            return $buffer;
        }

        // check if a specific language is set to the bar
        $barLanguage = '';
        if($objRootPage->clickskeks_language) {
            $barLanguage = '&amp;lang='.$objRootPage->clickskeks_language;
        }

        $html = sprintf(
            $this->html,
            $objRootPage->clickskeks_api_key,
            $objRootPage->clickskeks_domain_key,
            $barLanguage
        );

        return preg_replace('/(<head>)/s', "$1\n$html", $buffer);
    }
}
