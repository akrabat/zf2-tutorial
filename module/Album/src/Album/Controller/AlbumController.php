<?php

namespace Album\Controller;

use Zend\Mvc\Controller\ActionController,
    Album\Model\AlbumTable,
    Album\Model\Album,
    Album\Form\AlbumForm,
    Zend\View\Model\ViewModel;

class AlbumController extends ActionController
{
    /**
     * @var \Album\Model\AlbumTable
     */
    protected $albumTable;

    public function indexAction()
    {
        return new ViewModel(array(
            'albums' => $this->albumTable->fetchAll(),
        ));
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setAttribute('label', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album;
            $form->setInputFilter($album->getInputFilter());
            $form->bind($album);
            $form->setData($request->post());
            if ($form->isValid()) {
                $this->albumTable->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');

            }
        }

        return array('form' => $form);
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $id = $request->query()->get('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array('action'=>'add'));
        }
        $album = $this->albumTable->getAlbum($id);

        $form = new AlbumForm();
        $form->get('submit')->setAttribute('label', 'Edit');
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->bind($album);
            $form->setData($request->post());
            if ($form->isValid()) {
                $this->albumTable->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        } else {
            $form->setData($album->getArrayCopy());
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->post()->get('del', 'No');
            if ($del == 'Yes') {
                $id = $request->post()->get('id');
                $this->albumTable->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('default', array(
                'controller' => 'album',
                'action'     => 'index',
            ));
        }

        $id = $request->query()->get('id', 0);
        return array('album' => $this->albumTable->getAlbum($id));        
    }

    public function setAlbumTable(AlbumTable $albumTable)
    {
        $this->albumTable = $albumTable;
        return $this;
    }    
}