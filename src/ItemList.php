<?php

declare(strict_types=1);

namespace Marioquartz\MakingSessions;

/**
 * @psalm-consistent-constructor
 */
class ItemList implements \Countable, \Iterator
{
    /**
     * @var array<TimeBucket> $list
     */
    protected array $list = [];
    private int $cursor = 0;

    public function add(TimeBucket $item): void
    {
        $this->list[] = $item;
        $this->cursor = $this->count() - 1;
    }

    public function count(): int
    {
        return count($this->list);
    }

    public function current(): TimeBucket
    {
        return $this->list[$this->cursor];
    }

    public function next(): void
    {
        ++$this->cursor;
    }

    public function key(): int
    {
        return $this->cursor;
    }

    public function valid(): bool
    {
        return isset($this->list[$this->cursor]);
    }

    public function rewind(): void
    {
        $this->cursor = 0;
    }

    public function last(): TimeBucket
    {
        $n = $this->count();
        --$n;
        return $this->list[$n];
    }

    public static function orderList(ItemList $list, string $type, bool $inverse = false): ItemList
    {
        $position = [];
        /** @var array<Event> $newRow */
        $newRow = [];
        foreach (iterator_to_array($list) as $key => $item) {
            /** @var TimeBucket $item */
            $position[$key] = $item->getStart();
            $newRow[$key] = $item;
        }
        if ($inverse) {
            arsort($position);
        } else {
            asort($position);
        }
        /**
         * @var class-string<static> $nameList
         */
        $nameList = "\Marioquartz\MakingSessions\\" . $type . 'List';
        /** @var ItemList $returnList */
        $returnList = new $nameList();
        foreach ($position as $key => $pos) {
            $returnList->add($newRow[$key]);
        }
        return $returnList;
    }
}
