<?php
require_once MODX_CORE_PATH . 'model/modx/modrequest.class.php';
/**
 * Encapsulates the interaction of MODx manager with an HTTP request.
 *
 * {@inheritdoc}
 *
 * @package events
 * @extends modRequest
 */
class EventsControllerRequest extends modRequest {
    public $event = null;
    public $actionVar = 'action';
    public $defaultAction = 'index';

    function __construct(Events &$events) {
        parent :: __construct($events->modx);
        $this->events =& $events;
    }

    /**
     * Extends modRequest::handleRequest and loads the proper error handler and
     * actionVar value.
     *
     * {@inheritdoc}
     */
    public function handleMgrRequest() {
        $this->loadErrorHandler();

        /* save page to manager object. allow custom actionVar choice for extending classes. */
        $this->action = isset($_REQUEST[$this->actionVar]) ? $_REQUEST[$this->actionVar] : $this->defaultAction;

        $modx =& $this->modx;
        $events =& $this->events;
        $viewHeader = include $this->events->config['corePath'] . 'controllers/mgr/header.php';

        $f = $this->events->config['corePath'] . 'controllers/mgr/' . $this->action . '.php';
        if (file_exists($f)) {
            $viewOutput = include $f;
        } else {
            $viewOutput = 'Controller not found: ' . $f;
        }

        return $viewHeader.$viewOutput;
    }
}
