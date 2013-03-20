<?php
/**
 * @package event
 * @subpackage processors
 */
class EventUpdateProcessor extends modObjectUpdateProcessor {
    public $classKey = 'Event';
    public $languageTopics = array('events:default');
    public $objectType = 'events.event';

    public function beforeSave() {
        $subtype = $this->getProperty('subtype');
        if (empty($subtype)) {
            $this->addFieldError('subtype',$this->modx->lexicon('events.event_err_ns_subtype'));
        }
        $title = $this->getProperty('title');
        if (empty($title)) {
            $this->addFieldError('title',$this->modx->lexicon('events.event_err_ns_title'));
        }
        $date = $this->getProperty('date');
        if (empty($date)) {
            $this->addFieldError('date',$this->modx->lexicon('events.event_err_ns_date'));
        }
        $time = $this->getProperty('time');
        if (empty($time)) {
            $this->addFieldError('time',$this->modx->lexicon('events.event_err_ns_time'));
        }
        return parent::beforeSave();
    }
}
return 'EventUpdateProcessor';
