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
use Maatwebsite\Excel\Excel;

/**
 * Class XlsFormat.
 */
class XlsFormat extends BaseFormat
{
    /**
     * Holds the content-type.
     *
     * @var string
     */
    protected $contentType = 'application/xls';

    /**
     * Create the json response.
     *
     * @return mixed
     */
    public function export()
    {
        $this->filename = 'export-'.date('Y-m-d');
        $result = [];
        /** @var IndexResult $item */
        foreach ($this->getIndexBuilder()->getResult() as $item) {
            foreach ($item->getFields() as $field) {
                $value = $field->getValue();
                if (! is_string($value)) {
                    $value = $value->toArray();
                }
                $result[$item->getIdentifier()][$field->getName()] = $value;
            }
        }

        Excel::create($this->getFilename(), function ($excel) use ($result) {
            $excel->setTitle('Export');
            $excel->setCreator('Bauhaus')
            ->setCompany('KraftHaus');
            $excel->sheet('Excel sheet', function ($sheet) use ($result) {
                $sheet->setOrientation('landscape');
                $sheet->fromArray($result);
            });
        })->download('xls');
    }
}
