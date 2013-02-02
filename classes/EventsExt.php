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
 * Namespace
 */
namespace Contao;

/**
 * Class EventExt 
 *
 * @copyright  Kester Mielke 2010-2013 
 * @author     Kester Mielke 
 * @package    Devtools
 */
class EventsExt extends \Events
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = '';


	/**
	 * Generate the module
	 */
	protected function compile()
	{
        parent::compile;
    }


    /**
     * Get all events of a certain period
     * @param array
     * @param integer
     * @param integer
     * @return array
     */
    protected function getAllEventsExt($arrHolidays, $arrCalendars, $intStart, $intEnd)
    {
        if (!is_array($arrCalendars))
        {
            return array();
        }

        $this->arrEvents = array();

        foreach ($arrCalendars as $id)
        {
            $strUrl = $this->strUrl;
            $objCalendar = \CalendarModel::findByPk($id);

            // Get the current "jumpTo" page
            if ($objCalendar !== null && $objCalendar->jumpTo && ($objTarget = $objCalendar->getRelated('jumpTo')) !== null)
            {
                $strUrl = $this->generateFrontendUrl($objTarget->row(), ($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/events/%s'));
            }

            // Get the events of the current period
            $objEvents = \CalendarEventsModelExt::findCurrentByPid($id, $intStart, $intEnd);

            if ($objEvents === null)
            {
                continue;
            }

            while ($objEvents->next())
            {
                $eventNumber = 1;
                $eventRecurrences = (int)$objEvents->recurrences+1;

                if ($objEvents->recurring || $objEvents->recurringExt)
                {
                    $objEvents->pos_idx = (int)$eventNumber;
                    if ($objEvents->recurrences == 0)
                    {
                        $objEvents->pos_cnt = 0;
                    }
                    else
                    {
                        $objEvents->pos_cnt = (int)$eventRecurrences;
                    }
                }

                // Check if we have to store the event if it's on weekend
                $weekday = date('N', $objEvents->startTime);
                $store = true;
                if ($objEvents->hideOnWeekend)
                {
                    if ($weekday == 0 || $weekday == 6 || $weekday == 7)
                    {
                        $store = false;
                    }
                }
                if ($store === true)
                {
                    $eventUrl = $strUrl."?day=".Date("Ymd", $objEvents->startTime)."&amp;times=".$objEvents->startTime.",".$objEvents->endTime;
                    $this->addEvent($objEvents, $objEvents->startTime, $objEvents->endTime, $eventUrl, $intStart, $intEnd, $id);
                    #$this->addEvent($objEvents, $objEvents->startTime, $objEvents->endTime, $strUrl, $intStart, $intEnd, $id);
                }

                /*
                 * Recurring events and Ext. Recurring events
                 *
                 * Here we manage the recurrences. We take the repeat option and set the new values
                 */
                if (($objEvents->recurring && $objEvents->repeatEach) || ($objEvents->recurringExt && $objEvents->repeatEachExt))
                {
                    //list of months we need
                    $arrMonth = array(1=>'january', 2=>'february', 3=>'march', 4=>'april', 5=>'may', 6=>'jun',
                        7=>'july', 8=>'august', 9=>'september', 10=>'october', 11=>'november', 12=>'december',
                    );

                    $count = 0;
                    if ($objEvents->recurring)
                    {
                        $arrRepeat = deserialize($objEvents->repeatEach);
                    }
                    else
                    {
                        $arrRepeat = deserialize($objEvents->repeatEachExt);
                    }

                    //start and end time of the event
                    $eventStartTime = $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $objEvents->startTime);
                    $eventEndTime = $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $objEvents->endTime);

                    // now we have to take care about the exceptions dates to skip
                    $skipInfos = deserialize($objEvents->repeatExceptions);

                    //time of the next event
                    $nextTime = $objEvents->endTime;
                    while ($nextTime < $intEnd)
                    {
                        $eventNumber++;
                        $objEvents->pos_idx = (int)$eventNumber;
                        if ($objEvents->recurrences == 0)
                        {
                            $objEvents->pos_cnt = 0;
                        }
                        else
                        {
                            $objEvents->pos_cnt = (int)$eventRecurrences;
                        }

                        if ($objEvents->recurrences > 0 && $count++ >= $objEvents->recurrences)
                        {
                            break;
                        }

                        $arg = $arrRepeat['value'];
                        $unit = $arrRepeat['unit'];

                        if ($objEvents->recurring)
                        {
                            //this is the contao default
                            $strtotime = '+ ' . $arg . ' ' . $unit;
                            $objEvents->startTime = strtotime($strtotime, $objEvents->startTime);
                            $objEvents->endTime = strtotime($strtotime, $objEvents->endTime);
                        }
                        else
                        {
                            //extended version.
                            $intyear	= date('Y', $objEvents->startTime);
                            $intmonth	= date('n', $objEvents->startTime) + 1;

                            $year = ($intmonth == 13) ? ($intyear + 1) : $intyear;
                            $month = ($intmonth == 13) ? 1 : $intmonth;

                            $strtotime = $arg . ' ' . $unit . ' of ' . $arrMonth[$month] . ' ' . $year;
                            $objEvents->startTime = strtotime($strtotime . ' ' . $eventStartTime, $objEvents->startTime);
                            $objEvents->endTime = strtotime($strtotime . ' ' . $eventEndTime, $objEvents->endTime);
                        }

                        $nextTime = $objEvents->endTime;

                        //check if there is any exception
                        if (is_array($skipInfos) && $skipInfos[0]['exception'] > 0)
                        {
                            $skipDates = array();

                            // date to search for
                            $searchDate = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objEvents->startTime);

                            foreach ($skipInfos as $i => $skipInfo)
                            {
                                // we need this to be compatible with the older version even for the modules...
                                // so there is no need to modify the templates...
                                foreach ($skipInfo as $k => $v)
                                {
                                    $skipDates[$k][$i] = $v;
                                }
                            }

                            // if date is found continue...
                            $exception = array();
                            foreach ($skipDates['exception'] as $ex)
                            {
                                $exception[] = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $ex);
                            }

                            $oldDate = array();

                            if (array_search($searchDate, $exception, true) !== false)
                            {
                                $r = array_search($searchDate, $exception, true);
                                $action = $skipDates['action'][$r];
                                if ($action == "hide")
                                {
                                    //continue the while since we don't want to show the event
                                    continue;
                                }
                                else if ($action == "mark")
                                {
                                    //just add the css class to the event
                                    $objEvents->cssClass .= "exception";
                                }
                                else if ($action == "move")
                                {
                                    //just add the css class to the event
                                    $objEvents->cssClass .= "moved";

                                    // keep old date. we have to reset it later for the next recurrence
                                    $oldDate['startTime'] = $objEvents->startTime;
                                    $oldDate['endTime'] = $objEvents->endTime;

                                    // also keep the old values in the row
                                    $objEvents->oldDate = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objEvents->startTime);

                                    // value to add to the old date
                                    $newDate = $skipDates['new_exception'][$r];

                                    // store the reason for the move
                                    if ((int)$skipDates['reason'][$r] > 0)
                                    {
                                        $objEvents->moveReason = $GLOBALS['TL_CONFIG']['tl_calendar_events']['moveReasons'][$skipDates['reason'][$r]];
                                    }

                                    // check if we have to change the time of the event
                                    if ($skipDates['new_start'][$r])
                                    {
                                        $objEvents->oldStartTime = $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $objEvents->startTime);
                                        $objEvents->oldEndTime = $this->parseDate($GLOBALS['TL_CONFIG']['timeFormat'], $objEvents->endTime);

                                        // get the date of the event and add the new time to the new date
                                        $newStart = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objEvents->startTime)
                                            . ' ' . $skipDates['new_start'][$r];
                                        $newEnd = $this->parseDate($GLOBALS['TL_CONFIG']['dateFormat'], $objEvents->endTime)
                                            . ' ' . $skipDates['new_end'][$r];

                                        //set the new values
                                        $objEvents->startTime = strtotime($newDate, strtotime($newStart));
                                        $objEvents->endTime = strtotime($newDate, strtotime($newEnd));
                                    }
                                    else
                                    {
                                        $objEvents->startTime = strtotime($newDate, $objEvents->startTime);
                                        $objEvents->endTime = strtotime($newDate, $objEvents->endTime);
                                    }
                                }
                            }
                        }

                        // Skip events outside the scope
                        if ($objEvents->endTime < $intStart || $objEvents->startTime > $intEnd)
                        {
                            // in case of a move we have to reset the original date
                            if ($oldDate)
                            {
                                $objEvents->startTime = $oldDate['startTime'];
                                $objEvents->endTime = $oldDate['endTime'];
                            }
                            continue;
                        }

                        $objEvents->isRecurrence = true;

                        $weekday = date('N', $objEvents->startTime);
                        $store = true;
                        if ($objEvents->hideOnWeekend)
                        {
                            if ($weekday == 0 || $weekday == 6 || $weekday == 7)
                            {
                                $store = false;
                            }
                        }
                        if ($store === true)
                        {
                            $eventUrl = $strUrl."?day=".Date("Ymd", $objEvents->startTime)."&amp;times=".$objEvents->startTime.",".$objEvents->endTime;
                            $this->addEvent($objEvents, $objEvents->startTime, $objEvents->endTime, $eventUrl, $intStart, $intEnd, $id);
                        }

                        // reset this values...
                        $objEvents->moveReason = NULL;
                        $objEvents->oldDate = NULL;
                        $objEvents->oldStartTime = NULL;
                        $objEvents->oldEndTime = NULL;

                        // in case of a move we have to reset the original date
                        if ($oldDate)
                        {
                            $objEvents->startTime = $oldDate['startTime'];
                            $objEvents->endTime = $oldDate['endTime'];
                        }
                    }
                }
            }
        }

        // run thru all holiday calendars
        $arrFreeday = array();
        foreach ($arrHolidays as $id)
        {
            $strUrl = $this->strUrl;

            $objAE = $this->Database->prepare("SELECT allowEvents FROM tl_calendar WHERE id = ?")
                ->limit(1)->execute($id);
            $allowEvents = ($objAE->allowEvents == 1) ? true : false;

            $strUrl = $this->strUrl;
            $objCalendar = \CalendarModel::findByPk($id);

            // Get the current "jumpTo" page
            if ($objCalendar !== null && $objCalendar->jumpTo && ($objTarget = $objCalendar->getRelated('jumpTo')) !== null)
            {
                $strUrl = $this->generateFrontendUrl($objTarget->row(), ($GLOBALS['TL_CONFIG']['useAutoItem'] ?  '/%s' : '/events/%s'));
            }

            // Get the events of the current period
            $objEvents = \CalendarEventsModel::findCurrentByPid($id, $intStart, $intEnd);

            if ($objEvents === null)
            {
                continue;
            }

            while ($objEvents->next())
            {
                // at last we add the free multi-day / holiday or what ever kind of event
                $this->addEvent($objEvents, $objEvents->startTime, $objEvents->endTime, $strUrl, $intStart, $intEnd, $id);

                /**
                 * Multi-day event
                 * first we have to find all free days
                 */
                $span = Calendar::calculateSpan($objEvents->startTime, $objEvents->endTime);

                // unset the first day of the multi-day event
                $intDate = $objEvents->startTime;
                $key = date('Ymd', $intDate);
                // check all events if the calendar allows events on free days
                if ($this->arrEvents[$key])
                {
                    foreach ($this->arrEvents[$key] as $k1 => $events)
                    {
                        foreach ($events as $k2 => $event)
                        {
                            // do not remove events from any holiday calendar
                            $isHolidayEvent = array_search($event['pid'], $arrHolidays);

                            // unset the event if showOnFreeDay is not set
                            if ($allowEvents === false)
                            {
                                if ($isHolidayEvent === false)
                                {
                                    unset($this->arrEvents[$key][$k1][$k2]);
                                }
                            }
                            else
                            {
                                if ($isHolidayEvent === false && !$event['showOnFreeDay'] == 1)
                                {
                                    unset($this->arrEvents[$key][$k1][$k2]);
                                }
                            }
                        }
                    }
                }

                // unset all the other days of the multi-day event
                for ($i=1; $i<=$span && $intDate<=$intEnd; $i++)
                {
                    $intDate = strtotime('+ 1 day', $intDate);
                    $key = date('Ymd', $intDate);
                    // check all events if the calendar allows events on free days
                    if ($this->arrEvents[$key])
                    {
                        foreach ($this->arrEvents[$key] as $k1 => $events)
                        {
                            foreach ($events as $k2 => $event)
                            {
                                // do not remove events from any holiday calendar
                                $isHolidayEvent = array_search($event['pid'], $arrHolidays);

                                // unset the event if showOnFreeDay is not set
                                if ($allowEvents === false)
                                {
                                    if ($isHolidayEvent === false)
                                    {
                                        unset($this->arrEvents[$key][$k1][$k2]);
                                    }
                                }
                                else
                                {
                                    if ($isHolidayEvent === false && !$event['showOnFreeDay'] == 1)
                                    {
                                        unset($this->arrEvents[$key][$k1][$k2]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        // Sort the array
        foreach (array_keys($this->arrEvents) as $key)
        {
            ksort($this->arrEvents[$key]);
        }

        // HOOK: modify the result set
        if (isset($GLOBALS['TL_HOOKS']['getAllEvents']) && is_array($GLOBALS['TL_HOOKS']['getAllEvents']))
        {
            foreach ($GLOBALS['TL_HOOKS']['getAllEvents'] as $callback)
            {
                $this->import($callback[0]);
                $this->arrEvents = $this->$callback[0]->$callback[1]($this->arrEvents, $arrCalendars, $intStart, $intEnd, $this);
            }
        }

        return $this->arrEvents;
    }

}
