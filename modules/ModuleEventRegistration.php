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
    protected $strTemplate = 'mod_evr_registration';


    /**
     * Do not show the module if no calendar has been selected
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE') {
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['evr_registration'][0]) . ' ###';
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
        $objTemplate = new \FrontendTemplate('evr_registration');

        $objTemplate->hasError = false;
        $msgError = array();

        $objTemplate->type = $GLOBALS['TL_LANG']['tl_module']['regtypes'][$this->regtype];

        // Id der Benachrichtigung
        $ncid = $this->nc_notification;

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

            global $objPage;

            // Jetzt noch die notification_center mais raus
            $objNotification = \NotificationCenter\Model\Notification::findByPk($ncid);
            if (null !== $objNotification) {
                $arrTokens = array();
                $objResult = \CalendarLeadsModel::findByLeadEventMail($lead_id, $event_id, $email);

                if ($objResult !== null) {
                    // zuerst den entsprechenden Datensatz updaten...
                    $published = $this->regtype;
                    $result = \CalendarLeadsModel::updateByPid($objResult->pid, $published);

                    if ($result) {
                        // Dann bauen wir arrTokens für die Nachrichten
                        $arrRawData = array();
                        while ($objResult->next()) {
                            $arrTokens['recipient_' . $objResult->name] = $objResult->value;
                            $arrRawData[] = ucfirst($objResult->name) . ': ' . $objResult->value;
                        }
                        $arrTokens['raw_data'] = implode('<br>', $arrRawData);
                        unset($arrRawData);
                        $arrTokens['recipients'] = array($email, $objPage->adminEmail);
                        $arrTokens['page_title'] = $objPage->pageTitle;
                        $arrTokens['admin_email'] = $objPage->adminEmail;

                        // und dann senden wir die Nachrichten
                        $objNotification->send($arrTokens, $GLOBALS['TL_LANGUAGE']);
                    } else {
                        $objTemplate->hasError = true;
                        $msgError[] = 'Fehler bei DB Update.';
                    }
                } else {
                    $objTemplate->hasError = true;
                    $msgError[] = 'Keine Daten gefunden.';
                }
            }
        }

        $this->Template->event_registration = $objTemplate->parse();
    }
}
