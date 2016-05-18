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
use NotificationCenter\Model\Notification;


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
        \System::loadLanguageFile('tl_module');

        /** @var \FrontendTemplate|object $objTemplate */
        $objTemplate = new \FrontendTemplate('er_registration');

        $objTemplate->hasError = false;
        $msgError = array();

        $objTemplate->type = $GLOBALS['TL_LANG']['tl_module']['regtypes'][$this->regtype];

        // Id der Benachrichtigung
        $ncid = $this->regform;

        // Get the input parameter
        $lead_id = (\Input::get('lead')) ? \Input::get('lead') : 0;
        $event_id = (\Input::get('event')) ? \Input::get('event') : 0;
        $email = (\Input::get('email')) ? \Input::get('email') : 0;

        // Throw Exception if parameter is missing
        if ($lead_id === 0) {
            $objTemplate->hasError = true;
            $msgError[] = 'Parameter lead fehlt...';
        }
        if ($event_id === 0) {
            $objTemplate->hasError = true;
            $msgError[] = 'Parameter event fehlt...';
        }
        if ($email === 0) {
            $objTemplate->hasError = true;
            $msgError[] = 'Parameter email fehlt...';
        }

        // Sind Fehler aufgetreten, dann die Meldungen zuweisen...
        if ($objTemplate->hasError) {
            $objTemplate->msgError = $msgError;

        // Sind keine aufgetreten, dann weiter
        } else {
            // $event = \CalendarEventsModel::findById($event_id);
//            $lead = \CalendarLeadsModel::updateByLeadEventMail((int)$lead_id, (int)$event_id, $email, (int)$this->regtype);
//            $objTemplate->msg = $lead;
        }

        // Jetzt noch die notification_center mais raus
        $objNotification = \NotificationCenter\Model\Notification::findByPk($ncid);
        $arrTokens['recipient_email'] = $email;
        $arrTokens['domain'] = \Idna::decode(\Environment::get('host'));
        if (null !== $objNotification) {
            $objNotification->send($arrTokens);
        }

        $this->Template->event_registration = $objTemplate->parse();
    }
}
