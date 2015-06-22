<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

 namespace BlackfyreStudio\CRUD\Builders;

 use BlackfyreStudio\CRUD\Builders\ExportFormat\BaseFormat;

 class ExportBuilder {

     /**
      * Holds the ListBuilder object.
      * @var IndexBuilder
      */
     protected $indexBuilder;
     /**
      * Set the ListBuilder instance.
      *
      * @param  IndexBuilder $indexBuilder
      *
      * @access public
      * @return ExportBuilder
      */
     public function setIndexBuilder($indexBuilder)
     {
         $this->indexBuilder = $indexBuilder;
         return $this;
     }
     /**
      * Get the ListBuilder object.
      *
      * @access public
      * @return IndexBuilder
      */
     public function getIndexBuilder()
     {
         return $this->indexBuilder;
     }
     /**
      * Create a new export based on the ListBuilder output.
      *
      * @param  string $type
      *
      * @access public
      * @return mixed
      */
     public function export($type)
     {
         $format = sprintf('\\BlackfyreStudio\\CRUD\\Builders\\ExportFormat\\%sFormat', ucfirst($type));

         /** @var BaseFormat $format */
         return (new $format)
         ->setIndexBuilder($this->getIndexBuilder())
         ->export();
     }
 }
