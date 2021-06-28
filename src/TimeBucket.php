<?php

declare(strict_types=1);

namespace Marioquartz\MakingSessions;

class TimeBucket
{
    private int $start;
    private int $end;
    private int $duration;
    private string $type;

    /**
     * @param int|\DateTimeImmutable $start
     */
    public function setStart($start): TimeBucket
    {
        if (($start instanceof \DateTimeImmutable) === true) {
            $this->start = (int) $start->format('U');
            return $this;
        }
        $this->start = $start;
        return $this;
    }

    /**
     * @param int|\DateTimeImmutable $end
     */
    public function setEnd($end): TimeBucket
    {
        if ($end instanceof \DateTimeImmutable) {
            $end = (int) $end->format('U');
        }
        if ($end < $this->start) {
            $end = $this->start;
        }
        $this->end = $end;
        $this->duration = $this->end - $this->start;
        return $this;
    }

    public function setDuration(int $duration): TimeBucket
    {
        $this->duration = $duration;
        $this->setEnd($this->start + $duration);
        return $this;
    }

    public function setType(string $type): TimeBucket
    {
        $this->type = $type;
        return $this;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getEnd(): int
    {
        return $this->end;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getType(): string
    {
        return $this->type;
    }
}