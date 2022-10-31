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

$GLOBALS['TL_DCA']['tl_page']['subpalettes']['clickskeks_active'] = 'clickskeks_api_key,clickskeks_domain_key,clickskeks_language';

$GLOBALS['TL_DCA']['tl_page']['fields']['clickskeks_active'] = array(
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => array('submitOnChange' => true),
    'sql' => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['clickskeks_api_key'] = array(
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('decodeEntities' => true, 'tl_class' => 'w50'),
    'sql' => "text default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['clickskeks_domain_key'] = array(
    'exclude' => true,
    'search' => true,
    'inputType' => 'text',
    'eval' => array('decodeEntities' => true, 'tl_class' => 'w50'),
    'sql' => "text default ''"
);

$GLOBALS['TL_DCA']['tl_page']['fields']['clickskeks_language'] = array(
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>5, 'nospace'=>true, 'decodeEntities'=>true, 'doNotCopy'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(5) NOT NULL default ''"
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
