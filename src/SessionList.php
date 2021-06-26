<?php

declare(strict_types=1);

namespace Marioquartz\MakingSessions;

class SessionList extends ItemList
{
    public function order(): ItemList
    {
        return self::orderList($this, 'Session');
    }
}
