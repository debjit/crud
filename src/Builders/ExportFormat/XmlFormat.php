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
use SimpleXMLElement;

class XmlFormat extends BaseFormat
{
    /**
     * Holds the content type.
     * @var string
     */
    protected $contentType = 'text/xml';

    /**
     * Create the json response.
     *
     * @access public
     * @return mixed
     */
    public function export()
    {

        $this->filename = 'export-' . date('Y-m-d') . '.xml';

        $result = [];
        /** @var IndexResult $item */
        foreach ($this->getIndexBuilder()->getResult() as $item) {
            foreach ($item->getFields() as $field) {
                $value = $field->getValue();
                if (!is_string($value)) {
                    $value = $value->toArray();
                }
                $result[$item->getIdentifier()][$field->getName()] = $value;
            }
        }
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><response/>');
        $this->arrayToXml($result, $xml);
        return $this->createResponse($xml->asXML());
    }

    /**
     * Create an xml representatation from an array.
     *
     * @param  array $result
     * @param  SimpleXMLElement $xml
     *
     * @access public
     * @return void
     */
    protected function arrayToXml($result, &$xml)
    {
        foreach ($result as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild((string)$key);
                } else {
                    $subnode = $xml->addChild('item_' . $key);
                }
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, $value);
            }
        }
    }
}
