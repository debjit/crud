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
namespace BlackfyreStudio\CRUD\Builders;

/**
 * Class MenuBuilder.
 */
class MenuBuilder
{
    /**
     * Holds the menu items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * Public class constructor.
     */
    public function __construct()
    {
        $this->items = \Config::get('crud.menu');
    }

    /**
     * Get the menu items.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add new items to the menu array.
     *
     * @param array $menu
     *
     * @return MenuBuilder
     */
    public function addMenu(array $menu)
    {
        $this->items[] = $menu;

        return $this;
    }

    /**
     * Build the menu html.
     *
     * @return string
     */
    public static function build()
    {
        $menuBuilder = new self();

        $html = '';
        $html .= '<ul class="nav navbar-nav">';
        $html .= sprintf('<li><a href="%s"><i class="fa fa-dashboard"></i> <span>%s</span></a></li>', route('crud.home'), trans('crud::views.dashboard.title'));
        $html .= $menuBuilder->buildMenu($menuBuilder->items);
        $html .= '</ul>';

        return $html;
    }

    /**
     * Iterator method for the build() function.
     *
     * @param array $menu
     *
     * @return string
     */
    private function buildMenu($menu)
    {

        /* TODO: Find/Create suitable permission manager */

        /* TODO: Permission management, those classes that aren't readable to the user shouldn't even show up */

        $html = '';

        foreach ($menu as $key => $value) {
            if ($key === 'separator') {
                $html .= '<li class="header">'.$value.'</li>';
            } else {
                $icon = '';

                if (array_key_exists('icon', $value)) {
                    $icon = sprintf('<i class="fa fa-%s"></i>&nbsp;', $value['icon']);
                }

                if (array_key_exists('children', $value)) {
                    $willBeVisible = 0;

                    foreach ($value['children'] as $element) {
                        if (array_key_exists('class', $element)) {
                            if (\Auth::user()->hasPermission($element['class'].'.read')) {
                                $willBeVisible++;
                            }
                        } else {
                            $willBeVisible++;
                        }
                    }

                    if ($willBeVisible > 0) {
                        $html .= '<li class="dropdown">';
                        $html .= sprintf('<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">%s %s <span class="caret"></span></a>', $icon, $value['title']);
                        $html .= '<ul class="dropdown-menu" role="menu">';
                        $html .= $this->buildMenu($value['children']);
                        $html .= '</ul>';
                        $html .= '</li>';
                    }
                    continue;
                }


                $url = '';

                if (array_key_exists('class', $value)) {
                    $url = route('crud.index', urlencode($value['class']));
                } elseif (array_key_exists('url', $value)) {
                    $url = url($value['url']);
                } elseif (array_key_exists('route', $value)) {
                    if (is_array($value['route'])) {
                        $url = route(array_shift($value['route']), $value['route']);
                    } else {
                        $url = route($value['route']);
                    }

                    if (array_key_exists('custom', $value) && is_array($value['custom'])) {
                        if (! array_key_exists('target', $value['custom'])) {
                            $value['custom']['target'] = '_blank';
                        }
                    } else {
                        $value['custom']['target'] = '_blank';
                    }
                }

                $custom = '';

                if (array_key_exists('custom', $value) && is_array($value['custom'])) {
                    foreach ($value['custom'] as $k => $v) {
                        $custom[] = $k.'="'.$v.'"';
                    }
                    $custom = implode(' ', $custom);
                }

                if (array_key_exists('class', $value)) {
                    if (\Auth::user()->hasPermission($value['class'].'.read')) {
                        $html .= sprintf('<li><a href="%s" %s>%s <span>%s</span></a></li>', $url, $custom, $icon, $value['title']);
                    }
                } else {
                    $html .= sprintf('<li><a href="%s" %s>%s <span>%s</span></a></li>', $url, $custom, $icon, $value['title']);
                }
            }
        }

        return $html;
    }
}
