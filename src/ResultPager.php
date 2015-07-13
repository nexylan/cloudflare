<?php

/*
 * This file is part of the Nexylan CloudFlare package.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\CloudFlare;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class ResultPager implements \Countable, \Iterator, \ArrayAccess
{
    /**
     * @var array|\Traversable
     */
    private $items = [];

    /**
     * Pagination info from CloudFlare API.
     *
     * @see https://api.cloudflare.com/#responses
     *
     * @var array
     */
    private $pagination;

    /**
     * @param array $apiResult
     */
    public function __construct(array $apiResult)
    {
        $this->items = $apiResult['result'];
        $this->pagination = $apiResult['info'];
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->pagination['page'];
    }

    /**
     * @return int|null Return the next page number. Null if it's the last page.
     */
    public function getNextPage()
    {
        return $this->pagination['page'] < $this->pagination['total_pages'] ? $this->pagination['page'] + 1 : null;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->pagination['total_pages'];
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return current($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        next($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return key($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return null !== key($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        reset($this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->items);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        if (null === $offset) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * {@inheritdoc}
     */
    public function count()
    {
        return count($this->items);
    }
}
