<?php
/**
 * @package events
 * @subpackage controllers
 */
require_once dirname(__FILE__) . '/model/events/events.class.php';
abstract class EventsManagerController extends modExtraManagerController {
    /** @var Events $doodles */
    public $events;
    public function initialize() {
        $this->events = new Events($this->modx);

        $this->addCss($this->events->config['cssUrl'].'/mgr/mgr.css');
        $this->addJavascript($this->events->config['jsUrl'].'mgr/events.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            Events.config = '.$this->modx->toJSON($this->events->config).';
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('events:default');
    }
    public function checkPermissions() { return true;}
}
/**
 * @package events
 * @subpackage controllers
 */
class IndexManagerController extends EventsManagerController {
    public static function getDefaultController() { return 'home'; }
}
