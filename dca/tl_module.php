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
$GLOBALS['TL_DCA']['tl_module']['palettes']['calendarExt']    = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,cal_startDay;{redirect_legend},jumpTo;{template_legend:hide},calext_ctemplate;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['eventlistExt']   = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,showRecurrences,cal_format,cal_ignoreDynamic,cal_order,cal_readerModule,cal_limit,perPage;{template_legend:hide},cal_template,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['timetableExt']   = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,cal_startDay;{redirect_legend},jumpTo;{template_legend:hide},calext_ctemplate,showDate,hideEmptyDays,use_navigation,linkCurrent,cal_times;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['yearviewExt']    = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan;{redirect_legend},jumpTo;{template_legend:hide},calext_ctemplate,use_navigation,linkCurrent;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['eventmenuExt']   = '{title_legend},name,headline,type;{config_legend},cal_calendar_ext,cal_holiday,cal_noSpan,cal_showQuantity,cal_format,cal_startDay,cal_order;{redirect_legend},jumpTo;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';
$GLOBALS['TL_DCA']['tl_module']['palettes']['eventreaderExt'] = '{title_legend},name,headline,type;{config_legend},cal_calendar;{template_legend:hide},cal_template,imgSize;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space';

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

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_readerModule'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cal_readerModule'],
    'exclude'                 => true,
    'inputType'               => 'select',
    'options_callback'        => array('calendar_Ext', 'getReaderModules'),
    'reference'               => &$GLOBALS['TL_LANG']['tl_module'],
    'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
    'sql'                     => "int(10) unsigned NOT NULL default '0'"
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

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_format'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_format'],
	'default'               => 'cal_month',
	'exclude'               => true,
	'inputType'             => 'select',
	'options_callback'      => array('tl_module_calendar', 'getFormats'),
	'reference'             => &$GLOBALS['TL_LANG']['tl_module'],
	'eval'                  => array('tl_class'=>'w50'),
	'wizard' => array
	(
		array('tl_module_calendar', 'hideStartDay')
	),
    'sql'                   => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_order'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_order'],
	'default'               => 'ascending',
	'exclude'               => true,
	'inputType'             => 'select',
	'options'               => array('ascending', 'descending'),
	'reference'             => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_noSpan'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_noSpan'],
	'exclude'               => true,
	'inputType'             => 'checkbox',
	'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_limit'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_limit'],
	'exclude'               => true,
	'inputType'             => 'text',
	'eval'                  => array('rgxp'=>'digit', 'tl_class'=>'w50'),
    'sql'                   => "smallint(5) unsigned NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_startDay'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_startDay'],
	'default'               => 1,
	'exclude'               => true,
	'inputType'             => 'select',
	'options'               => array(0, 1, 2, 3, 4, 5, 6),
	'reference'             => &$GLOBALS['TL_LANG']['DAYS'],
	'eval'                  => array('tl_class'=>'w50 cbx'),
    'sql'                   => "smallint(5) unsigned NOT NULL default '0'"
);

//$GLOBALS['TL_DCA']['tl_module']['fields']['cal_times'] = array
//(
//	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['cal_times'],
//	'exclude'                 => true,
//	'inputType'               => 'checkbox',
//	'eval'                    => array('tl_class'=>'w50'),
//    'sql'                   => "char(1) NOT NULL default ''"
//);

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_template'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_template'],
	'default'               => 'event_full',
	'exclude'               => true,
	'inputType'             => 'select',
	'options_callback'      => array('tl_module_calendar', 'getEventTemplates'),
	'eval'                  => array('tl_class'=>'w50'),
    'sql'                   => "varchar(32) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['calext_ctemplate'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['calext_ctemplate'],
	'default'               => 'calext_default',
	'exclude'               => true,
	'inputType'             => 'select',
	'options_callback'      => array('calendar_Ext', 'getCalendarTemplates'),
    'sql'                   => "varchar(32) NOT NULL default ''"
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

$GLOBALS['TL_DCA']['tl_module']['fields']['showRecurrences'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['showRecurrences'],
	'default'               => 0,
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

$GLOBALS['TL_DCA']['tl_module']['fields']['cal_showQuantity'] = array
(
	'label'                 => &$GLOBALS['TL_LANG']['tl_module']['cal_showQuantity'],
	'exclude'               => true,
	'inputType'             => 'checkbox',
    'sql'                   => "char(1) NOT NULL default ''"
);

/**
 * Add the comments template drop-down menu
 */
if (in_array('comments', Config::getInstance()->getActiveModules()))
{
	$GLOBALS['TL_DCA']['tl_module']['palettes']['eventreaderExt'] = str_replace('{protected_legend:hide}', '{comment_legend:hide},com_template;{protected_legend:hide}', $GLOBALS['TL_DCA']['tl_module']['palettes']['eventreaderExt']);
}


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


    /**
     * Get all event reader modules and return them as array
     * @return array
     */
    public function getReaderModules()
    {
        $arrModules = array();
        $objModules = $this->Database->execute("SELECT m.id, m.name, t.name AS theme FROM tl_module m LEFT JOIN tl_theme t ON m.pid=t.id WHERE m.type in('eventreader','eventreaderExt') ORDER BY t.name, m.name");

        while ($objModules->next())
        {
            $arrModules[$objModules->theme][$objModules->id] = $objModules->name . ' (ID ' . $objModules->id . ')';
        }

        return $arrModules;
    }


    /**
	 * Return all calendar templates as array
	 * @param object
	 * @return array
	 */
	public function getCalendarTemplates(DataContainer $dc)
	{
		$intPid = $dc->activeRecord->pid;

		if ($this->Input->get('act') == 'overrideAll')
		{
			$intPid = $this->Input->get('id');
		}

		return $this->getTemplateGroup('calext_', $intPid);
	}

}
