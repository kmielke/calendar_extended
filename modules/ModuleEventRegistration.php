<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   Contao
 * @author    Kester Mielke
 * @license   LGPL
 * @copyright Kester Mielke 2010-2013
 */

namespace Contao;


/**
 * Class ModuleEventRegistration
 *
 * @author     Kester Mielke
 */
class ModuleEventRegistration extends \Module
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'mod_er_registration';


    /**
     * Do not show the module if no calendar has been selected
     * 
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['er_registration'][0]) . ' ###';
            $objTemplate->title = $this->headline;
            $objTemplate->id = $this->id;
            $objTemplate->link = $this->name;
            $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        return parent::generate();
    }


    /**
     * Generate module
     */
    protected function compile()
    {
        die("Modul wird ausgeführt");

        /** @var \FrontendTemplate|object $objTemplate */
        $objTemplate = new \FrontendTemplate('er_registration');

        $this->Template->event_registration = $objTemplate->parse();
    }
}
