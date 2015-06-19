<?php
/**
 * This file is part of the BlackfyreStudio CRUD package which is a recreation of the Krafthaus Bauhaus package.
 *
 * (c) Galicz Miklós <galicz.miklos@blackfyre.ninja>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlackfyreStudio\CRUD\Planner;

use BlackfyreStudio\CRUD\Scope\Scope;

class ScopePlanner extends BasePlanner
{
    /**
     * Hold all the scopes
     * @var array
     */
    protected $scopes = [];

    /**
     * @return array
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param array $scope
     */
    public function setScope($scope)
    {
        /** @noinspection CallableParameterUseCaseInTypeContextInspection */
        $scope = new Scope($scope);
        $this->scopes[] = $scope;
    }

    /**
     * @return bool
     */
    public function hasScopes()
    {
        return count($this->scopes) > 0;
    }
}
