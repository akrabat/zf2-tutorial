<?php

namespace Album\Controller;

use Zend\Mvc\Controller\ActionController,
    Album\Model\Albums,
    Album\Form\AlbumForm;

class AlbumController extends ActionController
{
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
        $form->submit->setLabel('Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $formData = $request->post()->toArray();
            if ($form->isValid($formData)) {
                $id = $form->getValue('id');
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                
                if ($this->albums->getAlbum($id)) {
                    $this->albums->updateAlbum($id, $artist, $title);
                }

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
                $id = (int) $request->post()->get('id');
                $this->albums->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirectToList();
        }

        $id = $request->query()->get('id', 0);
        return array('album' => $this->albums->getAlbum($id));
    }
    
    public function setAlbums(Albums $albums)
    {
        $this->albums = $albums;
        return $this;
    }
    
    protected function redirectToList()
    {
        // Redirect to list of albums
        return $this->redirect()->toRoute('default', array(
                'controller' => 'album',
                'action' => 'index',
            ));
    }
    
}