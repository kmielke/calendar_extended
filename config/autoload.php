<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\EventsExt'               => 'system/modules/calendar_extended/classes/EventsExt.php',
	'Contao\TimePeriodExt'           => 'system/modules/calendar_extended/classes/TimePeriodExt.php',

	// Models
	'Contao\CalendarEventsModelExt'  => 'system/modules/calendar_extended/models/CalendarEventsModelExt.php',
	'Contao\CalendarLeadsModel'      => 'system/modules/calendar_extended/models/CalendarLeadsModel.php',

	// Modules
	'Contao\ModuleCalendar'          => 'system/modules/calendar_extended/modules/ModuleCalendar.php',
	'Contao\ModuleEventlist'         => 'system/modules/calendar_extended/modules/ModuleEventlist.php',
	'Contao\ModuleEventMenu'         => 'system/modules/calendar_extended/modules/ModuleEventMenu.php',
	'Contao\ModuleEventReader'       => 'system/modules/calendar_extended/modules/ModuleEventReader.php',
	'Contao\ModuleEventRegistration' => 'system/modules/calendar_extended/modules/ModuleEventRegistration.php',
	'Contao\ModuleFullcalendar'      => 'system/modules/calendar_extended/modules/ModuleFullcalendar.php',
	'Contao\ModuleTimeTable'         => 'system/modules/calendar_extended/modules/ModuleTimeTable.php',
	'Contao\ModuleYearView'          => 'system/modules/calendar_extended/modules/ModuleYearView.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'cal_fc_default'       => 'system/modules/calendar_extended/templates',
	'cal_fc_google'        => 'system/modules/calendar_extended/templates',
	'cal_timetable'        => 'system/modules/calendar_extended/templates',
	'cal_yearview'         => 'system/modules/calendar_extended/templates',
	'evr_registration'     => 'system/modules/calendar_extended/templates',
	'mod_evr_registration' => 'system/modules/calendar_extended/templates',
	'mod_fc_fullcalendar'  => 'system/modules/calendar_extended/templates',
));
