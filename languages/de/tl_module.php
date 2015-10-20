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
$GLOBALS['TL_LANG']['tl_module']['use_horizontal']	= array('Horizontale Darstellung', 'Monate werden horizontal dargestellt.');
$GLOBALS['TL_LANG']['tl_module']['use_navigation']	= array('Navigation anzeigen', 'Wochennavigation wird angezeigt, wenn aktiviert.');
$GLOBALS['TL_LANG']['tl_module']['showDate']		= array('Datum anzeigen', 'Tagesdatum wird angezeigt, wenn aktiviert.');
$GLOBALS['TL_LANG']['tl_module']['showRecurrences']	= array('Verkürzte Darstellung (Wiederholungen)', 'Events nur einmal anzeigen, auch wenn wiederholt werden. Template muss angepasst werden.');
$GLOBALS['TL_LANG']['tl_module']['showOnlyNext']    = array('Nur nächste Wiederholung', 'Es wird nur die nächste Wiederholung angezeigt (Nur bei Wiederholungen).');
$GLOBALS['TL_LANG']['tl_module']['linkCurrent']		= array('Link "Aktuelles Datum" anzeigen', 'Link für das aktuelle Datum wird angezeigt, wenn aktiviert.');
$GLOBALS['TL_LANG']['tl_module']['hideEmptyDays']	= array('Leere Tage nicht anzeigen', 'Wochentage ohne Events werden ausgeblendet.');
$GLOBALS['TL_LANG']['tl_module']['cal_holiday']		= array('Ferienkalender', 'Bitte wählen Sie einen oder mehrere Kalender für die Ferien und Feiertage.');
$GLOBALS['TL_LANG']['tl_module']['cal_calendar_ext']= array('Kalender', 'Bitte wählen Sie einen oder mehrere Kalender.');
$GLOBALS['TL_LANG']['tl_module']['cal_times']		= array('Uhrzeiten anzeigen', 'Uhrzeiten werden rechts angezeigt, und Events gleicher Zeit auf gleicher Höhe angezeigt.');
$GLOBALS['TL_LANG']['tl_module']['pubTimeRecurrences'] = array('Uhrzeit bei Wiederholungen berücksichtigen', 'Wiederholungen werden nur angezeigt, wenn die Zeit des Events innerhalb der Uhrzeit von "Anzeigen von/bis" liegt.');
$GLOBALS['TL_LANG']['tl_module']['displayDuration'] = array('Anzeigedauer der Events', 'Anzeigedauer der Events wird begrenzt. Bitte "strtotime" Syntax (+7 days, +2 weeks) verwenden.');
$GLOBALS['TL_LANG']['tl_module']['hide_started']    = array('Laufende Events nicht anzeigen', 'Events, die bereits gestartet sind, werden nicht mehr angezeigt.');

$GLOBALS['TL_LANG']['tl_module']['range_date']      = array('Anzeigeformat (erweitert Zeitraum)', 'Standard Anzeigeformat wird ignoriert, wenn gesetzt. Hier können die Events auf ein Start- und End-Datum eingegrenzt werden. Kann nicht mit (erweitert strtotime) verwendet werden.');
$GLOBALS['TL_LANG']['tl_module']['cal_format_ext']  = array('Anzeigeformat (erweitert strtotime)', 'Standard Anzeigeformat wird ignoriert, wenn gesetzt. Bitte "strtotime" Syntax (+7 days, +2 weeks) verwenden. +2 days => aktueller Tag + 2 Tage. Kann nicht mit (erweitert Zeitraum) verwendet werden.');
$GLOBALS['TL_LANG']['tl_module']['range_from']      = array('Datum von', 'Start-Datum der Events.');
$GLOBALS['TL_LANG']['tl_module']['range_to']        = array('Datum bis', 'End-Datum der Events.');

/**
 * References
 */
$GLOBALS['TL_LANG']['tl_module']['displayDurationError'] = 'strtotime Wert nicht lesbar.';
$GLOBALS['TL_LANG']['tl_module']['displayDurationError2'] = 'strtotime Wert flasch. Ergibt aktuelles Datum.';
$GLOBALS['TL_LANG']['tl_module']['config_ext_legend']   = 'Modul-Konfiguration (erweitert)';
