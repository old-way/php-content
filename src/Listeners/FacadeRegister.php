<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-22 12:20
 */
namespace Notadd\Content\Listeners;

use Notadd\Foundation\Event\Abstracts\EventSubscriber;
use Notadd\Foundation\Facades\FacadeRegister as FacadeRegisterEvent;

/**
 * Class FacadeRegister.
 */
class FacadeRegister extends EventSubscriber
{
    /**
     * Name of event.
     *
     * @throws \Exception
     * @return string|object
     */
    protected function getEvent()
    {
        return FacadeRegisterEvent::class;
    }

    /**
     * Event handler.
     *
     * @param $event
     */
    public function handle(FacadeRegisterEvent $event)
    {
        $event->register('djfksjdfk', 'sdfjskdfjslkdfjlkjl');
    }
}
