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

 class XlsFormat extends BaseFormat {
     /**
      * Holds the content-type.
      * @var string
      */
     protected $contentType = 'application/xls';
     /**
      * Holds the filename.
      * @var string
      */
     protected $filename = 'export';
     /**
      * Create the json response.
      *
      * @access public
      * @return mixed
      */
     public function export()
     {
         $result = [];
         foreach ($this->getIndexBuilder()->getResult() as $item) {
             foreach ($item->getFields() as $field) {
                 $value = $field->getValue();
                 if (!is_string($value)) {
                     $value = $value->toArray();
                 }
                 $result[$item->getIdentifier()][$field->getName()] = $value;
             }
         }

         Excel::create($this->getFilename(), function($excel) use ($result) {
             $excel->setTitle('Export');
             $excel->setCreator('Bauhaus')
             ->setCompany('KraftHaus');
             $excel->sheet('Excel sheet', function($sheet) use ($result) {
                 $sheet->setOrientation('landscape');
                 $sheet->fromArray($result);
             });
         })->download('xls');
     }
 }