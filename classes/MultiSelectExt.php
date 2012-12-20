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
 * Class MultiSelectWizard
 *
 * @copyright  certo web & design GmbH 2011
 * @author     Yanick Witschi <yanick.witschi@certo-net.ch>
 * @package    Controller
 */

/**
 * Class MultiSelectWizard 
 *
 * Ich habe die Klasse nach Rücksprache mit Yanick in mein Modul aufgenommen.
 * MultiSelectWizard wird wohl nicht weiter gepflegt.
 *
 * @copyright  Kester Mielke 2010-2013 
 * @author     Kester Mielke 
 * @package    Devtools
 */

class MultiSelectExt extends \Widget
{
    /**
     * Submit user input
     * @var boolean
     */
    protected $blnSubmitInput = true;

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'be_widget';

    /**
     * Array containing all the columns
     * @var string
     */
    protected $arrColumns = array();

    /**
     * Store in localconfig.php - Javascript-Fallback
     * @var boolean
     */
    protected $blnSaveInLocalConfig = false;

    /**
     * Store wherever you want with whatever procedure - Javascript-Fallback
     * @var array
     */
    protected $arrStoreCallback = array();


    /**
     * Add specific attributes
     * @param string
     * @param mixed
     */
    public function __set($strKey, $varValue)
    {
        switch ($strKey)
        {
            case 'value':
                $this->varValue = deserialize($varValue);
                break;

            case 'mandatory':
                $this->arrConfiguration['mandatory'] = $varValue ? true : false;
                break;

            case 'saveInLocalConfig':
                $this->blnSaveInLocalConfig = $varValue;
                break;

            case 'storeCallback':
                if (!is_array($varValue))
                {
                    throw new Exception('Parameter "storeCallback" has to be an array: array(\'Class\', \'Method\')!');
                }

                $this->arrStoreCallback = $varValue;
                break;

            case 'columnsData':
                $this->arrColumns = $varValue;
                break;

            case 'columnsCallback':
                if (!is_array($varValue))
                {
                    throw new Exception('Parameter "columns" has to be an array: array(\'Class\', \'Method\')!');
                }

                $this->import($varValue[0]);
                $this->arrColumns = $this->$varValue[0]->$varValue[1]($this);
                break;

            default:
                parent::__set($strKey, $varValue);
                break;
        }
    }


    /**
     * Generate the widget and return it as string
     * @return string
     */
    public function generate()
    {
        $this->import('Database');

        $arrButtons = array('copy', 'up', 'down', 'delete');
        $strCommand = 'cmd_' . $this->strField;

        // Change the order
        if ($this->Input->get($strCommand) && is_numeric($this->Input->get('cid')) && $this->Input->get('id') == $this->currentRecord)
        {
            switch ($this->Input->get($strCommand))
            {
                case 'copy':
                    $this->varValue = array_duplicate($this->varValue, $this->Input->get('cid'));
                    break;

                case 'up':
                    $this->varValue = array_move_up($this->varValue, $this->Input->get('cid'));
                    break;

                case 'down':
                    $this->varValue = array_move_down($this->varValue, $this->Input->get('cid'));
                    break;

                case 'delete':
                    $this->varValue = array_delete($this->varValue, $this->Input->get('cid'));
                    break;
            }
        }

        // Save the value
        if (\Input::get($strCommand) || \Input::post('FORM_SUBMIT') == $this->strTable)
        {
            if($this->blnSaveInLocalConfig)
            {
                $this->Config->update(sprintf("\$GLOBALS['TL_CONFIG']['%s']", $this->strField), serialize($this->varValue));
            }
            elseif(is_array($this->arrStoreCallback) && count($this->arrStoreCallback))
            {
                $strClass = $this->arrStoreCallback[0];
                $strMethod = $this->arrStoreCallback[1];
                $this->import($strClass);
                $this->$strClass->$strMethod($this);
            }
            else
            {
                $this->Database->prepare("UPDATE " . $this->strTable . " SET " . $this->strField . "=? WHERE id=?")
                    ->execute(serialize($this->varValue), $this->currentRecord);
            }

            // Reload the page
            if (is_numeric(\Input::get('cid')) && \Input::get('id') == $this->currentRecord)
            {
                $this->redirect(preg_replace('/&(amp;)?cid=[^&]*/i', '', preg_replace('/&(amp;)?' . preg_quote($strCommand, '/') . '=[^&]*/i', '', $this->Environment->request)));
            }
        }



        // Add label and return wizard
        $return = '<table cellspacing="0" cellpadding="0" id="ctrl_'.$this->strId.'" class="tl_modulewizard" summary="MultiSelectWizard">
		<thead>
		<tr>';

        foreach($this->arrColumns as $column)
        {
            $return .= '<td>' . $column['label'] . '</td>';
        }

        $return .= '<td> </td>
	  	</tr>
	  	</thead>
	  	<tbody>';

        $intNumberOfRows = max(count($this->varValue), 1);

        // Add input fields
        for($i=0; $i<$intNumberOfRows; $i++)
        {
            $return .= '<tr>';

            // Walk every column
            foreach($this->arrColumns as $k => $column)
            {
                $options = '';

                // foreign key
                if(!is_array($column['source']))
                {
                    $arrKey = explode('.', $column['source']);
                    $objOptions = $this->Database->execute("SELECT id, " . $arrKey[1] . " FROM " . $arrKey[0] . " WHERE tstamp>0 ORDER BY " . $arrKey[1]);

                    if($objOptions->numRows)
                    {
                        while($objOptions->next())
                        {
                            $column['source'][$objOptions->id] = $objOptions->$arrKey[1];
                        }

                    }
                }

                // Build options
                foreach ($column['source'] as $kk => $vv)
                {
                    $options .= '<option value="'.specialchars($kk).'"'.$this->optionSelected($kk, $this->varValue[$i]['values'][$column['key']]).'>' . $vv . '</option>';
                }
                $return .= '<td><select ' . ((isset($column['style'])) ? 'style="' . $column['style'] . '" ' : '') . 'name="'.$this->strId.'['.$i.'][values]['.$column['key'].']" class="tl_select tl_chosen" onfocus="Backend.getScrollOffset();">'.$options.'</select></td>';
            }

            $return .= '<td>';

            // Add buttons
            foreach ($arrButtons as $button)
            {
                $return .= '<a href="'.$this->addToUrl('&'.$strCommand.'='.$button.'&cid='.$i.'&id='.$this->currentRecord).'" title="'.specialchars($GLOBALS['TL_LANG'][$this->strTable]['wz_'.$button]).'" onclick="Backend.moduleWizard(this, \''.$button.'\',  \'ctrl_'.$this->strId.'\'); return false;">'.$this->generateImage($button.'.gif', $GLOBALS['TL_LANG'][$this->strTable]['wz_'.$button], 'class="tl_listwizard_img"').'</a> ';
            }

            $return .= '</td></tr>';
        }

        return $return . '</tbody></table>';
    }


    /**
     * Static helper method to get all the data from a certain key for all the rows
     * @param string
     * @param string
     * @return array
     */
    public static function getByKey($strSerialized, $strKey)
    {
        $arrData = deserialize($strSerialized);
        $arrReturnData = array();

        foreach($arrData as $rowKey => $rowData)
        {
            $arrReturnData[] = $rowData['values'][$strKey];
        }

        return $arrReturnData;
    }


    /**
     * Static helper method to get all the data from a certain key for all the rows that match a certain other row key
     * @param string
     * @param string
     * @param array
     * @return array
     */
    public static function getFilteredByKey($strSerialized, $strKey, $arrConditions)
    {
        $arrData = deserialize($strSerialized);
        $intCountConditions = count($arrConditions);

        $arrReturnData = array();

        foreach($arrData as $rowKey => $rowData)
        {
            $intMeetCondition = 0;

            // check data for every filter
            foreach($arrConditions as $column => $value)
            {
                if($rowData['values'][$column] == $value)
                {
                    $intMeetCondition++;
                }
            }

            // check if the value meets ALL conditions (AND condition)
            if($intMeetCondition == $intCountConditions)
            {
                $arrReturnData[] = $rowData['values'][$strKey];
            }
        }

        return $arrReturnData;
    }
}
