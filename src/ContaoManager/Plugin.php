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

namespace Clickpress\ContaoClickskeksBundle\ContaoManager;

use Clickpress\ContaoClickskeksBundle\ContaoClickskeksBundle;
use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(ContaoClickskeksBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}