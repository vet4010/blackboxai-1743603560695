<?php
namespace Espo\Custom\Controllers;

use Espo\Core\Exceptions\Forbidden;
use Espo\Core\Exceptions\BadRequest;
use Espo\Core\Controllers\Record;
use Espo\Core\Api\Request;

class Document extends Record
{
    public function postActionUpload(Request $request)
    {
        if (!$request->isPost()) {
            throw new BadRequest();
        }
        if (!$this->getAcl()->check('Document', 'create')) {
            throw new Forbidden();
        }

        $fileData = $request->getBodyContents();
        if (empty($fileData)) {
            throw new BadRequest("No file data");
        }

        $file = $this->getEntityManager()->createEntity('Attachment', [
            'name' => $request->getHeader('X-File-Name'),
            'type' => $request->getHeader('X-File-Type'),
            'size' => $request->getHeader('X-File-Size'),
            'contents' => $fileData
        ]);

        $document = $this->getEntityManager()->createEntity('Document', [
            'name' => $request->getHeader('X-File-Name'),
            'fileId' => $file->id,
            'assignedUserId' => $this->getUser()->id
        ]);

        return [
            'id' => $document->id,
            'name' => $document->get('name'),
            'fileId' => $document->get('fileId')
        ];
    }

    public function getActionDownload($params, $data, Request $request)
    {
        if (!$request->isGet()) {
            throw new BadRequest();
        }
        if (!$this->getAcl()->check('Document', 'read')) {
            throw new Forbidden();
        }

        $document = $this->getEntityManager()->getEntity('Document', $params['id']);
        if (!$document) {
            throw new NotFound();
        }

        $file = $this->getEntityManager()->getEntity('Attachment', $document->get('fileId'));
        if (!$file) {
            throw new NotFound("File not found");
        }

        return $this->getFileStorageManager()->getContents($file);
    }
}