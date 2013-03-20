<?php

/**
 * event snippet
 *
 * @author     Arietis Software <code@arietis-software.com>
 * @copyright  Copyright (c) 2011 Arietis Software Innovations
 * @license    http://www.software.com/license/gnu/license.txt   GNU License Version 3
 *
 * @package events
 *
 * @params:
 * filterStr            (string)
 * sortStr              (string)
 * showMinical          (boolean)
 * eventsResourceId     (int)
 *
 * @todo
 *
 *
 */
$hasDevCorePath = $modx->getOption('dev.core_path', null, false);
if (false !== $hasDevCorePath) {
    error_reporting(8191);
    ini_set('display_errors', true);
}

//clean script properties, cast (string)true|false to boolean
foreach ($scriptProperties as $property => &$val) {
    if ($val == 'true') {
        $val = true;
    } elseif ($val == 'false') {
        $val = false;
    }
}

//global paths
$corePath = $modx->getOption('dev.core_path', null, $modx->getOption('core_path')) . 'components/events/';
$assetsUrl = $modx->getOption('dev.assets_url', null, $modx->getOption('assets_url')) . 'components/events/';
$eventsService = $modx->getService('events', 'Events', $corePath . 'model/events/', $scriptProperties);

if (!($eventsService instanceof Events))
    return '';

//incl paths
$paths = array(
    realpath($eventsService->config['libPath']),
    get_include_path()
);
set_include_path(implode(PATH_SEPARATOR, $paths));

//snippet params
$filterStr = $modx->getOption('filterStr', $scriptProperties, false); //default no filter
$sortStr = $modx->getOption('sortStr', $scriptProperties, false); //default no sort
$showMinical = $modx->getOption('showMinical', $scriptProperties, false); //default no minical
$eventsResourceId = $modx->getOption('eventsResourceId', $scriptProperties, false); //default no resourceId

//minical vars
$eventId = (isset($_GET['event-id'])) ? intval($_GET['event-id']) : false; //used as get param only
$currMonth = date('m Y', strtotime('NOW'));
$start = (isset($_GET['start'])) ? intval($_GET['start']) : 0;
$limit = (isset($_GET['limit'])) ? intval($_GET['limit']) : 20;

//smarty init
$modx->getService('smarty', 'smarty.modSmarty');
$modx->smarty->setTemplatePath($eventsService->config['smartyPath']);

// CONTROLLER
if (isset($showMinical) && $showMinical) { //MINI CALENDAR

    //extjs css/js
    $modx->regClientCSS('http://extjs.cachefly.net/ext-3.4.0/resources/css/ext-all.css');
    $modx->regClientScript('http://extjs.cachefly.net/ext-3.4.0/adapter/ext/ext-base.js');
    $modx->regClientScript('http://extjs.cachefly.net/ext-3.4.0/ext-all.js');

    //minical css/js
    $modx->regClientCSS($eventsService->config['cssUrl'] . 'minical.css');
    $modx->regClientScript($eventsService->config['jsUrl'] . 'minical.js');

    //libs
    require_once 'Zend/Date.php';
    require_once 'Calendar.php';

    //calendar service
    $monthYear = date('m Y');
    if (array_key_exists('monthYear', $_REQUEST)) {
        $monthYear = $_REQUEST['monthYear'];
    }
    $calendar = new Calendar($monthYear);

    //build array (day num indexed) of events for current month
    $c = $modx->newQuery('Event');
    $c->where(array(
        'date:LIKE' => '%' . $calendar->getDateInFocus()->get("yyyy-MM") . '%',
        'published' => 1
    ));

    $events = $modx->getCollection('Event', $c);
    $eventArray = array();
    foreach ($events as $event) {
        $day = date('j', strtotime($event->date)); //day without leading zeros
        if (!isset($eventArray[$day])) {
            $eventArray[$day] = array($event->toArray());
        } else {
            array_push($eventArray[$day], $event->toArray());
        }
    }

    //pass the events array to the calendar service
    $calendar->setEventArray($eventArray);

    //get minical data array
    $miniCalDataArray = $calendar->getMiniCalArray($modx, $eventsResourceId);

    //tpl
    $modx->smarty->assign('weekDays', $miniCalDataArray['weekdayArray']);
    $modx->smarty->assign('calDays', $miniCalDataArray['calendarDaysArray']);

    $miniCalTableHtml = $modx->smarty->fetch('miniCalTable.smarty.tpl');

    //tpl
    $modx->smarty->assign('monthOptions', $calendar->getMonthsInRangeAsArray());
    $modx->smarty->assign('currMonth', $currMonth);
    $modx->smarty->assign('eventsResourceId', $eventsResourceId);
    $modx->smarty->assign('miniCalTableHtml', $miniCalTableHtml);

    $output = $modx->smarty->fetch('miniCalWrapper.smarty.tpl');

} else { //EVENT DETAIL || EVENT LIST

    $modx->regClientCSS($eventsService->config['cssUrl'] . 'events.css');

    $c = $modx->newQuery('Event');

    //filtering
    if (!$filterStr) { //unfiltered published events
        $whereArr['published'] = 1;
    } else { //add where criteria/filter
        $filterArr = explode(';', $filterStr);
        foreach ($filterArr as $pair) {
            $capture = preg_split('/[!:=<>LIKE]+/', $pair, null, PREG_SPLIT_OFFSET_CAPTURE);
            $key = substr($pair, 0, $capture[1][1]);
            if (substr($key, -1, 1) == ':') { //eg: id:1
                $key = substr($key, 0, strlen($key) - 1);
            } elseif (substr($key, -2, 2) == ':=') { //eg. id:=1
                $key = substr($key, 0, strlen($key) - 2);
            }
            $val = $capture[1][0];
            $whereArr[$key] = $val;
        }
    }
    //if asking for a single event, set the appropriate id
    if ($eventId && is_int($eventId)) {
        $whereArr['id'] = $eventId;
    }
    $c->where($whereArr);

    //sorting
    if (!empty($sortStr)) {
        $sortArr = explode(';', $sortStr);
        foreach ($sortArr as $pair) {
            $pairArr = explode(':', $pair);
            $c->sortby($pairArr[0], $pairArr[1]);
        }
    }

    if (array_key_exists('id', $whereArr) || ($eventId && is_int($eventId))) { //show event detail

        $events = $modx->getCollection('Event', $c);
        $row = array();
        foreach ($events as $event) {
            $row = $event->toArray();
        }
        $modx->smarty->assign('event', $row);

        if (is_int($eventId)) {
            $modx->smarty->assign('isFromList', true);
            $modx->smarty->assign('backHref', $modx->makeUrl($modx->resource->get('id')));
        }

        $output = $modx->smarty->fetch('eventDetail.smarty.tpl');

    } else { //show event list

        //build pagination template
        require_once 'Pagination.php';
        $count = $modx->getCount('Event',$c);
        $p = new Pagination($modx, $count, $start, $limit);

        $modx->smarty->assign('currPageNum', $p->getCurrPageNum());
        $modx->smarty->assign('prevPgHref', $p->getPrevPgHref());
        $modx->smarty->assign('docUrl', $modx->makeUrl($modx->resource->get('id')));
        $modx->smarty->assign('limit', $limit);
        $modx->smarty->assign('numPages', $p->getNumPages());
        $modx->smarty->assign('nextPgHref', $p->getNextPgHref());

        $paginationHtml = $modx->smarty->fetch('pagination.smarty.tpl');

        //limit (includes pagination)
        $c->limit($limit, $start);

        //Iterator
        $events = $modx->getCollection('Event', $c);

        //event list smarty template
        $rows = array();
        foreach ($events as $event) {
            $eventArr = $event->toArray();
            $eventArr['href'] = $modx->makeUrl($modx->resource->get('id'), '', '&event-id=' . $eventArr['id'], 'full');
            array_push($rows, $eventArr);
        }
        $modx->smarty->assign('pagination', $paginationHtml);
        $modx->smarty->assign('events', $rows);

        $output = $modx->smarty->fetch('eventList.smarty.tpl');
    }
}

return $output;
