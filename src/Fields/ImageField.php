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
namespace BlackfyreStudio\CRUD\Fields;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Exception\NotReadableException;
use InterventionImage;

/**
 * Class ImageField.
 */
class ImageField extends FileField
{
    /**
     * Holds the image sizes.
     *
     * @var array
     */
    protected $sizes = [];

    /**
     * Set the image sizes.
     *
     * @param array $sizes
     *
     * @return ImageField
     */
    public function sizes(array $sizes)
    {
        $this->sizes = $sizes;

        return $this;
    }

    /**
     * Get the image sizes.
     *
     * @return array
     */
    public function getSizes()
    {
        return $this->sizes;
    }

    /**
     * Render the field.
     *
     * @return mixed|string
     */
    public function render()
    {
        return view('crud::fields.image', [
            'field' => $this,
        ]);
    }

    /**
     * Upload the image.
     *
     * @param Model $model
     */
    public function postSubmitHook($model)
    {
        /* Get the Request object */
        $request = $this->getMasterInstance()->getFormBuilder()->getRequest();

        /* Check our image file */
        if ($request->hasFile($this->getName())) {


            /* Create our 'original image' entry */
            $images = [
                'original' => [
                    'src' => sprintf('%s/%s', $this->getLocation(), $this->getValue()),
                ],
            ];

            $originalSize = getimagesize(public_path($images['original']['src']));

            $images['original']['width'] = $originalSize[0];
            $images['original']['height'] = $originalSize[1];

            foreach ($this->getSizes() as $size) {
                try {
                    $image = InterventionImage::make(public_path($images['original']['src']));

                } catch (NotReadableException $e) {
                    continue;
                }

                switch ($size[2]) {
                    case 'resize':
                        $image->resize($size[0], $size[1], function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        break;
                    case 'resizeCanvas':
                        $image->resizeCanvas($size[0], $size[1], 'center');
                        break;
                    case 'fit':
                        $image->fit($size[0], $size[1]);
                        break;
                }

                if (array_key_exists(3, $size)) {
                    $saveLocation = sprintf('%s/%s-%s', $this->getLocation(), $size[3], $this->getValue());
                    $images[$size[3]]['src'] = $saveLocation;
                    $images[$size[3]]['width'] = $size[0];
                    $images[$size[3]]['height'] = $size[1];
                } else {
                    $saveLocation = sprintf('%s/%s-%s', $this->getLocation(), $size[0].'x'.$size[1], $this->getValue());
                    $images[$size[0].'x'.$size[1]]['src'] = $saveLocation;
                    $images[$size[0].'x'.$size[1]]['width'] = $size[0];
                    $images[$size[0].'x'.$size[1]]['height'] = $size[1];
                }

                $image->save(public_path($saveLocation));
            }

            $model->{$this->getName()} = $images;
            $model->save();
        }
    }
}
