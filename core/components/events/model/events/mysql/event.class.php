<?php

require_once (strtr(realpath(dirname(dirname(__FILE__))), '\\', '/') . '/event.class.php');

class Event_mysql extends Event
{
    public function __construct(& $xpdo)
    {
        parent :: __construct($xpdo);
    }
}
