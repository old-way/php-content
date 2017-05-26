<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 11:25
 */
namespace Notadd\Content\Listeners;

use Notadd\Foundation\Permission\Abstracts\PermissionGroupRegister as AbstractPermissionGroupRegister;

/**
 * Class PermissionGroupRegister.
 */
class PermissionGroupRegister extends AbstractPermissionGroupRegister
{
    /**
     * Handle Permission Group Register.
     */
    public function handle()
    {
        $this->manager->group('content', [
            'description'    => '内容管理权限定义。',
            'identification' => 'global',
            'name'           => '内容管理权限',
        ]);
    }
}
