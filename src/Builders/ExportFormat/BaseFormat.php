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
use BlackfyreStudio\CRUD\Builders\IndexBuilder;
use Response;

/**
 * Class BaseFormat
 * @package BlackfyreStudio\CRUD\Builders\ExportFormat
 */
abstract class BaseFormat
{
    /**
     * Holds the content-type.
     * @var null
     */
    protected $contentType;
    /**
     * Holds the filename.
     * @var string
     */
    protected $filename;
    /**
     * Holds the ListBuilder object.
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
     * @access public
     * @return IndexBuilder
     */
    public function getIndexBuilder()
    {
        return $this->indexBuilder;
    }

    /**
     * Set the ListBuilder instance.
     *
     * @param  IndexBuilder $indexBuilder
     *
     * @access public
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
     * @param  string $result
     *
     * @access public
     * @return \Illuminate\Http\Response
     */
    public function createResponse($result)
    {
        return Response::make($result, 200, [
            'Content-Type' => $this->getContentType(),
            'Content-Disposition' => sprintf('attachment; filename="%s"', $this->getFilename())
        ]);
    }

    /**
     * Get the content-type.
     *
     * @access public
     * @return null
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set the content-type.
     *
     * @param  string $contentType
     *
     * @access public
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
     * @access public
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Set the download filename.
     *
     * @param  string $filename
     *
     * @access public
     * @return BaseFormat
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
        return $this;
    }
}