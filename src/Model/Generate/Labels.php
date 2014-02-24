<?php

namespace Imhonet\CacheProf\Model\Generate;


class Labels implements \Iterator
{
    private $i = 0;
    private $prefix = CURRENT_DATE;

    const LABEL = '%s_test_label_%d';
    const TAG = '%s_test_tag_%d_%s';

    private function getTags()
    {
        $result = array();

        for ($i = $this->getTagsLimit(); $i > 0; $i--) {
            $result[] = $this->getTag($i);
        }

        return $result;
    }

    private function getLabel()
    {
        return sprintf(self::LABEL, $this->prefix, $this->i);
    }

    private function getTagsLimit()
    {
        return round(pow(2, ($this->i % 10 + 1) / 5));
    }

    private function getStale()
    {
        return 'stale_' . $this->getLabel();
    }

    private function getTag($postfix)
    {
        return sprintf(self::TAG, $this->prefix, $this->i, $postfix);
    }

    /**
     * @inheritdoc
     */
    public function current()
    {
        return array(
            'label' => $this->getLabel(),
            'stale' => $this->getStale(),
            'tags' => $this->getTags(),
        );
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        ++$this->i;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->i;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->i = 0;
    }

}
