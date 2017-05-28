<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-27 18:23
 */
namespace Notadd\Content\Listeners;

use Notadd\Foundation\Permission\Abstracts\PermissionModuleRegister as AbstractPermissionModuleRegister;

/**
 * Class PermissionModuleRegister.
 */
class PermissionModuleRegister extends AbstractPermissionModuleRegister
{
    /**
     * Handle Permission Register.
     */
    public function handle()
    {
        $this->manager->extend([
            'description'    => '内容管理权限。',
            'identification' => 'content',
            'name'           => '内容管理',
        ]);
    }
}