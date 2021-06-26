<?php


namespace Marioquartz\MakingSessions;

class SessionList extends ItemList
{
    public function order(): ItemList
    {
        return self::orderList($this, "Session");
    }
}
