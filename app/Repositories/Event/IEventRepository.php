<?php

namespace App\Repositories\Event;

use App\Repositories\IBaseRepository;

interface IEventRepository extends IBaseRepository
{
    /**
     * @return array|null
     */
    public function allEvents(): ?array;
}
