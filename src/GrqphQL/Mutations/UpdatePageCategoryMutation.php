<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime      2017-11-08 11:57
 */
namespace Notadd\Content\GrqphQL\Mutations;

use Notadd\Foundation\GraphQL\Abstracts\Mutation;

/**
 * Class UpdatePageCategoryMutation.
 */
class UpdatePageCategoryMutation extends Mutation
{
    /**
     * @return array
     */
    public function args(): array
    {
        return [];
    }

    /**
     * @param $root
     * @param $args
     *
     * @return mixed
     */
    public function resolve($root, $args)
    {
        // TODO: Implement resolve() method.
    }
}
