<?php

declare(strict_types=1);

namespace Marioquartz\MakingSessions;

/**
 * Class EventList
 * @package Marioquartz\MakingSessions
 * @method EventList orderList($list, $type, $inverse = false)
 */
class EventList extends ItemList
{
    public function order(): EventList
    {
        return self::orderList($this, 'Event');
    }
}
