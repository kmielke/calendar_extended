<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2013 Leo Feyer
 *
 * @package Calendar_extended
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'Contao\EventsExt'           => 'system/modules/calendar_extended/classes/EventsExt.php',
	'Contao\TimePeriodExt'       => 'system/modules/calendar_extended/classes/TimePeriodExt.php',

	// Models
	'Contao\CalendarEventsModel' => 'system/modules/calendar_extended/models/CalendarEventsModel.php',

	// Modules
	'Contao\ModuleCalendar'      => 'system/modules/calendar_extended/modules/ModuleCalendar.php',
	'Contao\ModuleEventlist'     => 'system/modules/calendar_extended/modules/ModuleEventlist.php',
	'Contao\ModuleEventMenu'     => 'system/modules/calendar_extended/modules/ModuleEventMenu.php',
	'Contao\ModuleEventReader'   => 'system/modules/calendar_extended/modules/ModuleEventReader.php',
	'Contao\ModuleTimeTable'     => 'system/modules/calendar_extended/modules/ModuleTimeTable.php',
	'Contao\ModuleYearView'      => 'system/modules/calendar_extended/modules/ModuleYearView.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'cal_timetable' => 'system/modules/calendar_extended/templates',
	'cal_yearview'  => 'system/modules/calendar_extended/templates',
));
