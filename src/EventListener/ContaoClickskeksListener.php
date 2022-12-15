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

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\PageModel;


/**
 * ContaoClickskeksListener
 *
 * Inject the clickskeks script into head
 *
 * @author Stefan Schulz-Lauterbach <ssl@clickpress.de>
 */

class ContaoClickskeksListener
{

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
        if (null === $objRootPage || null === $objRootPage->clickskeks_active || null === $objRootPage->clickskeks_key) {
            return $buffer;
        }

        //decode at this point because the pallete decode dosnt work correctly
        $html =html_entity_decode($objRootPage->clickskeks_key);

        return preg_replace('/(<head>)/s', "$1\n$html", $buffer);
    }
}
