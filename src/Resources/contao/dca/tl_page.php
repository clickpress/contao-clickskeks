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

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_page']['palettes']['__selector__'][] = 'clickskeks_active';

$GLOBALS['TL_DCA']['tl_page']['subpalettes']['clickskeks_active'] = 'clickskeks_key';

$GLOBALS['TL_DCA']['tl_page']['fields']['clickskeks_active'] = array(
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('submitOnChange' => true),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['clickskeks_key'] = array(
    'exclude' => true,
    'search' => true,
    'inputType' => 'textarea',
    'eval' => array('decodeEntities' => false, 'tl_class' => 'w50', 'allowHtml' => true),
    'sql' => "String NOT NULL default ''"
);


if (isset($GLOBALS['TL_DCA']['tl_page']['palettes']['rootfallback'])) {
    PaletteManipulator::create()
        ->addLegend('clickskeks_legend', 'publish_legend', PaletteManipulator::POSITION_BEFORE)
        ->addField('clickskeks_active', 'clickskeks_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('root', 'tl_page')
        ->applyToPalette('rootfallback', 'tl_page')
    ;
} else {
    PaletteManipulator::create()
        ->addLegend('clickskeks_legend', 'publish_legend', PaletteManipulator::POSITION_BEFORE)
        ->addField('clickskeks_active', 'clickskeks_legend', PaletteManipulator::POSITION_APPEND)
        ->applyToPalette('root', 'tl_page');
}
