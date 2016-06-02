<?php
/**
 *  This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *  Copyright (C) 2016. Galicz Miklós <galicz.miklos@blackfyre.ninja>.
 *
 *  This program is free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License along
 *  with this program; if not, write to the Free Software Foundation, Inc.,
 *  51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */
namespace BlackfyreStudio\CRUD\Builders;

use BlackfyreStudio\CRUD\Builders\ExportFormat\BaseFormat;

 /**
  * Class ExportBuilder.
  */
 class ExportBuilder
 {
     /**
      * Holds the ListBuilder object.
      *
      * @var IndexBuilder
      */
     protected $indexBuilder;

     /**
      * Set the ListBuilder instance.
      *
      * @param  IndexBuilder $indexBuilder
      *
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
      * @return mixed
      */
     public function export($type)
     {
         $format = sprintf('\\BlackfyreStudio\\CRUD\\Builders\\ExportFormat\\%sFormat', ucfirst($type));

         /* @var BaseFormat $format */
         return (new $format())
         ->setIndexBuilder($this->getIndexBuilder())
         ->export();
     }
 }
