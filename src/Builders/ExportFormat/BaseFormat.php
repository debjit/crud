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
namespace BlackfyreStudio\CRUD\Builders\ExportFormat;

use BlackfyreStudio\CRUD\Builders\IndexBuilder;
use Response;

/**
 * Class BaseFormat.
 */
abstract class BaseFormat
{
    /**
     * Holds the content-type.
     *
     * @var null
     */
    protected $contentType;
    /**
     * Holds the filename.
     *
     * @var string
     */
    protected $filename;
    /**
     * Holds the ListBuilder object.
     *
     * @var IndexBuilder
     */
    protected $indexBuilder;

    /**
     * Create a new export based on the ListBuilder object.
     *
     * @return mixed
     * @abstract
     */
    abstract public function export();

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
     * Set the ListBuilder instance.
     *
     * @param IndexBuilder $indexBuilder
     *
     * @return $this
     */
    public function setIndexBuilder($indexBuilder)
    {
        $this->indexBuilder = $indexBuilder;

        return $this;
    }

    /**
     * Create the download response.
     *
     * @param string $result
     *
     * @return \Illuminate\Http\Response
     */
    public function createResponse($result)
    {
        return Response::make($result, 200, [
            'Content-Type'        => $this->getContentType(),
            'Content-Disposition' => sprintf('attachment; filename="%s"', $this->getFilename()),
        ]);
    }

    /**
     * Get the content-type.
     *
     * @return null
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set the content-type.
     *
     * @param string $contentType
     *
     * @return BaseFormat
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get the download filename.
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the download filename.
     *
     * @param string $filename
     *
     * @return BaseFormat
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }
}
