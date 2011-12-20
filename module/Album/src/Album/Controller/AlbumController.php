<?php

namespace Album\Controller;

use Zend\Mvc\Controller\ActionController,
    Album\Model\AlbumTable;

class AlbumController extends ActionController
{
    /**
     * @var \Album\Model\AlbumTable
     */
    protected $albumTable;

    public function indexAction()
    {
        return array(
            'albums' => $this->albumTable->fetchAll(),
        );
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

    public function setAlbums(AlbumTable $albumTable)
    {
        $this->albumTable = $albumTable;
        return $this;
    }    
}