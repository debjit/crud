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

class CSVFormat extends BaseFormat
{

    /**
     * Holds the content-type.
     * @var string
     */
    protected $contentType = 'text/csv';

    /**
     * Create the json response.
     *
     * @access public
     * @return mixed
     */
    public function export()
    {
        $this->filename = 'export-' . date('Y-m-d') . '.csv';

        $result = '';
        $fields = [];


        foreach ($this->getIndexBuilder()->getPlanner()->getFields() as $field) {

            $fields[] = $field->getLabel();
        }
        $result .= implode(',', $fields) . PHP_EOL;
        /** @var IndexResult $item */
        foreach ($this->getIndexBuilder()->getResult() as $item) {
            $row = [];
            foreach ($item->getFields() as $field) {
                $row[] = $field->getValue();
            }
            $result .= implode(',', $row) . PHP_EOL;
        }
        return $this->createResponse($result);
    }
}
