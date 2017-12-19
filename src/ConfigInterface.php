<?php
/**
 * MIT License
 *
 * Copyright (c) 2017 Pentagonal Development
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Apatis\Config;

/**
 * Class Config
 * @package Apatis\Config
 */
interface ConfigInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * ConfigInterface constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = []);

    /**
     * Set configuration
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function set($offset, $value);

    /**
     * Get value from configuration
     *
     * @param mixed $offset
     * @param mixed $default
     *
     * @return null
     */
    public function get($offset, $default = null);

    /**
     * @see offsetUnset
     *
     * @param mixed $offset
     */
    public function remove($offset);

    /**
     * Convert config into array
     *
     * @return array
     */
    public function toArray() : array;

    /**
     * Get config keys from key name array
     *
     * @return array|string[]|int[]
     */
    public function keys() : array;

    /**
     * Merge array replace config
     *
     * @param array $config
     *
     * @return static|ConfigInterface
     */
    public function replace(array $config) : ConfigInterface;

    /**
     * Merge config
     *
     * @param ConfigInterface $config
     *
     * @return static|ConfigInterface
     */
    public function merge(ConfigInterface $config) : ConfigInterface;

    /**
     * just make sure it was callable
     * and can be placed on container
     *
     * @return static|ConfigInterface
     */
    public function __invoke() : ConfigInterface;
}
