<?php


namespace Marioquartz\MakingSessions;

class Session extends TimeBucket
{
    private EventList $events;

    public function __construct()
    {
        $this->events=new EventList();
    }

    public function getEvents(): EventList
    {
        return $this->events;
    }
}
