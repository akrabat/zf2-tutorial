<?php

namespace Album\Model;

use Zend\Db\Table\AbstractTable;

class Albums extends AbstractTable
{
    protected $_name = 'albums';

    public function getAlbum($id)
    {
        $id = (int) $id;
        $row = $this->fetchRow('id = ' . $id);
        if (!$row) {
            throw new Exception("Could not find row $id");
        }
        return $row->toArray();
    }

    public function addAlbum($artist, $title)
    {
        $data = array(
            'artist' => $artist,
            'title' => $title,
        );
        $this->insert($data);
    }

    public function updateAlbum($id, $artist, $title)
    {
        $data = array(
            'artist' => $artist,
            'title' => $title,
        );
        $this->update($data, 'id = ' . (int) $id);
    }

    public function deleteAlbum($id)
    {
        $this->delete('id =' . (int) $id);
    }

}
