<?php

namespace Application\View;

use ArrayAccess,
    Zend\EventManager\EventCollection,
    Zend\EventManager\ListenerAggregate,
    Zend\Http\Response,
    Zend\Mvc\Application,
    Zend\Mvc\MvcEvent,
    Zend\View\Renderer;

class Listener implements ListenerAggregate
{
    protected $layout;
    protected $listeners = array();
    protected $view;
    protected $displayExceptions = false;

    public function __construct(Renderer $renderer, $layout = 'layout.phtml')
    {
        $this->view   = $renderer;
        $this->layout = $layout;
    }

    public function setDisplayExceptionsFlag($flag)
    {
        $this->displayExceptions = (bool) $flag;
        return $this;
    }

    public function displayExceptions()
    {
        return $this->displayExceptions;
    }

    public function attach(EventCollection $events)
    {
        $this->listeners[] = $events->attach('dispatch.error', array($this, 'renderError'));
        $this->listeners[] = $events->attach('dispatch', array($this, 'render404'), -80);
        $this->listeners[] = $events->attach('dispatch', array($this, 'renderView'), -100);
        $this->listeners[] = $events->attach('dispatch', array($this, 'renderLayout'), -1000);
    }

    public function detach(EventCollection $events)
    {
        foreach ($this->listeners as $key => $listener) {
            $events->detach($listener);
            unset($this->listeners[$key]);
            unset($listener);
        }
    }

    public function renderView(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();
        $controller = $routeMatch->getParam('controller', 'index');
        $action     = $routeMatch->getParam('action', 'index');
        $script     = $controller . '/' . $action . '.phtml';

        $vars       = $e->getResult();
        if (is_scalar($vars)) {
            $vars = array('content' => $vars);
        } elseif (is_object($vars) && !$vars instanceof ArrayAccess) {
            $vars = (array) $vars;
        }

        $content    = $this->view->render($script, $vars);

        $e->setResult($content);
        return $content;
    }

    public function renderLayout(MvcEvent $e)
    {
        $content  = $e->getResult();
        $layout   = $this->view->render($this->layout, array('content' => $content));
        $response = $e->getResponse();
        if (!$response) {
            $response = new Response();
            $e->setResponse($response);
        }
        $response->setContent($layout);
        return $response;
    }

    public function render404(MvcEvent $e)
    {
        $vars = $e->getResult();
        if ($vars instanceof Response) {
            return;
        }

        $response = $e->getResponse();
        if ($response->getStatusCode() != 404) {
            // Only handle 404's
            return;
        }

        $vars = array('message' => 'Page not found.');

        $content = $this->view->render('error/index.phtml', $vars);

        $e->setResult($content);

        return $this->renderLayout($e);
    }

    public function renderError(MvcEvent $e)
    {
        $error    = $e->getError();
        $app      = $e->getTarget();
        $response = $e->getResponse();
        if (!$response) {
            $response = new Response();
            $e->setResponse($response);
        }

        switch ($error) {
            case Application::ERROR_CONTROLLER_NOT_FOUND:
            case Application::ERROR_CONTROLLER_INVALID:
                $vars = array(
                    'message' => 'Page not found.',
                    'exception'          => $e->getParam('exception'),
                    'display_exceptions' => $this->displayExceptions(),
                );
                $response->setStatusCode(404);
                break;

            case Application::ERROR_EXCEPTION:
            default:
                $exception = $e->getParam('exception');
                $vars = array(
                    'message'            => 'An error occurred during execution; please try again later.',
                    'exception'          => $e->getParam('exception'),
                    'display_exceptions' => $this->displayExceptions(),
                );
                $response->setStatusCode(500);
                break;
        }

        $content = $this->view->render('error/index.phtml', $vars);

        $e->setResult($content);

        return $this->renderLayout($e);
    }
}
