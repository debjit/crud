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

use BlackfyreStudio\CRUD\Results\IndexResult;
use SimpleXMLElement;

/**
 * Class XmlFormat.
 */
class XmlFormat extends BaseFormat
{
    /**
     * Holds the content type.
     *
     * @var string
     */
    protected $contentType = 'text/xml';

    /**
     * Create the json response.
     *
     * @return mixed
     */
    public function export()
    {
        $this->filename = 'export-'.date('Y-m-d').'.xml';

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
     * @param array            $result
     * @param SimpleXMLElement $xml
     *
     * @return void
     */
    protected function arrayToXml($result, &$xml)
    {
        foreach ($result as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild((string) $key);
                } else {
                    $subnode = $xml->addChild('item_'.$key);
                }
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, $value);
            }
        }
    }
}
