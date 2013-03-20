<?php
/**
 * @package events
 * @subpackage controllers
 */
class EventsHomeManagerController extends EventsManagerController {
    public function process(array $scriptProperties = array()) {

    }
    public function getPageTitle() { return $this->modx->lexicon('events'); }
    public function loadCustomCssJs() {
        $this->addJavascript($this->events->config['jsUrl'].'mgr/widgets/events.grid.js');
        $this->addJavascript($this->events->config['jsUrl'].'mgr/widgets/home.panel.js');
        $this->addLastJavascript($this->events->config['jsUrl'].'mgr/sections/index.js');
    }
    public function getTemplateFile() {
        return $this->events->config['templatesPath'].'home.tpl';
    }
}
