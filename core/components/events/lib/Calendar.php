<?php

/**
 * Calendar (using Zend_Date)
 *
 * @author     Arietis Software <code@arietis-software.com>
 * @copyright  Copyright (c) 2011 Arietis Software Innovations
 * @license    http://www.software.com/license/gnu/license.txt   GNU License Version 3
 *
 * @package    events
 *
 */
class Calendar
{

    protected $_now; //todays date
    protected $_focusDate; //date in focus
    protected $_monthNames;
    protected $_dayNames;
    protected $_monthsInRange; //months in range of now
    protected $_numMonthDays;
    protected $_nextMonth;
    protected $_prevMonth;
    protected $_firstDayOfWeek;
    protected $_numWeeks;
    protected $_eventsArray;

    /**
     * @param String $date
     */
    public function __construct($date = null)
    {
        $this->_eventsArray = null;
        $this->_now = Zend_Date::now(); //today
        $this->setDateInFocus($date);
    }

    public function setEventModel($event)
    {
        $this->_eventModel = $event;
    }

    /**
     * @param String $date
     */
    public function setDateInFocus($date = null)
    {
        try {
            $this->_focusDate = new Zend_Date($date, "M yyyy"); //month to show
        } catch (Zend_Date_Exception $e) {
            $this->_focusDate = new Zend_Date(null, "M yyyy"); //month to show
        }
        //date params
        $this->initDateParams($this->_focusDate);
    }

    /**
     * @param Zend_Date $date
     */
    protected function initDateParams(Zend_Date $date)
    {
        $this->_monthNames = Zend_Locale::getTranslationList('Month'); //locale month list
        $this->_dayNames = Zend_Locale::getTranslationList('Day'); //locale day list
        $this->setMonthsInRange(); //set locale valid dates
        $this->_numMonthDays = $date->get(Zend_Date::MONTH_DAYS); //num days in locale month
        $this->setNextMonth($date); //set the next month
        $this->setPrevMonth($date); //set the previous month
        $this->_firstDayOfWeek = $date->get(Zend_Date::WEEKDAY_DIGIT); //first day of the curr month
        $this->_numWeeks = ceil(($this->getFirstDayOfWeek() + $this->getNumMonthDays()) / 7); //num weeks in curr month
    }

    /**
     *
     * @param int $startOffset
     * @param int $endOffset
     */
    public function setMonthsInRange($startOffset = -3, $endOffset = 11)
    {
        $tmp = clone $this->_now;
        $startMonth = $tmp->subMonth(abs($startOffset));

        $this->_monthsInRange = array();
        array_push($this->_monthsInRange, $startMonth);

        $tmp = clone $startMonth;
        for ($i = 0; $i < (abs($startOffset) + abs($endOffset)); $i++) {
            $nextMonth = $tmp->addMonth(1);
            array_push($this->_monthsInRange, $nextMonth);
            $tmp = clone $nextMonth;
        }
        unset($tmp);
    }

    /**
     *
     * @param Zend_Date $date
     */
    protected function setNextMonth(Zend_Date $date)
    {
        $temp_focusDate = clone $date;
        $this->_nextMonth = $temp_focusDate->addMonth(1);
    }

    /**
     *
     * @param Zend_Date $date
     */
    protected function setPrevMonth(Zend_Date $date)
    {
        $temp_focusDate = clone $date;
        $this->_prevMonth = $temp_focusDate->subMonth(1);
    }

    public function setEventArray($arr)
    {
        $this->_eventsArray = $arr;
    }

    /**
     *
     */
    public function getNow()
    {
        return $this->_now;
    }

    /**
     * @return Zend_Date
     */
    public function getDateInFocus()
    {
        return $this->_focusDate;
    }

    /**
     * @return String
     */
    public function getDateInFocusAsString()
    {
        return $this->_focusDate->get("MMMM yyyy");
    }

    /**
     * @return String
     */
    public function getMonthName()
    {
        return $this->_focusDate->get("MMMM");
    }

    /**
     * @return String
     */
    public function getMonthShortName()
    {
        return $this->_focusDate->get("MMM");
    }

    /**
     * @return int
     */
    public function getMonthNum()
    {
        return $this->_focusDate->get("MM");
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->_focusDate->get("yyyy");
    }

    /**
     * @return Array
     */
    public function getMonthNames()
    {
        return $this->_monthNames;
    }

    /**
     * @return Array
     */
    public function getDayNames()
    {
        return $this->_dayNames;
    }

    /**
     * @return Array
     */
    public function getMonthsInRange()
    {
        return $this->_monthsInRange;
    }

    /**
     *
     * @return <type>
     */
    public function getMonthsInRangeAsArray()
    {
        $arr = array();
        foreach ($this->_monthsInRange as $month) {
            $arr[$month->get('MM yyyy')] = $month->get('MMMM yyyy');
        }
        return $arr;
    }

    /**
     * @return int
     */
    public function getNumMonthDays()
    {
        return $this->_numMonthDays;
    }

    /**
     *
     */
    public function getNextMonth()
    {
        return $this->_nextMonth;
    }

    /**
     * @return String
     */
    public function getNextMonthName()
    {
        return $this->_nextMonth->get("MMMM");
    }

    /**
     * @return int
     */
    public function getNextMonthNum()
    {
        return $this->_nextMonth->get("MM");
    }

    /**
     * @return int
     */
    public function getNextMonthYear()
    {
        return $this->_nextMonth->get("yyyy");
    }

    /**
     * @return String "MMMM yyyy"
     */
    public function getNextMonthAsDateString()
    {
        return $this->_nextMonth->get("MMMM yyyy");
    }

    /**
     *
     */
    public function getPrevMonth()
    {
        return $this->_prevMonth;
    }

    /**
     * @return String
     */
    public function getPrevMonthName()
    {
        return $this->_prevMonth->get("MMMM");
    }

    /**
     * @return int
     */
    public function getPrevMonthNum()
    {
        return $this->_prevMonth->get("MM");
    }

    /**
     * @return int
     */
    public function getPrevMonthYear()
    {
        return $this->_prevMonth->get("yyyy");
    }

    /**
     * @return String
     */
    public function getPrevMonthAsDateString()
    {
        return $this->_prevMonth->get("MMMM yyyy");
    }

    /**
     * @return int
     */
    public function getFirstDayOfWeek()
    {
        return $this->_firstDayOfWeek;
    }

    /**
     * @return int
     */
    public function getNumWeeks()
    {
        return $this->_numWeeks;
    }

    /**
     *
     * @return <type>
     */
    public function getMiniCalArray($modx, $resourceId)
    {
        //Calendar vars
        $today = (int)$this->getNow()->get("d");
        $nowDate = $this->getNow()->get("MMMM yyyy");
        $focusDate = $this->getDateInFocus()->get("MMMM yyyy");
        $calDayNum = 1; //init

        //build list of weekdays
        $wkDayArr = array();
        foreach ($this->getDayNames() as $dayShort => $dayLong) {
            array_push($wkDayArr, $dayShort);
        }

        //build calendar days
        $calDaysArr = array();
        $firstDayOfWeek = (int)$this->getFirstDayOfWeek();
        $numMonthDays = (int)$this->getNumMonthDays();
        $numWeeks = (int)$this->getNumWeeks();

        for ($i = 0; $i < $numWeeks; $i++) {

            $calendarColsArr = array();

            for ($j = 0; $j < 7; $j++) {

                $cellNum = ($i * 7 + $j);

                //set the table cell's class
                $classArr = array('day'); //base class
                if ($cellNum < $firstDayOfWeek || $calDayNum > $numMonthDays) { //empty cell
                    array_push($classArr, 'blank');
                }
                if ($nowDate == $focusDate && $today == $calDayNum && $cellNum >= $firstDayOfWeek) { //is today
                    array_push($classArr, 'today');
                }
                if (isset($this->_eventsArray[$calDayNum])) { //a day with events
                    array_push($classArr, 'event');
                }
                $cellData = array(
                    'class' => implode(' ', $classArr)
                );

                //build the day of the month cell html
                if ($cellNum >= $firstDayOfWeek && $cellNum < ($numMonthDays + $firstDayOfWeek)) { //day in cell
                    $dayNum = (int)Zend_Locale_Format::toNumber($calDayNum);
                    $cellData['day'] = $dayNum;
                    $cellData['events'] = array();

                    //build array of eventsw
                    if (isset($this->_eventsArray[$calDayNum])) {
                        foreach ($this->_eventsArray[$calDayNum] as $item) {
                            $item['href'] = $modx->makeUrl((int)$resourceId, '', '&event-id=' . $item['id'], 'full');
                            array_push($cellData['events'], $item);
                        }
                    }

                    $calDayNum++;
                } else { //no day in cell
                    $cellData['day'] = false;
                }

                array_push($calendarColsArr, $cellData);
            }

            array_push($calDaysArr, $calendarColsArr);
        }

        return array(
            'weekdayArray' => $wkDayArr,
            'calendarDaysArray' => $calDaysArr
        );
    }

}
