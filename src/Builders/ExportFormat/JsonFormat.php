<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace BlackfyreStudio\CRUD\Builders\ExportFormat;

 use BlackfyreStudio\CRUD\Results\IndexResult;
 use Response;

 class JsonFormat extends BaseFormat {
     /**
      * Holds the content type.
      * @var string
      */
     protected $contentType = 'text/plain';

     /**
      * Create a response
      * @return mixed
      */
     public function export()
     {
         $this->filename = 'export-' . date('Y-m-d') . '.json';

         $result = [];
         /** @var IndexResult $item */
         foreach ($this->getIndexBuilder()->getResult() as $item) {
             foreach ($item->getFields() as $field) {
                 $result[$item->getIdentifier()][$field->getName()] = $field->getValue();
             }
         }
         return $this->createResponse(Response::json($result)->getContent());
     }
 }
