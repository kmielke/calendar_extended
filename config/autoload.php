<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
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
	'Contao\EventsExt'              => 'system/modules/calendar_extended/classes/EventsExt.php',
	'Contao\TimePeriodExt'          => 'system/modules/calendar_extended/classes/TimePeriodExt.php',

	// Models
	'Contao\CalendarEventsModelExt' => 'system/modules/calendar_extended/models/CalendarEventsModelExt.php',

	// Modules
	'Contao\ModuleCalendarExt'      => 'system/modules/calendar_extended/modules/ModuleCalendarExt.php',
	'Contao\ModuleEventListExt'     => 'system/modules/calendar_extended/modules/ModuleEventListExt.php',
	'Contao\ModuleEventMenuExt'     => 'system/modules/calendar_extended/modules/ModuleEventMenuExt.php',
	'Contao\ModuleEventReaderExt'   => 'system/modules/calendar_extended/modules/ModuleEventReaderExt.php',
	'Contao\ModuleTimeTableExt'     => 'system/modules/calendar_extended/modules/ModuleTimeTableExt.php',
	'Contao\ModuleYearViewExt'      => 'system/modules/calendar_extended/modules/ModuleYearViewExt.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'calext_default'   => 'system/modules/calendar_extended/templates',
	'calext_mini'      => 'system/modules/calendar_extended/templates',
	'calext_timetable' => 'system/modules/calendar_extended/templates',
	'calext_yearview'  => 'system/modules/calendar_extended/templates',
	'mod_timetable'    => 'system/modules/calendar_extended/templates',
	'mod_yearview'     => 'system/modules/calendar_extended/templates',
));
