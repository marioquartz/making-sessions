<?php


namespace Marioquartz\MakingSessions;

class Maker
{
    private ItemList $input;
    private ItemList $ordered;
    private int $timeMerge=300;

    public function __construct()
    {
        $this->input=new EventList();
        $this->ordered=new EventList();
    }

    public function add(Event $event)
    {
        $this->input->add($event);
    }

    /**
     * Establish the maximum time for two events being in the same Session
     * @param int $timeMerge
     */
    public function setTimeMerge(int $timeMerge)
    {
        $this->timeMerge=$timeMerge;
    }

    public function getSessions(): SessionList
    {
        $this->ordered=$this->input->order();
        $sessions=new SessionList();
        foreach ($this->ordered as $event) {
            if ($this->ordered->key()==0) {
                $sessions=$this->addNewSession($sessions, $event);
                continue;
            }
            /**
             * @var Session $sesion
             */
            $sesion=$sessions->current();

            $last=$sesion->getEvents()->last();
            $new=0;
            if ($last->getType()!=$event->getType()) {
                $new=1;
            }
            if (($event->getStart() - $last->getEnd())>$this->timeMerge) {
                $new=1;
            }
            if ($new==1) {
                $sessions=$this->addNewSession($sessions, $event);
                continue;
            }
            $sesion->getEvents()->add($event);
            $sesion->setEnd($event->getEnd());
        }
        return $sessions;
    }

    /**
     * @param SessionList $sessions
     * @param Event $event
     *
     * @return SessionList
     */
    public function addNewSession(SessionList $sessions, Event $event): SessionList
    {
        $tmp=new Session();
        $tmp
            ->setStart($event->getStart())
            ->setEnd($event->getEnd())
            ->setType($event->getType());
        $tmp->getEvents()->add($event);
        $sessions->add($tmp);
        return $sessions;
    }
}
