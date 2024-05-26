<?php

namespace App\Repositories\Event;

use App\Repositories\IBaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IEventRepository extends IBaseRepository
{
    /**
     * @return LengthAwarePaginator|null
     */
    public function allEvents(): ?LengthAwarePaginator;
}
