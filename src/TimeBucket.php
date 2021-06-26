<?php


namespace Marioquartz\MakingSessions;

class TimeBucket
{
    private int $start;
    private int $end;
    private int $duration = 0;
    private string $type = "default";

    /**
     * @param int|\DateTimeImmutable $start
     *
     * @return TimeBucket
     */
    public function setStart($start): TimeBucket
    {
        if ($start instanceof \DateTimeImmutable) {
            $this->start=$start->format("U");
        }
        $this->start=$start;
        return $this;
    }

    /**
     * @param int|\DateTimeImmutable $end
     *
     * @return TimeBucket
     */
    public function setEnd($end): TimeBucket
    {
        if ($end instanceof \DateTimeImmutable) {
            $this->end=$end->format("U");
        }
        if ($end<$this->start) {
            $end=$this->start;
        }
        $this->end=$end;
        $this->duration=$this->end-$this->start;
        return $this;
    }

    /**
     * @param int $duration
     *
     * @return TimeBucket
     */
    public function setDuration(int $duration): TimeBucket
    {
        $this->duration = $duration;
        $this->setEnd($this->start + $duration);
        return $this;
    }

    /**
     * @param string $type
     *
     * @return TimeBucket
     */
    public function setType(string $type): TimeBucket
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return int
     */
    public function getStart(): int
    {
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEnd(): int
    {
        return $this->end;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}
