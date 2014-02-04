<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @package Calendar
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace Contao;


/**
 * Class ModuleEventReader
 *
 * Front end module "event reader".
 * @copyright  Leo Feyer 2005-2013
 * @author     Leo Feyer <https://contao.org>
 * @package    Calendar
 */
class ModuleEventReader extends \EventsExt
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_event';


	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
		if (TL_MODE == 'BE')
		{
			$objTemplate = new \BackendTemplate('be_wildcard');

			$objTemplate->wildcard = '### ' . utf8_strtoupper($GLOBALS['TL_LANG']['FMD']['eventreader'][0]) . ' ###';
			$objTemplate->title = $this->headline;
			$objTemplate->id = $this->id;
			$objTemplate->link = $this->name;
			$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

			return $objTemplate->parse();
		}

		// Set the item from the auto_item parameter
		if (!isset($_GET['events']) && $GLOBALS['TL_CONFIG']['useAutoItem'] && isset($_GET['auto_item']))
		{
			\Input::setGet('events', \Input::get('auto_item'));
		}

		// Do not index or cache the page if no event has been specified
		if (!\Input::get('events'))
		{
			global $objPage;
			$objPage->noSearch = 1;
			$objPage->cache = 0;
			return '';
		}

		$this->cal_calendar = $this->sortOutProtected(deserialize($this->cal_calendar));

		// Do not index or cache the page if there are no calendars
		if (!is_array($this->cal_calendar) || empty($this->cal_calendar))
		{
			global $objPage;
			$objPage->noSearch = 1;
			$objPage->cache = 0;
			return '';
		}

		return parent::generate();
	}


	/**
	 * Generate the module
	 */
	protected function compile()
	{
		global $objPage;

		$this->Template->event = '';
		$this->Template->referer = 'javascript:history.go(-1)';
		$this->Template->back = $GLOBALS['TL_LANG']['MSC']['goBack'];

		// Get the current event
		$objEvent = \CalendarEventsModel::findPublishedByParentAndIdOrAlias(\Input::get('events'), $this->cal_calendar);

		if ($objEvent === null)
		{
			// Do not index or cache the page
			$objPage->noSearch = 1;
			$objPage->cache = 0;

			// Send a 404 header
			header('HTTP/1.1 404 Not Found');
			$this->Template->event = '<p class="error">' . sprintf($GLOBALS['TL_LANG']['MSC']['invalidPage'], \Input::get('events')) . '</p>';
			return;
		}

        $objEvent->author_name = ($objEvent->getRelated("author")->name) ? $objEvent->getRelated("author")->name : null;
        $objEvent->author_mail = ($objEvent->getRelated("author")->email) ? $objEvent->getRelated("author")->email : null;

        // Overwrite the page title (see #2853 and #4955)
		if ($objEvent->title != '')
		{
			$objPage->pageTitle = strip_tags(strip_insert_tags($objEvent->title));
		}

		// Overwrite the page description
		if ($objEvent->teaser != '')
		{
			$objPage->description = $this->prepareMetaDescription($objEvent->teaser);
		}

		$span = \Calendar::calculateSpan($objEvent->startTime, $objEvent->endTime);

        // Save original times...
        $orgStartTime = $objEvent->startTime;
        $orgEndTime = $objEvent->endTime;

        // Do not show dates in the past if the event is recurring (see #923)
        if ($objEvent->recurring)
        {
            $arrRange = deserialize($objEvent->repeatEach);

            $objEvent->nextStartTime = $objEvent->startTime;
            $objEvent->nextEndTime = $objEvent->endTime;
            while ($objEvent->nextStartTime < time() && $objEvent->nextEndTime < $objEvent->repeatEnd)
            {
                $objEvent->nextStartTime = strtotime('+' . $arrRange['value'] . ' ' . $arrRange['unit'], $objEvent->nextStartTime);
                $objEvent->nextEndTime = strtotime('+' . $arrRange['value'] . ' ' . $arrRange['unit'], $objEvent->nextEndTime);
            }
        }
        // Do not show dates in the past if the event is recurringExt
        if ($objEvent->recurringExt)
        {
            $arrRange = deserialize($objEvent->repeatEachExt);

            // list of months we need
            $arrMonth = array(1=>'january', 2=>'february', 3=>'march', 4=>'april', 5=>'may', 6=>'june',
                7=>'july', 8=>'august', 9=>'september', 10=>'october', 11=>'november', 12=>'december',
            );
            // keep the date
            $objEvent->nextStartTime = $objEvent->startTime;
            $objEvent->nextEndTime = $objEvent->endTime;
            // month and year of the start date
            $month = date('n', $objEvent->nextStartTime);
            $year = date('Y', $objEvent->nextStartTime);
            while ($objEvent->nextStartTime < time() && $objEvent->nextEndTime < $objEvent->repeatEnd)
            {
                // find the next date
                $nextValueStr = $arrRange['value'].' '.$arrRange['unit'].' of '.$arrMonth[$month].' '.$year;
                $nextValueDate = strtotime($nextValueStr, $objEvent->nextStartTime);
                // add time to the new date
                $objEvent->nextStartTime = strtotime(date("Y-m-d", $nextValueDate).' '.date("H:i:s", $objEvent->startTime));
                $objEvent->nextEndTime = strtotime(date("Y-m-d", $nextValueDate).' '.date("H:i:s", $objEvent->endTime));

                $month++;
                if (($month % 13) == 0)
                {
                    $month = 1;
                    $year += 1;
                }
            }
        }
        // Do not show dates in the past if the event is recurring irregular
        if (!is_null($objEvent->repeatFixedDates))
        {
            $arrFixedDates = deserialize($objEvent->repeatFixedDates);

            // Check if there are valid data in the array...
            if (strlen($arrFixedDates[0]['new_repeat']))
            {
                $objEvent->nextStartTime = $objEvent->startTime;
                $objEvent->nextEndTime = $objEvent->endTime;
            }

            foreach ($arrFixedDates as $fixedDate)
            {
                $nextValueDate = ($fixedDate['new_repeat']) ? strtotime($fixedDate['new_repeat']) : $objEvent->nextStartTime;
                if (strlen($fixedDate['new_start']))
                {
                    $nextStartTime = strtotime(date("Y-m-d", $nextValueDate).' '.date("H:i:s", strtotime($fixedDate['new_start'])));
                }
                else
                {
                    $nextStartTime = strtotime(date("Y-m-d", $nextValueDate).' '.date("H:i:s", $objEvent->nextStartTime));
                }
                if (strlen($fixedDate['new_end']))
                {
                    $nextEndTime = strtotime(date("Y-m-d", $nextValueDate).' '.date("H:i:s", strtotime($fixedDate['new_end'])));
                }
                else
                {
                    $nextEndTime = strtotime(date("Y-m-d", $nextValueDate).' '.date("H:i:s", $objEvent->nextEndTime));
                }

                if ($nextValueDate > time() && $nextEndTime < $objEvent->repeatEnd)
                {
                    $objEvent->nextStartTime = $nextStartTime;
                    $objEvent->nextEndTime = $nextEndTime;
                    break;
                }
            }
        }

        // Replace the date an time with the correct ones from the recurring event
        if (\Input::get('times'))
        {
            list($objEvent->startTime, $objEvent->endTime) = explode(",", \Input::get('times'));
            if ($objEvent->nextStartTime && ($objEvent->nextStartTime == $objEvent->startTime))
            {
                $objEvent->nextStartTime = null;
            }
        }

        if ($objPage->outputFormat == 'xhtml')
		{
			$strTimeStart = '';
			$strTimeEnd = '';
			$strTimeClose = '';
		}
		else
		{
			$strTimeStart = '<time datetime="' . date('Y-m-d\TH:i:sP', $objEvent->startTime) . '">';
			$strTimeEnd = '<time datetime="' . date('Y-m-d\TH:i:sP', $objEvent->endTime) . '">';
			$strTimeClose = '</time>';
		}

        // Get date
		if ($span > 0)
		{
			$date = $strTimeStart . \Date::parse(($objEvent->addTime ? $objPage->datimFormat : $objPage->dateFormat), $objEvent->startTime) . $strTimeClose . ' - ' . $strTimeEnd . \Date::parse(($objEvent->addTime ? $objPage->datimFormat : $objPage->dateFormat), $objEvent->endTime) . $strTimeClose;
            if ($objEvent->nextStartTime)
            {
                $nextDate = $strTimeStart .
                    \Date::parse(($objEvent->addTime ? $objPage->datimFormat : $objPage->dateFormat), $objEvent->nextStartTime) . $strTimeClose .
                    ' - ' . $strTimeEnd . \Date::parse(($objEvent->addTime ? $objPage->datimFormat : $objPage->dateFormat), $objEvent->nextEndTime) . $strTimeClose;
            }
        }
		elseif ($objEvent->startTime == $objEvent->endTime)
		{
			$date = $strTimeStart . \Date::parse($objPage->dateFormat, $objEvent->startTime) . ($objEvent->addTime ? ' (' . \Date::parse($objPage->timeFormat, $objEvent->startTime) . ')' : '') . $strTimeClose;
            if ($objEvent->nextStartTime)
            {
                $nextDate = $strTimeStart .
                    \Date::parse($objPage->dateFormat, $objEvent->nextStartTime) . ($objEvent->addTime ? ' (' .
                    \Date::parse($objPage->timeFormat, $objEvent->nextStartTime) . ')' : '') . $strTimeClose;
            }
		}
		else
		{
			$date = $strTimeStart . \Date::parse($objPage->dateFormat, $objEvent->startTime) . ($objEvent->addTime ? ' (' . \Date::parse($objPage->timeFormat, $objEvent->startTime) . $strTimeClose . ' - ' . $strTimeEnd . \Date::parse($objPage->timeFormat, $objEvent->endTime) . ')' : '') . $strTimeClose;
            if ($objEvent->nextStartTime)
            {
                $nextDate = $strTimeStart .
                    \Date::parse($objPage->dateFormat, $objEvent->nextStartTime) . ($objEvent->addTime ? ' (' . \Date::parse($objPage->timeFormat, $objEvent->nextStartTime) . $strTimeClose .
                    ' - ' . $strTimeEnd . \Date::parse($objPage->timeFormat, $objEvent->nextEndTime) . ')' : '') . $strTimeClose;
            }
        }

		$until = '';
		$recurring = '';

		// Recurring event
		if ($objEvent->recurring)
		{
			$arrRange = deserialize($objEvent->repeatEach);
			$strKey = 'cal_' . $arrRange['unit'];
			$recurring = sprintf($GLOBALS['TL_LANG']['MSC'][$strKey], $arrRange['value']);

			if ($objEvent->recurrences > 0)
			{
				$until = sprintf($GLOBALS['TL_LANG']['MSC']['cal_until'], \Date::parse($objPage->dateFormat, $objEvent->repeatEnd));
			}
		}

        // Recurring eventExt
        if ($objEvent->recurringExt)
        {
            $arrRange = deserialize($objEvent->repeatEachExt);
            $strKey = 'cal_' . $arrRange['value'];
            $strVal = $GLOBALS['TL_LANG']['DAYS'][$GLOBALS['TL_LANG']['DAYS'][$arrRange['unit']]];
            $recurring = sprintf($GLOBALS['TL_LANG']['MSC'][$strKey], $strVal);

            if ($objEvent->recurrences > 0)
            {
                $until = sprintf($GLOBALS['TL_LANG']['MSC']['cal_until'], \Date::parse($objPage->dateFormat, $objEvent->repeatEnd));
            }
        }

        // moveReason fix...
        $moveReason = null;

        // get moveReason from exceptions
        if ($objEvent->useExceptions)
        {
            $exceptions = deserialize($objEvent->exceptionList);
            if ($exceptions)
            {
                foreach ($exceptions as $fixedDate)
                {
                    // look for the reason only if we have a move action
                    if ($fixedDate['action'] === "move")
                    {
                        // value to add to the old date
                        $addToDate = $fixedDate['new_exception'];
                        $newDate = strtotime($addToDate, $fixedDate['exception']);
                        if (date("Ymd", $newDate) == date("Ymd", $objEvent->startTime))
                        {
                            $moveReason = ($fixedDate['reason']) ? $fixedDate['reason'] : null;
                        }
                    }
                }
            }
        }

        // get moveReason from fixed dates if exists...
        if (!is_null($objEvent->repeatFixedDates))
        {
            $arrFixedDates = deserialize($objEvent->repeatFixedDates);
            foreach ($arrFixedDates as $fixedDate)
            {
                if (date("Ymd", strtotime($fixedDate['new_repeat'])) == date("Ymd", $objEvent->startTime))
                {
                    $moveReason = ($fixedDate['reason']) ? $fixedDate['reason'] : null;
                }
            }
        }

        // Override the default image size
		if ($this->imgSize != '')
		{
			$size = deserialize($this->imgSize);

			if ($size[0] > 0 || $size[1] > 0)
			{
				$objEvent->size = $this->imgSize;
			}
		}

		$objTemplate = new \FrontendTemplate($this->cal_template);
		$objTemplate->setData($objEvent->row());

		$objTemplate->date = $date;
		$objTemplate->start = $objEvent->startTime;
		$objTemplate->end = $objEvent->endTime;
		$objTemplate->class = ($objEvent->cssClass != '') ? ' ' . $objEvent->cssClass : '';
		$objTemplate->recurring = $recurring;
		$objTemplate->until = $until;
		$objTemplate->locationLabel = $GLOBALS['TL_LANG']['MSC']['location'];

        // set other values...
        $objTemplate->nextDate = ($nextDate) ? $nextDate : null;
        $objTemplate->moveReason = ($moveReason) ? $moveReason : null;

        // Restore event times...
        $objEvent->startTime = $orgStartTime;
        $objEvent->endTime = $orgEndTime;

        $objTemplate->details = '';
		$objElement = \ContentModel::findPublishedByPidAndTable($objEvent->id, 'tl_calendar_events');

		if ($objElement !== null)
		{
			while ($objElement->next())
			{
				$objTemplate->details .= $this->getContentElement($objElement->id);
			}
		}

		$objTemplate->addImage = false;

        // Add an image
        if ($objEvent->addImage && $objEvent->singleSRC != '')
        {
            $objModel = \FilesModel::findByUuid($objEvent->singleSRC);

            if ($objModel === null)
            {
                if (!\Validator::isUuid($objEvent->singleSRC))
                {
                    $objTemplate->text = '<p class="error">'.$GLOBALS['TL_LANG']['ERR']['version2format'].'</p>';
                }
            }
            elseif (is_file(TL_ROOT . '/' . $objModel->path))
            {
                // Do not override the field now that we have a model registry (see #6303)
                $arrEvent = $objEvent->row();
                $arrEvent['singleSRC'] = $objModel->path;

                $this->addImageToTemplate($objTemplate, $arrEvent);
            }
        }

		$objTemplate->enclosure = array();

		// Add enclosures
		if ($objEvent->addEnclosure)
		{
			$this->addEnclosuresToTemplate($objTemplate, $objEvent->row());
		}

		$this->Template->event = $objTemplate->parse();

		// HOOK: comments extension required
		if ($objEvent->noComments || !in_array('comments', \ModuleLoader::getActive()))
		{
			$this->Template->allowComments = false;
			return;
		}

		$objCalendar = $objEvent->getRelated('pid');
		$this->Template->allowComments = $objCalendar->allowComments;

		// Comments are not allowed
		if (!$objCalendar->allowComments)
		{
			return;
		}

		// Adjust the comments headline level
		$intHl = min(intval(str_replace('h', '', $this->hl)), 5);
		$this->Template->hlc = 'h' . ($intHl + 1);

		$this->import('Comments');
		$arrNotifies = array();

		// Notify the system administrator
		if ($objCalendar->notify != 'notify_author')
		{
			$arrNotifies[] = $GLOBALS['TL_ADMIN_EMAIL'];
		}

		// Notify the author
		if ($objCalendar->notify != 'notify_admin')
		{
			if (($objAuthor = $objEvent->getRelated('author')) !== null && $objAuthor->email != '')
			{
				$arrNotifies[] = $objAuthor->email;
			}
		}

		$objConfig = new \stdClass();

		$objConfig->perPage = $objCalendar->perPage;
		$objConfig->order = $objCalendar->sortOrder;
		$objConfig->template = $this->com_template;
		$objConfig->requireLogin = $objCalendar->requireLogin;
		$objConfig->disableCaptcha = $objCalendar->disableCaptcha;
		$objConfig->bbcode = $objCalendar->bbcode;
		$objConfig->moderate = $objCalendar->moderate;

		$this->Comments->addCommentsToTemplate($this->Template, $objConfig, 'tl_calendar_events', $objEvent->id, $arrNotifies);
	}
}
