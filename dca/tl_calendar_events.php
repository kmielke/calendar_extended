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


$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onsubmit_callback'][] = array('tl_calendar_events_ext', 'adjustTime');
$GLOBALS['TL_DCA']['tl_calendar_events']['config']['onsubmit_callback'][] = array('tl_calendar_events', 'scheduleUpdate');

$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace
(
    'addTime,',
    'showOnFreeDay,addTime,',
    $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']
);

$GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default'] = str_replace
(
    '{recurring_legend},recurring;',
    '{location_legend},location_name,location_link,location_contact,location_mail;{recurring_legend},recurring;{recurring_legend_ext},recurringExt;{exception_legend},useExceptions;',
    $GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['default']
);

// change the default palettes
array_insert($GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['__selector__'], 99, 'recurringExt');
array_insert($GLOBALS['TL_DCA']['tl_calendar_events']['palettes']['__selector__'], 99, 'useExceptions');

// change the default palettes
$GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['recurring'] = str_replace
(
    'repeatEach,recurrences',
    'hideOnWeekend,repeatEach,recurrences,repeatEnd',
//    'hideOnWeekend,repeatEach,recurrences,repeatEnd,repeatExceptions',
    $GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['recurring']
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['useExceptions'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['useExceptions'],
    'exclude'			=> true,
    'inputType'			=> 'checkbox',
    'eval'				=> array('submitOnChange'=>true, 'tl_class'=>'long clr'),
    'sql'               => "char(1) NOT NULL default ''",
    'save_callback'     => array
    (
        array('tl_calendar_events_ext', 'checkExceptions')
    )
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['showOnFreeDay'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['showOnFreeDay'],
    'exclude'			=> true,
    'filter'			=> false,
    'inputType'			=> 'checkbox',
    'sql'               => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['weekday'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['weekday'],
    'exclude'			=> true,
    'filter'			=> true,
    'inputType'			=> 'select',
    'options'			=> array(0, 1, 2, 3, 4, 5, 6, 7),
    'reference'			=> &$GLOBALS['TL_LANG']['DAYS'],
    'sql'               => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['recurring'] = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_calendar_events']['recurring'],
    'exclude'           => true,
    'filter'            => true,
    'inputType'         => 'checkbox',
    'eval'              => array('submitOnChange'=>true, 'tl_class'=>'w50'),
    'sql'               => "char(1) NOT NULL default ''",
    'save_callback'     => array
    (
        array('tl_calendar_events_ext', 'checkRecurring')
    )
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['hideOnWeekend'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['hideOnWeekend'],
    'exclude'			=> true,
    'filter'			=> false,
    'inputType'			=> 'checkbox',
    'eval'				=> array('tl_class'=>'w50'),
    'sql'               => "char(1) NOT NULL default ''"
);

// change the default palettes
$GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['recurringExt'] = 'repeatEachExt,recurrences,repeatEnd';
$GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['useExceptions'] = 'repeatExceptionsInt,repeatExceptionsPer,repeatExceptions';
//$GLOBALS['TL_DCA']['tl_calendar_events']['subpalettes']['recurringExt'] = 'repeatEachExt,recurrences,repeatEnd,repeatExceptions';

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['recurringExt'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['recurringExt'],
    'exclude'			=> true,
    'inputType'			=> 'checkbox',
    'eval'				=> array('submitOnChange'=>true, 'tl_class'=>'long clr'),
    'sql'               => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['location_name'] = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_calendar_events']['location_name'],
    'exclude'           => true,
    'search'            => true,
    'inputType'         => 'text',
    'eval'              => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'               => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['location_link'] = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_calendar_events']['location_link'],
    'exclude'           => true,
    'search'            => true,
    'inputType'         => 'text',
    'eval'              => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'               => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['location_contact'] = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_calendar_events']['location_contact'],
    'exclude'           => true,
    'search'            => true,
    'inputType'         => 'text',
    'eval'              => array('maxlength'=>255, 'tl_class'=>'w50'),
    'sql'               => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['location_mail'] = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_calendar_events']['location_mail'],
    'exclude'           => true,
    'search'            => true,
    'inputType'         => 'text',
    'eval'              => array('rgxp'=>'email', 'maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'               => "varchar(255) NOT NULL default ''"
);

// new repeat options for events
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['repeatEachExt'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['repeatEachExt'],
    'exclude'			=> true,
    'inputType'			=> 'timePeriodExt',
    'options'			=> array
    (
        array('first', 'second', 'third', 'fourth', 'last'),
        array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')
    ),
    'reference'         => &$GLOBALS['TL_LANG']['tl_calendar_events'],
    'eval'				=> array('mandatory'=>true, 'tl_class'=>'w50'),
    'default'           => &$GLOBALS['TL_CONFIG']['tl_calendar_events']['weekdays'][date('w', time())],
    'sql'               => "text NULL"
);

// added submitOnChange to recurrences
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['recurrences'] = array
(
    'label'             => &$GLOBALS['TL_LANG']['tl_calendar_events']['recurrences'],
    'exclude'           => true,
    'inputType'         => 'text',
    'eval'				=> array('mandatory'=>true, 'rgxp'=>'digit', 'submitOnChange'=>true, 'tl_class'=>'w50'),
    'sql'               => "smallint(5) unsigned NOT NULL default '0'"
);

// list of exceptions
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['repeatExceptions'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['repeatExceptions'],
    'exclude'			=> true,
    'inputType'         => 'multiColumnWizard',
    'eval'				=> array
        (
            'columnsCallback'   => array('tl_calendar_events_ext', 'listMultiExceptions'),
            'buttons'           => array('up' => false, 'down' => false)
        ),
    'sql'               => "text NULL"
);

// list of exceptions
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['repeatExceptionsInt'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['repeatExceptionsInt'],
    'exclude'			=> true,
    'inputType'         => 'multiColumnWizard',
    'eval'				=> array
        (
            'columnsCallback'   => array('tl_calendar_events_ext', 'listMultiExceptions'),
            'buttons'           => array('up' => false, 'down' => false)
        ),
    'sql'               => "text NULL"
);

// list of exceptions
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['repeatExceptionsPer'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['repeatExceptionsPer'],
    'exclude'			=> true,
    'inputType'         => 'multiColumnWizard',
    'eval'				=> array
        (
            'columnsCallback'   => array('tl_calendar_events_ext', 'listMultiExceptions'),
            'buttons'           => array('up' => false, 'down' => false)
        ),
    'sql'               => "text NULL"
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['repeatDates'] = array
(
    'sql'               => "text NULL"
);

$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['exceptionList'] = array
(
    'sql'               => "text NULL"
);

// display the end of the recurrences (read only)
$GLOBALS['TL_DCA']['tl_calendar_events']['fields']['repeatEnd'] = array
(
    'label'				=> &$GLOBALS['TL_LANG']['tl_calendar_events']['repeatEnd'],
    'exclude'			=> true,
    'inputType'			=> 'text',
    'eval'				=> array('readonly'=>true, 'rgxp'=>'date', 'tl_class'=>'clr'),
    'sql'               => "int(10) unsigned NOT NULL default '0'"
);


/**
 * Class tl_calendar_events
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 * @copyright  Leo Feyer 2005-2010
 * @author     Leo Feyer <http://www.contao.org>
 * @package    Controller
 */
class tl_calendar_events_ext extends \Backend
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
     * Just check that only one option is active for recurring events
     * @param $varValue
     * @param DataContainer $dc
     * @return mixed
     * @throws Exception
     */
    public function checkRecurring($varValue, DataContainer $dc)
    {
        if ($varValue)
        {
            if ($dc->activeRecord->recurring && $dc->activeRecord->recurringExt)
            {
                throw new Exception($GLOBALS['TL_LANG']['tl_calendar_events']['checkRecurring']);
            }
        }

        return $varValue;
    }


    /**
     * Just check if any kind of recurring is in use
     * @param $varValue
     * @param DataContainer $dc
     * @return mixed
     * @throws Exception
     */
    public function checkExceptions($varValue, DataContainer $dc)
    {
        if ($varValue)
        {
            if (!$dc->activeRecord->recurring && !$dc->activeRecord->recurringExt)
            {
                throw new Exception($GLOBALS['TL_LANG']['tl_calendar_events']['checkExceptions']);
            }
        }

        return $varValue;
    }


    /**
     * Adjust start end end time of the event based on date, span, startTime and endTime
     * @param object
     */
    public function adjustTime(DataContainer $dc)
    {
        $maxCount = ($GLOBALS['TL_CONFIG']['tl_calendar_events']['maxRepeatExceptions']) ? $GLOBALS['TL_CONFIG']['tl_calendar_events']['maxRepeatExceptions'] : 365;

        // Return if there is no active record (override all)
        if (!$dc->activeRecord)
        {
            return;
        }

        $arrSet['startTime'] = $dc->activeRecord->startDate;
        $arrSet['endTime'] = $dc->activeRecord->startDate;
        $arrSet['weekday'] = date("w", $dc->activeRecord->startDate);

        // Set end date
        if (strlen($dc->activeRecord->endDate))
        {
            if ($dc->activeRecord->endDate > $dc->activeRecord->startDate)
            {
                $arrSet['endDate'] = $dc->activeRecord->endDate;
                $arrSet['endTime'] = $dc->activeRecord->endDate;
            }
            else
            {
                $arrSet['endDate'] = $dc->activeRecord->startDate;
                $arrSet['endTime'] = $dc->activeRecord->startDate;
            }
        }

        // Add time
        if ($dc->activeRecord->addTime)
        {
            $arrSet['startTime'] = strtotime(date('Y-m-d', $arrSet['startTime']) . ' ' . date('H:i:s', $dc->activeRecord->startTime));
            $arrSet['endTime'] = strtotime(date('Y-m-d', $arrSet['endTime']) . ' ' . date('H:i:s', $dc->activeRecord->endTime));
        }

        // Adjust end time of "all day" events
        elseif ((strlen($dc->activeRecord->endDate) && $arrSet['endDate'] == $arrSet['endTime']) || $arrSet['startTime'] == $arrSet['endTime'])
        {
            $arrSet['endTime'] = (strtotime('+ 1 day', $arrSet['endTime']) - 1);
        }

        $arrSet['repeatEnd'] = 0;

        //changed default recurring
        if ($dc->activeRecord->recurring)
        {
            $arrRange = deserialize($dc->activeRecord->repeatEach);

            $arg = $arrRange['value'] * $dc->activeRecord->recurrences;
            $unit = $arrRange['unit'];

            $strtotime = '+ ' . $arg . ' ' . $unit;
            $arrSet['repeatEnd'] = strtotime($strtotime, $arrSet['endTime']);

            //store the list of dates
            $next = $dc->activeRecord->startDate;
            $count = $dc->activeRecord->recurrences;

            //array of the exception dates
            $arrDates = array();
            $arrDates[$next] = (int)$next;

            if ($count == 0)
            {
                $arrSet['repeatEnd'] = 2145913200;
            }

            // last date of the recurrences
            $end = $arrSet['repeatEnd'];

            while ($next < $end)
            {
                $timetoadd = '+ ' . $arrRange['value'] . ' ' . $unit;

                // Check if we are at the end
                if (!strtotime($timetoadd, $next))
                {
                    break;
                }

                $strtotime = strtotime($timetoadd, $next);
                $next = $strtotime;
                $weekday = date('w', $next);

                //check if we are at the end
                if ($next >= $end)
                {
                    break;
                }

                $store = true;
                if ($dc->activeRecord->hideOnWeekend)
                {
                    if ($weekday == 0 || $weekday == 6 || $weekday == 7)
                    {
                        $store = false;
                    }
                }
                if ($store === true)
                {
                    $arrDates[$next] = $next;
                }

                //check if have the configured max value
                if (count($arrDates) == $maxCount && $unit == "days")
                {
                    break;
                }
            }
        }

        //list of months we need
        $arrMonth = array(1=>'january', 2=>'february', 3=>'march', 4=>'april', 5=>'may', 6=>'june',
            7=>'july', 8=>'august', 9=>'september', 10=>'october', 11=>'november', 12=>'december',
        );

        //extended version recurring
        if ($dc->activeRecord->recurringExt)
        {
            $arrRange = deserialize($dc->activeRecord->repeatEachExt);

            $arg = $arrRange['value'];
            $unit = $arrRange['unit'];

            //next month of the event
            $month = date('n', $dc->activeRecord->startDate);
            //year of the event
            $year = date('Y', $dc->activeRecord->startDate);
            //search date for the next event
            $next = $dc->activeRecord->startDate;
            //last month
            $count = $dc->activeRecord->recurrences;

            //array of the exception dates
            $arrDates = array();
            // $arrDates[$next] = (int)$next;

            if ($count > 0)
            {
                for ($i = 0; $i < $count; $i++)
                {
                    $timetoadd = $arg . ' ' . $unit . ' of ' . $arrMonth[$month] . ' ' . $year;

                    if (!strtotime($timetoadd, $next))
                    {
                        break;
                    }

                    $strtotime = strtotime($timetoadd, $next);
                    $next = $strtotime;
                    $arrDates[$next] = $next;

                    $month++;
                    if (($month % 13) == 0)
                    {
                        $month = 1;
                        $year += 1;
                    }
                }
                $arrSet['repeatEnd'] = $next;
            }
            else
            {
                // 2038.01.01
                $arrSet['repeatEnd'] = 2145913200;
                $end = $arrSet['repeatEnd'];

                while ($next <= $end)
                {
                    $timetoadd = $arg . ' ' . $unit . ' of ' . $arrMonth[$month] . ' ' . $year;

                    if (!strtotime($timetoadd, $next))
                    {
                        break;
                    }

                    $strtotime = strtotime($timetoadd, $next);
                    $next = $strtotime;

                    $arrDates[$next] = $next;

                    $month++;
                    if (($month % 13) == 0)
                    {
                        $month = 1;
                        $year += 1;
                    }

//                    //check if have the configured max value
//                    if (count($arrDates) == $maxCount)
//                    {
//                        break;
//                    }
                }
            }
        }

        // the last repeatEnd Date
        $currentEndDate = $arrSet['repeatEnd'];

        if ($dc->activeRecord->useExceptions)
        {
            // this will be he list of the exception
            $exceptionRows = array();

            // ... and last but not least by range
            if ($dc->activeRecord->repeatExceptionsPer)
            {
                // exception rules
                $rows = deserialize($dc->activeRecord->repeatExceptionsPer);

                // all recurrences...
                $repeatDates = deserialize($dc->activeRecord->repeatDates);

                // run thru all dates
                foreach ($rows as $row)
                {
                    if (!$row['exception'])
                    {
                        continue;
                    }

//                    $currDay = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], strtotime(date("Y-m-d", $this->weekBegin) . " +$i day"));

                    // now we have to find all dates matching the exception rules...
                    $dateFrom = strtotime($row['exception']);
                    $dateTo = strtotime($row['exceptionTo']);
                    unset($row['exceptionTo']);

                    foreach ($repeatDates as $k => $repeatDate)
                    {
                        if ($k >= $dateFrom && $k <= $dateTo)
                        {
                            $row['exception'] = $k;
                            $exceptionRows[$k] = $row;
                        }
                    }
                }
            }

            // ... then we check them by interval...
            if ($dc->activeRecord->repeatExceptionsInt)
            {
                // exception rules
                $rows = deserialize($dc->activeRecord->repeatExceptionsInt);

                // weekday
                $unit = $GLOBALS['TL_CONFIG']['tl_calendar_events']['weekdays'][$dc->activeRecord->weekday];

                // all recurrences...
                $repeatDates = deserialize($dc->activeRecord->repeatDates);

                // run thru all dates
                foreach ($rows as $row)
                {
                    if (!$row['exception'])
                    {
                        continue;
                    }

                    // now we have to find all dates matching the exception rules...
                    $arg = $row['exception'];

                    foreach ($repeatDates as $k => $repeatDate)
                    {
                        $month = date('n', $k);
                        $year = date('Y', $k);

                        $dateToFind = $arg.' '.$unit.' of '.$arrMonth[$month].' '.$year;
                        if ($k == strtotime($dateToFind))
                        {
                            $row['exception'] = $k;
                            $exceptionRows[$k] = $row;
                        }
                    }
                }
            }

            // first we check the exceptions by date...
            if ($dc->activeRecord->repeatExceptions)
            {
                $rows = deserialize($dc->activeRecord->repeatExceptions);
                // set repeatEnd
                // my be we have an exception move that is later then the repeatEnd
                foreach ($rows as $row)
                {
                    if (!$row['exception'])
                    {
                        continue;
                    }

                    $k = $row['exception'];
                    if ($row['action'] == 'move')
                    {
                        $newDate = strtotime($row['new_exception'], $row['exception']);
                        if ($newDate > $currentEndDate)
                        {
                            $arrSet['repeatEnd'] = $newDate;
                        }

                        // Find the date and replace it
                        $pos = array_search($row['values']['exception'], $arrDates);
                        if ($pos)
                        {
                            $arrDates[$pos] = $newDate;
                        }
                    }
                    $exceptionRows[$k] = $row;
                }
            }

            $arrSet['exceptionList'] = (count($exceptionRows) > 0) ? serialize($exceptionRows) : NULL;
        }

        // Set the array of dates
        $arrSet['repeatDates'] = $arrDates;

        // Execute the update sql
        $this->Database->prepare("UPDATE tl_calendar_events %s WHERE id=?")->set($arrSet)->executeUncached($dc->id);
    }


    /**
     * listMultiExceptions()
     *
     * Read the list of exception dates from the db
     * to fill the select list
     */
    public function listMultiExceptions($var1)
    {
        $columnFields = null;

        // arrays for the select fields
        $arrSource1 = array();
        $arrSource2 = array();
        $arrSource3 = array();
        $arrSource4 = array();

        if ($this->Input->get('id'))
        {
            if ($var1->activeRecord->repeatDates)
            {
                $arrDates = deserialize($var1->activeRecord->repeatDates);
                if (is_array($arrDates))
                {
                    if ($var1->id == "repeatExceptions")
                    {
                        // fill array for option date
                        foreach ($arrDates as $k => $arrDate)
                        {
                            $date = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $k);
                            $arrSource1[$k] = $date;
                        }
                    }

                    // fill array for option action
                    $arrSource2['move'] = $GLOBALS['TL_LANG']['tl_calendar_events']['move'];
                    $arrSource2['hide'] = $GLOBALS['TL_LANG']['tl_calendar_events']['hide'];
                    $arrSource2['mark'] = $GLOBALS['TL_LANG']['tl_calendar_events']['mark'];
                }
            }

            // fill array for option new date
            $moveDays = ((int)$GLOBALS['TL_CONFIG']['tl_calendar_events']['moveDays']) ? (int)$GLOBALS['TL_CONFIG']['tl_calendar_events']['moveDays'] : 7;
            $start = $moveDays * -1;
            $end = $moveDays * 2;

            for ($i = 0; $i <= $end; $i++)
            {
                $arrSource3[$start. ' days'] = $start . ' ' . $GLOBALS['TL_LANG']['tl_calendar_events']['days'];
                $start++;
            }

            list($start, $end, $interval) = explode("|", $GLOBALS['TL_CONFIG']['tl_calendar_events']['moveTimes']);

            // fill array for option new time
            $start = strtotime($start);
            $end = strtotime($end);
            while ($start <= $end)
            {
                $newTime = $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $start);
                $arrSource4[$newTime] = $newTime;
                $start = strtotime('+ ' . $interval . ' minutes', $start);
            }
        }

        $columnFields = array
        (
            'action' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['action'],
                'exclude'   => true,
                'inputType' => 'select',
                'options'   => $arrSource2,
                'eval'      => array('style'=>'width:110px', 'includeBlankOption'=>true)
            ),
            'new_exception' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['new_exception'],
                'exclude'   => true,
                'inputType' => 'select',
                'options'   => $arrSource3,
                'eval'      => array('style'=>'width:85px', 'includeBlankOption'=>true)
            ),
            'new_start' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['new_start'],
                'exclude'   => true,
                'inputType' => 'select',
                'options'   => $arrSource4,
                'eval'      => array('style'=>'width:65px', 'includeBlankOption'=>true)
            ),
            'new_end' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['new_end'],
                'exclude'   => true,
                'inputType' => 'select',
                'options'   => $arrSource4,
                'eval'      => array('style'=>'width:65px', 'includeBlankOption'=>true)
            ),
            'reason' => array
            (
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['reason'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => array('style'=>'width:100px')
            )
        );

        // normal exceptions by date
        if ($var1->id == "repeatExceptions")
        {
            $firstField = array(
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['exception'],
                'exclude'   => true,
                'inputType' => 'select',
                'options'   => $arrSource1,
                'eval'      => array('style'=>'width:130px', 'includeBlankOption'=>true, 'chosen'=>true)
            );
        }

       // exceptions by interval
        elseif ($var1->id == "repeatExceptionsInt")
        {
            $firstField = array(
                'label'     => $GLOBALS['TL_LANG']['tl_calendar_events']['exceptionInt'].$GLOBALS['TL_LANG']['DAYS'][$var1->activeRecord->weekday],
                'exclude'   => true,
                'inputType' => 'select',
                'options'   => array('first', 'second', 'third', 'fourth', 'last'),
                'reference' => &$GLOBALS['TL_LANG']['tl_calendar_events'],
                'eval'      => array('style'=>'width:130px', 'includeBlankOption'=>true, 'chosen'=>true)
            );
        }

        // exceptions by time period
        elseif ($var1->id == "repeatExceptionsPer")
        {
            $firstField = array(
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['exceptionFr'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => array('style'=>'width:60px', 'datepicker'=>true, 'rgxp'=>'date')
            );
            $secondField = array(
                'label'     => &$GLOBALS['TL_LANG']['tl_calendar_events']['exceptionTo'],
                'exclude'   => true,
                'inputType' => 'text',
                'eval'      => array('style'=>'width:60px', 'datepicker'=>true, 'rgxp'=>'date')
            );

            // add the field to the columnFields array
            array_insert($columnFields, 0, array("exceptionTo"=> $secondField));
        }

        // add the field to the columnFields array
        array_insert($columnFields, 0, array("exception"=> $firstField));

        return $columnFields;
    }
}