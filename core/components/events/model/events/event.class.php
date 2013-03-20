<?php

class Event extends xPDOSimpleObject
{
    public function __construct(& $xpdo)
    {
        parent :: __construct($xpdo);
    }

    /**
     * Overrides xPDOObject::save to add edited/created auto-filling fields
     *
     * {@inheritDoc}
     */
    public function save($cacheFlag = null) {

        $this->set('title', ucwords($this->title));
        $this->set('date', date('Y-m-d', strtotime($this->date)));
        $this->set('time', date('h:i:s', strtotime($this->time)));
        $this->set('description', $this->description);

        $this->set('published', 0);
        if (isset($this->published) && $this->published == 'on') {
            $this->set('published', 1);
        }

        $this->set('datetime_created', date('Y-m-d H:i:s', strtotime('NOW')));
        $this->set('datetime_modified', date('Y-m-d H:i:s', strtotime('NOW')));
        return parent::save($cacheFlag);
    }

    /**
     *
     */
    public function getDateTimeShort() {
        return date("M d, Y @ H:m A", strtotime($this->date . ' ' . $this->time));
    }

    /**
     *
     */
    public function getDescription() {
        return $this->description;
    }

}
