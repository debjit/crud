<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.04.01.
 * Time: 7:20
 */

namespace BlackfyreStudio\CRUD\Builders;

    /**
     * This file was largely part of the KraftHaus Bauhaus package.
     *
     * (c) KraftHaus <hello@krafthaus.nl>
     *
     * For the full copyright and license information, please view the LICENSE
     * file that was distributed with this source code.
     */

/**
 * Class MenuBuilder
 * @package BlackfyreStudio\CRUD
 */
class MenuBuilder
{
    /**
     * Holds the menu items.
     * @var array
     */
    protected $items = [];

    /**
     * Public class constructor.
     *
     * @access public
     */
    public function __construct()
    {
        $this->items = \Config::get('crud.menu');
    }

    /**
     * Get the menu items.
     *
     * @access public
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add new items to the menu array.
     *
     * @param  array $menu
     * @return MenuBuilder
     * @access public
     */
    public function addMenu(array $menu)
    {
        $this->items[] = $menu;
        return $this;
    }

    /**
     * Build the menu html.
     *
     * @access public
     * @return string
     */
    public static function build()
    {

        $menuBuilder = new self;

        $html = '';
        $html .= '<ul class="nav" id="side-menu">';
        $html .= '
        <li class="sidebar-search">
            <div class="input-group custom-search-form">
                <input type="text" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">
                    <i class="fa fa-search"></i>
                </button>
            </span>
            </div>
            <!-- /input-group -->
        </li>
        ';
        $html .= sprintf('<li><a href="%s"><i class="fa fa-dashboard fa-fw"></i>  %s</a></li>', route('crud.home'), trans('crud::views.dashboard.title'));
        $html .= $menuBuilder->buildMenu($menuBuilder->items);
        $html .= '</ul>';
        return $html;
    }

    /**
     * Iterator method for the build() function.
     *
     * @param  array $menu
     *
     * @access public
     * @return string
     */
    private function buildMenu($menu)
    {

        /* TODO: Find/Create suitable permission manager */

        $html = '';
        /*
        $user = \Sentry::getUser();
        */
        foreach ($menu as $value) {

            /*
                Check if the current item should be filtered by permissions
                If there's a permission requirement we check it, if fails we skip this iteration
            */

            /*
            if (isset($value['permission'])) {
                if (is_array($value['permission'])) {
                    $permissions = [];
                    foreach ($value['permission'] as $p) {
                        $p = str_replace('.','-',$p);
                        $permissions[] = $p;
                        $permissions[] = $p . '.read';
                    }
                    if (!$user->hasAnyAccess($permissions)) {
                        continue;
                    }
                } else {
                    if (!$user->hasAnyAccess([$value['permission'],$value['permission'].'.view'])) {
                        continue;
                    }
                }
            }
            */

            /* TODO: modify html for the new template */

            $icon = '';
            if (isset($value['icon'])) {
                $icon = sprintf('<i class="fa fa-%s"></i>&nbsp;', $value['icon']);
            }

            if (isset($value['children'])) {
                $html .= '<li>';
                $html .= sprintf('<a href="#">%s%s<span class="fa arrow"></span></a>', $icon, $value['title']);
                $html .= '<ul class="nav">';
                $html .= $this->buildMenu($value['children']);
                $html .= '</ul>';
                $html .= '</li>';
                continue;
            }


            $url = '';

            if (isset($value['class'])) {
                $url = route('crud.index', urlencode($value['class']));
            } elseif (isset($value['url'])) {
                $url = url($value['url']);
            } elseif (isset($value['route'])) {
                $url = route($value['route']);
            }

            $custom = '';

            if (isset($value['custom']) && is_array($value['custom'])) {
                foreach ($value['custom'] AS $k=>$v) {
                    $custom[] = $k . '="' . $v . '"';
                }
                $custom = implode(' ', $custom);
            }

            $html .= sprintf('<li><a href="%s" %s>%s%s</a></li>', $url, $custom, $icon, $value['title']);
        }
        return $html;
    }
}