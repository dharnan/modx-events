<?php

/**
 * Get the Minical
 *
 * @package events
 * @subpackage processors
 */

//MiniCal Ajax
if (array_key_exists('action', $_REQUEST) && array_key_exists('monthYear', $_REQUEST)) {

    $corePath = $modx->getOption('dev.core_path', null, $modx->getOption('core_path')) . 'components/events/';
    $eventsService = $modx->getService('events', 'Events', $corePath . 'model/events/');

    if (!($eventsService instanceof Events))
        return '';

    //Smarty
    $modx->getService('smarty', 'smarty.modSmarty');
    $modx->smarty->setTemplatePath($eventsService->config['smartyPath']);
        
    //incl paths
    $paths = array(
        $eventsService->config['libPath'],
        get_include_path()
    );
    set_include_path(implode(PATH_SEPARATOR, $paths));

    //libs
    require_once 'Zend/Date.php';
    require_once 'Calendar.php';

    //calendar model
    $calendar = new Calendar($_REQUEST['monthYear']);

    $eventArray = $modx->cacheManager->get('eventArray');

    //model
    $c = $modx->newQuery('Event');
    $c->where(array(
        'date:LIKE' => '%' . $calendar->getDateInFocus()->get("yyyy-MM") . '%',
        'published' => 0
    ));
    $events = $modx->getCollection('Event', $c);
    $eventArray = array();
    foreach ($events as $event) {
        $day = date('j', strtotime($event->date)); //init the day without leading zeros
        if (!isset($eventArray[$day])) {
            $eventArray[$day] = array($event->toArray());
        } else {
            array_push($eventArray[$day], $event->toArray());
        }
    }


    //put the events in an array indexed to the day num
    $calendar->setEventArray($eventArray);

    //get minical data    
    $miniCalDataArray = $calendar->getMiniCalArray($modx, $_REQUEST['eventsResourceId']);    

    //tpl    
    $modx->smarty->assign('weekDays', $miniCalDataArray['weekdayArray']);
    $modx->smarty->assign('calDays', $miniCalDataArray['calendarDaysArray']);

    //out
    $output = $modx->smarty->fetch('miniCalTable.smarty.tpl');

    return $output;
    
} else {

    return; //invalid access attempt
}
?>
