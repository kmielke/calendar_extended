<?php

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Calendar
 * @license    LGPL
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['use_horizontal']	= array('Display horizontal', 'Months will be displayed horizontal.');
$GLOBALS['TL_LANG']['tl_module']['use_navigation']	= array('Display navigation', 'Week navigation will be displayed if checked');
$GLOBALS['TL_LANG']['tl_module']['showDate']		= array('Display date', 'Date of weekday will be displayed if checked');
$GLOBALS['TL_LANG']['tl_module']['showRecurrences']	= array('Shortened view (recurrences)', 'Show recurring events only once. Please modify your Template to show.');
$GLOBALS['TL_LANG']['tl_module']['showOnlyNext']    = array('Next recurrence only', 'Only the next recurrence will be displayed (for recurrences only).');
$GLOBALS['TL_LANG']['tl_module']['linkCurrent']		= array('Display link "current date"', 'Link to jump to current date will be displayed if checked');
$GLOBALS['TL_LANG']['tl_module']['hideEmptyDays']	= array('Hide empty days', 'Weekdays without events will not be displayed if checked');
$GLOBALS['TL_LANG']['tl_module']['cal_holiday']     = array('Holiday calendars', 'Please select one or more calendars for holidays.');
$GLOBALS['TL_LANG']['tl_module']['cal_calendar_ext']= array('Calendars', 'Please select one or more calendars.');
$GLOBALS['TL_LANG']['tl_module']['cal_times']		= array('Display times', 'Times will be displayed and the events with the same time will be displayed on same level.');
$GLOBALS['TL_LANG']['tl_module']['pubTimeRecurrences'] = array('Check time of recurrences', 'Recurrences are displayed only if the time of the event is inside "Show from/until" time.');
$GLOBALS['TL_LANG']['tl_module']['displayDuration'] = array('Display duration of events', 'Limit of the display duration of events. Please use "strtotime" Syntax (+7 days, +2 week).');

$GLOBALS['TL_LANG']['tl_module']['range_date']      = array('Event list format (extended)', 'Default event list format will be ignored if set. Here you can choose the event list date range.');
$GLOBALS['TL_LANG']['tl_module']['range_from']      = array('Date from', 'Start-Date of the event list.');
$GLOBALS['TL_LANG']['tl_module']['range_to']        = array('Date to', 'End-Date of the event list.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_module']['displayDurationError'] = 'Error parsing strtotime value.';