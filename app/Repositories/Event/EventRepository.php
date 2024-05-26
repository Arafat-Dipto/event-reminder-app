<?php

namespace App\Repositories\Event;

use App\Models\Event;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventRepository extends BaseRepository implements IEventRepository
{

    /**
     * BaseRepository constructor
     *
     * @param Model $model
     */

    public function __construct(Event $model)
    {
        $this->model = $model;
    }

    * all the events
     *
     * @return null|LengthAwarePaginator
     */
    public function allEvents(): ?LengthAwarePaginator
    {
        return $this->model::latest()->paginate(10);
    }
}
