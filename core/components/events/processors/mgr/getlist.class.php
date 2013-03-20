<?php
/**
 * Get a list of Events
 *
 * @package events
 * @subpackage processors
 */
class EventGetListProcessor extends modObjectGetListProcessor {
    public $classKey = 'Event';
    public $languageTopics = array('events:default');
    public $defaultSortField = 'title';
    public $defaultSortDirection = 'ASC';
    public $objectType = 'events.event';

    public function prepareQueryBeforeCount(xPDOQuery $c) {
        $query = $this->getProperty('query');
        if (!empty($query)) {
            $c->where(array(
                'title:LIKE' => '%'.$query.'%',
                'OR:description:LIKE' => '%'.$query.'%',
            ));
        }
        return $c;
    }
}
return 'EventGetListProcessor';
