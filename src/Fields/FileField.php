<?php
/**
 * Copyright (c) 2016.
 *
 * Copyright (c) 2016. Galicz Miklós
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
namespace BlackfyreStudio\CRUD\Fields;

/**
 * Class FileField.
 */
class FileField extends BaseField
{
    protected $location = '';
    protected $naming;
    protected $originalName;

    /**
     * @param $location
     *
     * @return $this
     */
    public function location($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        if ($this->location == '') {
            $this->location = 'uploads';
        }

        return $this->location;
    }

    /**
     * @param $naming
     *
     * @return $this
     */
    public function naming($naming)
    {
        $this->naming = $naming;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNaming()
    {
        return $this->naming;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function setOriginalName($name)
    {
        $this->originalName = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOriginalName()
    {
        return $this->originalName;
    }


    public function preSubmitHook()
    {
        $formBuilder = $this->getMasterInstance()->getFormBuilder();

        $fieldName = $this->getName();


        if (\Input::hasFile($this->getName())) {
            $file = \Input::file($this->getName());

            $this->setOriginalName($file->getClientOriginalName());

            $fileName = $file->getClientOriginalName();

            $fileName = $this->handleNaming($fileName, $file->getClientOriginalExtension());

            $this->setValue($fileName);

            $file->move(public_path($this->getLocation()), $fileName);

            $value = sprintf('%s/%s', $this->getLocation(), $fileName);

            $formBuilder->setInputVariable($fieldName, $value);
        } else {
            $formBuilder->unsetInputVariable($this->getName());
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    public function render()
    {
        switch ($this->getContext()) {
            case BaseField::CONTEXT_FILTER:
            case BaseField::CONTEXT_FORM:
            return view('crud::fields.file', [
                'field' => $this,
            ]);
                break;
            case BaseField::CONTEXT_INDEX:
            default:
                return;
                break;
        }
    }

    /**
     * @param string      $name
     * @param string|null $extension
     *
     * @return string
     */
    protected function handleNaming($name, $extension = null)
    {
        switch ($this->getNaming()) {
            default:
            case 'original':
                break;
            case 'random':
                $name = str_random();

                if ($extension !== null) {
                    $name = sprintf('%s.%s', $name, $extension);
                }
                $name = strtolower($name);
        }

        return $name;
    }
}
