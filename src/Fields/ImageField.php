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
        switch ($this->getContext()) {
            case BaseField::CONTEXT_INDEX:
                return '<img src="'.asset($this->getValue()).'" class="img-responsive">';
                break;
            case BaseField::CONTEXT_FILTER:
            case BaseField::CONTEXT_FORM:
                return view('crud::fields.image', [
                    'field' => $this,
                ]);
                break;
            default:
                return;
                break;
        }
    }

    /**
     * Upload the image.
     *
     * @param array $input
     * @param Model $model
     */
    public function postSubmitHook($input, $model)
    {
        if (array_key_exists($this->name, $input)) {
            $imageName = $this->getValue();

            $images = [
                'original' => sprintf('%s/%s', $this->getLocation(), $imageName),
            ];


            foreach ($this->getSizes() as $size) {
                try {
                    $image = InterventionImage::make(sprintf('%s/%s', $this->getLocation(), $imageName));
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
                    $saveLocation = sprintf('%s/%s', $this->getLocation(), $size[3].'-'.$imageName);
                    $images[$size[3]] = $saveLocation;
                } else {
                    $saveLocation = sprintf('%s/%s', $this->getLocation(), $size[0].'x'.$size[1].'-'.$imageName);
                    $images[$size[0].'x'.$size[1]] = $saveLocation;
                }

                $image->save(public_path($saveLocation));
            }

            $model->{$this->getName()} = $images;
            $model->save();
        }
    }
}
