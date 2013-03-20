<?php

/**
 * Resolve creating custom db tables during install.
 *
 * @package events
 * @subpackage build
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION])
    {
    case xPDOTransport::ACTION_INSTALL:
        $modx = & $object->xpdo;
        $modelPath = $modx->getOption('dev.core_path', null, $modx->getOption('core_path')) . 'components/events/model/';
        $modx->addPackage('events', $modelPath);

        $manager = $modx->getManager();

        $manager->createObjectContainer('Event');

        break;
    case xPDOTransport::ACTION_UPGRADE:
        break;
    }
}
return true;
