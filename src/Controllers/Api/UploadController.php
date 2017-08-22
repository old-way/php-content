<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-08-08 17:45
 */

namespace Notadd\Content\Controllers\Api;

use Notadd\Content\Handlers\UploadHandler;
use Notadd\Foundation\Routing\Abstracts\Controller;

/**
 * Class UploadController.
 */
class UploadController extends Controller
{
    /**
     * @param \Notadd\Content\Handlers\UploadHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function handle(UploadHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
