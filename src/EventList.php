<?php

declare(strict_types=1);

namespace Marioquartz\MakingSessions;

class EventList extends ItemList
{
    public function order(): ItemList
    {
        return self::orderList($this, 'Event');
    }
}
