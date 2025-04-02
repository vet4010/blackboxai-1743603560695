<?php
namespace Espo\Custom\Controllers;

use Espo\Core\Exceptions\Forbidden;
use Espo\Core\Exceptions\BadRequest;
use Espo\Core\Controllers\Record;
use Dompdf\Dompdf;

class PdfExport extends Record
{
    public function actionGeneratePdf($params, $data, $request)
    {
        if (!$request->isGet()) {
            throw new BadRequest();
        }
        if (!$this->getAcl()->check($this->name, 'read')) {
            throw new Forbidden();
        }

        $entityType = $params['entityType'];
        $id = $params['id'];
        
        $entity = $this->getEntityManager()->getEntity($entityType, $id);
        if (!$entity) {
            throw new NotFound();
        }

        $html = $this->getTemplateRenderer()->render($entity, 'pdf-template');
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }
}