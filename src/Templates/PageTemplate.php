<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2016, notadd.com
 * @datetime 2016-10-09 15:37
 */
namespace Notadd\Content\Templates;

use Illuminate\Support\Str;

/**
 * Class PageTemplate.
 */
class PageTemplate
{
    /**
     * @var string
     */
    protected $hit;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $relation;

    /**
     * ArticleTemplate constructor.
     *
     * @param string $key
     * @param string $hit
     * @param string $path
     */
    public function __construct($key, $hit, $path)
    {
        $this->hit = $hit;
        $this->key = $key;
        $this->path = $path;
    }

    /**
     * Create a instance.
     *
     * @param $key
     * @param $location
     *
     * @return static
     */
    public static function create($key, $location)
    {
        if (Str::contains($location, ':')) {
            list($hit, $path) = explode(':', $location);
        } else {
            $hit = 'default';
            $path = $location;
        }

        return new static($key, $hit, $path);
    }

    /**
     * Return a instance with relation.
     *
     * @param $relation
     *
     * @return \Notadd\Content\Templates\PageTemplate
     */
    public function withRelation($relation)
    {
        $instance = clone $this;
        $instance->relation = $relation;

        return $instance;
    }
}
