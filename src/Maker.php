<?php

declare(strict_types=1);

namespace Marioquartz\MakingSessions;

class Maker
{
    private ItemList $input;
    private ItemList $ordered;
    private int $timeMerge = 300;

    public function __construct()
    {
        $this->input = new EventList();
        $this->ordered = new EventList();
    }

    public function add(Event $event): void
    {
        $this->input->add($event);
    }

    /**
     * Establish the maximum time for two events being in the same Session
     */
    public function setTimeMerge(int $timeMerge): void
    {
        $this->timeMerge = $timeMerge;
    }

    public function getSessions(): SessionList
    {
        $this->ordered = $this->input->order();
        $sessions = new SessionList();
        foreach ($this->ordered as $event) {
            if ($this->ordered->key() === 0) {
                $sessions = $this->addNewSession($sessions, $event);
                continue;
            }
            /** @var Session $session */
            $session = $sessions->current();

            $last = $session->getEvents()->last();
            if (($last->getType() !== $event->getType()) ||
                ($event->getStart() - $last->getEnd() > $this->timeMerge)) {
                $sessions = $this->addNewSession($sessions, $event);
                continue;
            }
            $session->getEvents()->add($event);
            $session->setEnd($event->getEnd());
        }
        return $sessions;
    }

    private function addNewSession(SessionList $sessions, Event $event): SessionList
    {
        $tmp = new Session();
        $tmp
            ->setStart($event->getStart())
            ->setEnd($event->getEnd())
            ->setType($event->getType());
        $tmp->getEvents()->add($event);
        $sessions->add($tmp);
        return $sessions;
    }
}
