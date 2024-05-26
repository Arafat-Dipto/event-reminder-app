<?php

namespace App\Repositories\Event;

use App\Models\Event;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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

    /**
     * all the privileges
     *
     * @return null|array
     */
    public function allEvents(): ?array
    {
        return $this->model::orderBy('id', 'desc')->paginate(10)->toArray();
    }
}
