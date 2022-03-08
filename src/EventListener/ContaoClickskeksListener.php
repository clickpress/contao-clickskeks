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

        if (null === $objRootPage || null === $objRootPage->clickskeks_active || null === $objRootPage->clickskeks_api_key) {
            return $buffer;
        }

        $html = '<script src="https://static.clickskeks.at/ff/5b/%s/bundle.js" type="application/javascript"></script>';

        $html = sprintf($html, $objRootPage->clickskeks_api_key);

        return preg_replace('/(<head>)/s', "$1\n$html", $buffer);
    }
}