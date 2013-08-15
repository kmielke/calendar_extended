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

#$GLOBALS['TL_DCA']['tl_module']['palettes']['calendar']    = '{title_legend},name,headline,type;{config_legend},cal_calendar,cal_noSpan,cal_startDay;{redirect_legend},jumpTo;{template_legend:hide},cal_ctemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
#$GLOBALS['TL_DCA']['tl_module']['palettes']['calendar']    = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,cal_startDay;{redirect_legend},jumpTo;{template_legend:hide},calext_ctemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['calendar'] = str_replace
(
    '{config_legend},cal_calendar,',
    '{config_legend},cal_calendar_ext,cal_holiday,',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['calendar']
);

#$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist']   = '{title_legend},name,headline,type;{config_legend},cal_calendar,cal_noSpan,cal_format,cal_ignoreDynamic,cal_order,cal_readerModule,cal_limit,perPage;{template_legend:hide},cal_template,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
#$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist']   = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,showRecurrences,cal_format,cal_ignoreDynamic,cal_order,cal_readerModule,cal_limit,perPage;{template_legend:hide},cal_template,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist'] = str_replace
(
    '{config_legend},cal_calendar,cal_noSpan,',
    '{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,showRecurrences,',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['eventlist']
);

#$GLOBALS['TL_DCA']['tl_module']['palettes']['eventreader'] = '{title_legend},name,headline,type;{config_legend},cal_calendar;{template_legend:hide},cal_template,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

#$GLOBALS['TL_DCA']['tl_module']['palettes']['eventmenu']   = '{title_legend},name,headline,type;{config_legend},cal_calendar,cal_noSpan,cal_showQuantity,cal_format,cal_startDay,cal_order;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
#$GLOBALS['TL_DCA']['tl_module']['palettes']['eventmenu']   = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,cal_showQuantity,cal_format,cal_startDay,cal_order;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
//$GLOBALS['TL_DCA']['tl_module']['palettes']['eventmenu'] = str_replace
//(
//    '{config_legend},cal_calendar,',
//    '{config_legend},cal_calendar_ext,cal_holiday,',
//    $GLOBALS['TL_DCA']['tl_module']['palettes']['eventmenu']
//);

$GLOBALS['TL_DCA']['tl_module']['palettes']['timetable'] = $GLOBALS['TL_DCA']['tl_module']['palettes']['calendar'];
$GLOBALS['TL_DCA']['tl_module']['palettes']['timetable'] = str_replace
(
    ',cal_ctemplate;{protected_legend:hide}',
    ',cal_ctemplate,showDate,hideEmptyDays,use_navigation,linkCurrent,cal_times;{protected_legend:hide}',
    $GLOBALS['TL_DCA']['tl_module']['palettes']['timetable']
);

#$GLOBALS['TL_DCA']['tl_module']['palettes']['timetableExt']   = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,cal_startDay;{redirect_legend},jumpTo;{template_legend:hide},cal_ctemplate,showDate,hideEmptyDays,use_navigation,linkCurrent,cal_times;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

#$GLOBALS['TL_DCA']['tl_module']['palettes']['yearview']     = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan;{redirect_legend},jumpTo;{template_legend:hide},calext_ctemplate,use_navigation,linkCurrent;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

/**
 * Add fields to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['fields']['cal_calendar_ext'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_calendar_ext'],
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

$GLOBALS['TL_DCA']['tl_module']['fields']['showRecurrences'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_module']['showRecurrences'],
    'default'               => 0,
    'exclude'               => true,
    'inputType'             => 'checkbox',
    'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_ctemplate'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cal_ctemplate'],
    'default'                 => 'cal_default',
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('tl_module_calendar', 'getCalendarTemplates'),
#    'eval'                    => array('tl_class'=>'w50'),
    'sql'                     => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['use_navigation'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['use_navigation'],
	'default'               => 1,
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array('tl_class'=>'w50'),
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

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_noSpan'] = array
(
    'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_noSpan'],
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
