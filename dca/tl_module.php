<?php 

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2012 Leo Feyer
 * 
 * @package   Contao 
 * @author    Kester Mielke 
 * @license   LGPL 
 * @copyright Kester Mielke 2010-2013 
 */


/**
 * Add palettes to tl_module
 */

// Palette for calendar
$GLOBALS['TL_DCA']['tl_module']['palettes']['calendar'] = str_replace
(
    '{config_legend},cal_calendar,',
    '{config_legend},cal_calendar,cal_holiday,',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['calendar']
);

// Palette for eventlist
$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist'] = str_replace
(
    '{config_legend},cal_calendar,cal_noSpan,',
    '{config_legend},cal_calendar,cal_holiday,cal_noSpan,pubTimeRecurrences,displayDuration,showOnlyNext,showRecurrences,',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist']
);

// Palette for timetable
$GLOBALS['TL_DCA']['tl_module']['palettes']['timetable'] = $GLOBALS['TL_DCA']['tl_module']['palettes']['calendar'];
$GLOBALS['TL_DCA']['tl_module']['palettes']['timetable'] = str_replace
(
    ',cal_ctemplate;{protected_legend:hide}',
    ',cal_ctemplate,showDate,hideEmptyDays,use_navigation,linkCurrent,cal_times;{protected_legend:hide}',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['timetable']
);

// Palette for yearview
$GLOBALS['TL_DCA']['tl_module']['palettes']['yearview'] = $GLOBALS['TL_DCA']['tl_module']['palettes']['calendar'];
$GLOBALS['TL_DCA']['tl_module']['palettes']['yearview'] = str_replace
(
    ',cal_ctemplate;{protected_legend:hide}',
    ',cal_ctemplate,use_horizontal,use_navigation,linkCurrent;{protected_legend:hide}',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['yearview']
);

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['cal_calendar'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_calendar'],
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'options_callback'      => array('calendar_Ext', 'getCalendars'),
	'eval'                  => array('mandatory'=>true, 'multiple'=>true),
    'sql'                   => "text NULL"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_holiday'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_holiday'],
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'options_callback'      => array('calendar_Ext', 'getHolidays'),
	'eval'                  => array('mandatory'=>false, 'multiple'=>true),
    'sql'                   => "text NULL"
);

// $GLOBALS['TL_DCA']['tl_module']['fields']['cal_noSpan']['eval']['tl_class'] = 'w50';

$GLOBALS['TL_DCA']['tl_module']['fields']['pubTimeRecurrences'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_module']['pubTimeRecurrences'],
    'default'               => 0,
    'exclude'               => true,
    'inputType'             => 'checkbox',
    'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['displayDuration'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_module']['displayDuration'],
    'default'               => 0,
    'exclude'               => true,
    'inputType'             => 'text',
    'eval'                  => array('tl_class'=>'w50'),
    'save_callback'     => array
    (
        array('calendar_Ext', 'checkDuration')
    ),
    'sql'                   => "varchar(128) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['showOnlyNext'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_module']['showOnlyNext'],
    'default'               => 0,
    'exclude'               => true,
    'inputType'             => 'checkbox',
    'eval'                  => array('tl_class'=>'clr w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['showRecurrences'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_module']['showRecurrences'],
    'default'               => 0,
    'exclude'               => true,
    'inputType'             => 'checkbox',
    'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['use_horizontal'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['use_horizontal'],
	'default'               => 0,
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array('tl_class'=>'w50 m12'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['use_navigation'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['use_navigation'],
	'default'               => 1,
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array('tl_class'=>'w50 clr'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['showDate'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['showDate'],
	'default'               => 1,
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['linkCurrent'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['linkCurrent'],
	'default'               => 1,
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['hideEmptyDays'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['hideEmptyDays'],
	'default'               => 1,
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_times'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_times'],
    'exclude'               => true,
    'inputType'             => 'checkbox',
    'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

/**
 * Class timetableExt
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Kester Mielke 2011
 * @author     Kester Mielke
 * @package    Controller
 */
class calendar_Ext extends Backend
{

	/**
	 * Import the back end user object
	 */
	public function __construct()
	{
		parent::__construct();
		$this->import('BackendUser', 'User');
	}


    /**
     * @param $varValue
     * @param $dc
     * @return mixed
     */
    public function checkDuration($varValue, $dc)
    {
        if (strlen($varValue) > 0)
        {
            if (($timestamp = strtotime($varValue)) === false)
            {
                throw new Exception($GLOBALS['TL_LANG']['tl_module']['displayDurationError'].': '.$timestamp);
            }
        }
        return $varValue;
    }


	/**
	 * Get all calendars and return them as array
	 * @return array
	 */
	public function getCalendars()
	{
		if (!$this->User->isAdmin && !is_array($this->User->calendars))
		{
			return array();
		}

		$arrCalendars = array();
		$objCalendars = $this->Database->execute("SELECT id, title FROM tl_calendar WHERE isHolidayCal != 1 ORDER BY title");

		while ($objCalendars->next())
		{
			if ($this->User->isAdmin || $this->User->hasAccess($objCalendars->id, 'calendars'))
			{
				$arrCalendars[$objCalendars->id] = $objCalendars->title;
			}
		}

		return $arrCalendars;
	}


	/**
	 * Get all calendars and return them as array
	 * @return array
	 */
	public function getHolidays()
	{
		if (!$this->User->isAdmin && !is_array($this->User->calendars))
		{
			return array();
		}

		$arrCalendars = array();
		$objCalendars = $this->Database->execute("SELECT id, title FROM tl_calendar WHERE isHolidayCal = 1 ORDER BY title");

		while ($objCalendars->next())
		{
			if ($this->User->isAdmin || $this->User->hasAccess($objCalendars->id, 'calendars'))
			{
				$arrCalendars[$objCalendars->id] = $objCalendars->title;
			}
		}

		return $arrCalendars;
	}
}
