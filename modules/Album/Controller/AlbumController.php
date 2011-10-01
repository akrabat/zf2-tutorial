<?php

namespace Album\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\Mvc\Router\RouteStack,
    Album\Model\DbTable\Albums,
    Album\Form\Album as AlbumForm;

class AlbumController extends ActionController
{
    /**
     *
     * @var Album\Model\DbTable\Albums
     */
    protected $albums;

    public function indexAction()
    {
        return array(
            'albums' => $this->albums->fetchAll(),
        );
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->submit->setLabel('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $this->albums->addAlbum($artist, $title);

                // Redirect to list of albums
                return $this->redirectToList();
            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $form = new AlbumForm();
        $form->id->addValidator('GreaterThan', true, array('min' => 0));
        $form->submit->setLabel('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $this->albums->updateAlbum($id, $artist, $title);

                // Redirect to list of albums
                return $this->redirectToList();
            }
        } else {
            $id = $request->query()->get('id', 0);
            if ($id > 0) {
                $form->populate($this->albums->getAlbum($id));
            }
        }

        return array('form' => $form);
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->post()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->post()->get('id');
                $this->albums->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirectToList();
        } 

        $id = $request->query()->get('id', 0);
        return array('album' => $this->albums->getAlbum($id));
    }
    
    protected function redirectToList()
    {
        // Redirect to list of albums
        $url = $this->router->assemble(
            array('controller' => 'album', 'action' => 'index'),
            array('name' => 'default')
        );
        $this->response->setStatusCode(302);
        $this->response->headers()->addHeaderLine('Location', $url);
        return $this->response;
    }

    public function setTable(Albums $table)
    {
        $this->albums = $table;
        return $this;
    }

    public function setRouter(RouteStack $router)
    {
        $this->router = $router;
        return $this;
    }

}
