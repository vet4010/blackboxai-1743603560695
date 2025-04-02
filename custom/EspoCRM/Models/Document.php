<?php
namespace Espo\Custom\Models;

use Espo\Core\ORM\Entity;

class Document extends Entity
{
    public function getFile()
    {
        return $this->get('file');
    }

    public function getCategory()
    {
        return $this->get('category');
    }

    public function getTags()
    {
        return $this->get('tags') ? json_decode($this->get('tags'), true) : [];
    }

    public function setTags(array $tags)
    {
        $this->set('tags', json_encode($tags));
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();

        if ($this->isNew() && !$this->has('fileId')) {
            throw new \Espo\Core\Exceptions\Error("File is required");
        }
    }
}