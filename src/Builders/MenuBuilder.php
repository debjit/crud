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
        $html .= '<ul class="sidebar-menu" id="side-menu">';
        $html .= sprintf('<li><a href="%s"><i class="fa fa-dashboard fa-fw"></i>  <span>%s</span></a></li>', route('crud.home'), trans('crud::views.dashboard.title'));
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

        /* TODO: Permission management */

        /* TODO: modify html for the new template */

        $html = '';

        foreach ($menu as $key=>$value) {

            if ($key === 'separator') {

                $html .= '<li class="header">' . $value . '</li>';

            } else {


                $icon = '';

                if (array_key_exists('icon',$value)) {
                    $icon = sprintf('<i class="fa fa-%s"></i>&nbsp;', $value['icon']);
                }

                if (array_key_exists('children',$value)) {
                    $html .= '<li>';
                    $html .= sprintf('<a href="#">%s%s<i class="fa fa-angle-left pull-right"></i></a>', $icon, $value['title']);
                    $html .= '<ul class="treeview-menu">';
                    $html .= $this->buildMenu($value['children']);
                    $html .= '</ul>';
                    $html .= '</li>';
                    continue;
                }


                $url = '';

                if (array_key_exists('class',$value)) {
                    $url = route('crud.index', urlencode($value['class']));
                } elseif (array_key_exists('url',$value)) {
                    $url = url($value['url']);
                } elseif (array_key_exists('route',$value)) {
                    $url = route($value['route']);
                }

                $custom = '';

                if (array_key_exists('custom',$value) && is_array($value['custom'])) {
                    foreach ($value['custom'] AS $k=>$v) {
                        $custom[] = $k . '="' . $v . '"';
                    }
                    $custom = implode(' ', $custom);
                }

                $html .= sprintf('<li><a href="%s" %s>%s<span>%s</span></a></li>', $url, $custom, $icon, $value['title']);
            }


        }
        return $html;
    }
}