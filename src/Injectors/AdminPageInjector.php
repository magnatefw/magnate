<?php
/**
 * @package Magnate
 * @author Dmitry Shumilin (chirontex@yandex.ru)
 */
namespace Magnate\Injectors;

use Magnate\Interfaces\AdminPageInjectorInterface;
use Magnate\Exceptions\AdminPageInjectorException;

/**
 * AdminPage injector class.
 * @since 0.4.0
 */
class AdminPageInjector implements AdminPageInjectorInterface
{

    /**
     * @var string $slug
     * Page slug.
     * @since 0.4.0
     */
    protected $slug = '';

    /**
     * @var string $view
     * Path to the page view.
     * @since 0.4.0
     */
    protected $view = '';

    /**
     * @var string $page_title
     * Page title.
     * @since 0.4.0
     */
    protected $page_title = '';

    /**
     * @var string $menu_title
     * Menu title.
     * @since 0.4.0
     */
    protected $menu_title = '';

    /**
     * @var int|string $capability
     * Capability to access.
     * @since 0.4.0
     */
    protected $capability = '';

    /**
     * @var string $parent_slug
     * Parent slug.
     * @since 0.4.0
     */
    protected $parent_slug = '';

    /**
     * @var string $icon
     * Path to icon.
     * @since 0.4.0
     */
    protected $icon = '';

    /**
     * @var int|float|string $position
     * Menu item position.
     * @since 0.5.0
     */
    protected $position = '';

    /**
     * @var array $scripts
     * Additional JS scripts.
     * @since 0.6.5
     */
    protected $scripts = [];

    /**
     * @var array $styles
     * Additional CSS styles.
     * @since 0.6.5
     */
    protected $styles = [];

    /**
     * @since 0.4.0
     */
    public function __construct(
        string $slug,
        string $view,
        string $page_title,
        string $menu_title,
        $capability,
        string $parent_slug = '',
        string $icon = '',
        $position = '')
    {
        
        $empty = '';

        if (empty($slug)) $empty = 'Slug';
        elseif (empty($page_title)) $empty = 'Page title';
        elseif (empty($menu_title)) $empty = 'Menu title';
        elseif (is_string($capability) &&
            empty($capability)) $empty = 'Capability';

        if (!empty($empty)) throw new AdminPageInjectorException(
            sprintf(AdminPageInjectorException::pickMessage(
                AdminPageInjectorException::EMPTY
            ), $empty),
            AdminPageInjectorException::pickCode(
                AdminPageInjectorException::EMPTY
            )
        );

        if (!empty($view)) {

            if (substr($view, -4) !== '.php') throw new AdminPageInjectorException(
                sprintf(AdminPageInjectorException::pickMessage(
                    AdminPageInjectorException::NOT_TYPE
                ), 'View', 'PHP file')
            );

        }

        if (!is_int($position) &&
            !is_float($position)) $position = (string)$position;

        if (empty($position)) $position = NULL;

        $this->slug = $slug;
        $this->view = $view;
        $this->page_title = $page_title;
        $this->menu_title = $menu_title;
        $this->capability = $capability;
        $this->parent_slug = $parent_slug;
        $this->icon = $icon;
        $this->position = $position;

    }

    /**
     * @since 0.6.5
     */
    public function addScript(
        string $name,
        string $src,
        array $dependecies = [],
        string $version = '',
        bool $in_footer = false) : self
    {

        $empty = '';

        if (empty($name)) $empty = 'Name';
        elseif (empty($src)) $empty = 'Source';

        if (!empty($empty)) throw new AdminPageInjectorException(
            sprintf(AdminPageInjectorException::pickMessage(
                AdminPageInjectorException::EMPTY
            ), $empty),
            AdminPageInjectorException::pickCode(
                AdminPageInjectorException::EMPTY
            )
        );

        $version = empty($version) ? false : $version;

        $this->scripts[$name] = [
            'src' => $src,
            'deps' => $dependecies,
            'ver' => $version,
            'footer' => $in_footer
        ];

        return $this;

    }

    /**
     * @since 0.6.5
     */
    public function addStyle(
        string $name,
        string $src,
        array $dependecies = [],
        string $version = '',
        string $media = 'all') : self
    {

        $empty = '';

        if (empty($name)) $empty = 'Name';
        elseif (empty($src)) $empty = 'Source';

        if (!empty($empty)) throw new AdminPageInjectorException(
            sprintf(AdminPageInjectorException::pickMessage(
                AdminPageInjectorException::EMPTY
            ), $empty),
            AdminPageInjectorException::pickCode(
                AdminPageInjectorException::EMPTY
            )
        );

        $version = empty($version) ? false : $version;

        $this->styles[$name] = [
            'src' => $src,
            'deps' => $dependecies,
            'ver' => $version,
            'media' => $media
        ];

        return $this;

    }

    /**
     * @since 0.6.5
     */
    public function getScripts() : array
    {

        return $this->scripts;

    }

    /**
     * @since 0.6.5
     */
    public function getStyles() : array
    {

        return $this->styles;

    }

    /**
     * @since 0.4.0
     */
    public function getSlug() : string
    {

        return $this->slug;

    }

    /**
     * @since 0.4.0
     */
    public function getView() : string
    {

        return $this->view;

    }

    /**
     * @since 0.4.0
     */
    public function getPageTitle() : string
    {

        return $this->page_title;

    }

    /**
     * @since 0.4.0
     */
    public function getMenuTitle() : string
    {

        return $this->menu_title;

    }

    /**
     * @since 0.4.0
     */
    public function getCapability()
    {

        return $this->capability;

    }

    /**
     * @since 0.4.0
     */
    public function getParentSlug() : string
    {

        return $this->parent_slug;

    }

    /**
     * @since 0.4.0
     */
    public function getIcon() : string
    {

        return $this->icon;

    }

    /**
     * @since 0.5.0
     */
    public function getPosition()
    {

        return $this->position;

    }

}
