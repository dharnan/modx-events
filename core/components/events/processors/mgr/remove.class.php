<?php
/**
 * @package event
 * @subpackage processors
 */
class EventRemoveProcessor extends modObjectRemoveProcessor {
    public $classKey = 'Event';
    public $languageTopics = array('events:default');
    public $objectType = 'events.event';
}
return 'EventRemoveProcessor';
