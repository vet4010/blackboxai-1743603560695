<?php
namespace Espo\Custom\Models;

use Espo\Core\ORM\Entity;

class Task extends Entity
{
    public function getParentTask()
    {
        return $this->get('parentTask');
    }

    public function getChildTasks()
    {
        return $this->get('childTasks');
    }

    protected function _hasParent()
    {
        return $this->has('parentId') && $this->get('parentId');
    }

    protected function _validateDependencies()
    {
        if ($this->_hasParent() && $this->get('parentId') === $this->id) {
            throw new \Espo\Core\Exceptions\Error("Task cannot depend on itself");
        }

        if ($this->_hasParent()) {
            $parent = $this->getEntityManager()->getEntity('Task', $this->get('parentId'));
            if (!$parent) {
                throw new \Espo\Core\Exceptions\Error("Parent task not found");
            }
        }
    }

    protected function _beforeSave()
    {
        parent::_beforeSave();
        $this->_validateDependencies();
    }
}