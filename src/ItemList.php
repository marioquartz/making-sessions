<?php


namespace Marioquartz\MakingSessions;

class ItemList implements \Countable, \Iterator
{
    protected array $list=array();
    private int $cursor=0;

    public function add(TimeBucket $item)
    {
        $this->list[]=$item;
        $this->cursor=($this->count()-1);
    }

    public function count():int
    {
        return count($this->list);
    }

    public function current():TimeBucket
    {
        return $this->list[$this->cursor];
    }

    public function next()
    {
        ++$this->cursor;
    }

    public function key()
    {
        return $this->cursor;
    }

    public function valid(): bool
    {
        return isset($this->list[$this->cursor]);
    }

    public function rewind()
    {
        $this->cursor=0;
    }

    public function last():TimeBucket
    {
        $n=$this->count();
        --$n;
        return $this->list[$n];
    }

    /**
     * @param ItemList $itemList
     * @param string $itemType
     * @param bool $inverse
     *
     * @return ItemList
     */
    public static function orderList(ItemList $itemList, string $itemType, bool $inverse = false): ItemList
    {
        $position = array();
        /** @var Event[] $newRow */
        $newRow = array();
        foreach (iterator_to_array($itemList) as $key => $item) {
            /** @var TimeBucket $item */
            $position[$key]  = $item->getStart();
            $newRow[$key] = $item;
        }
        if ($inverse) {
            arsort($position);
        } else {
            asort($position);
        }
        $nameList="\Marioquartz\MakingSessions\\".$itemType."List";
        /** @var ItemList $returnList */
        $returnList = new $nameList();
        foreach ($position as $key => $pos) {
            $returnList->add($newRow[$key]);
        }
        return $returnList;
    }
}
