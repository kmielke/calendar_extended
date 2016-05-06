<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (c) 2005-2016 Leo Feyer
 * 
 * @license LGPL-3.0+
 */

namespace Contao;


/**
 * Reads leads
 *
 * @author    Kester Mielke
 */
class CalendarLeadsModel extends \Model
{

	/**
	 * Table name
	 * @var string
	 */
	protected static $strTableMaster = 'tl_lead';
	protected static $strTableDetail = 'tl_lead_data';


	/**
	 * @param $fid int formularid
	 * @param $eid int eventid
	 *
	 * @return \Database\Result|object
	 */
	public static function regCountByFormEvent($fid, $eid)
	{
		// SQL bauen
		$arrsql[] = 'select sum(ld3.value) as count';
		$arrsql[] = 'from '.static::$strTableMaster.' lm';
		$arrsql[] = 'left join '.static::$strTableDetail.' ld1 on lm.id = ld1.pid';
		$arrsql[] = 'left join '.static::$strTableDetail.' ld2 on ld2.pid = ld1.pid';
		$arrsql[] = 'left join '.static::$strTableDetail.' ld3 on ld3.pid = ld2.pid';
		$arrsql[] = 'where lm.form_id = ? and ld1.value = ?';
		$arrsql[] = 'and ld2.name = "published" and ld2.value = 1';
		$arrsql[] = 'and ld3.name = "count";';
		$sql = implode(' ', $arrsql);

		// und ausführen
		$objResult = \Database::getInstance()->prepare($sql)->execute($fid, $eid);
		$count = ($objResult->count) ? $objResult->count : 0;

		return $count;
	}
}
