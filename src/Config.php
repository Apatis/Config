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
class Config implements ConfigInterface
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $config = [])
    {
        $this->replace($config);
    }

    /**
     * {@inheritdoc}
     */
    public function set($offset, $value)
    {
        $this->offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function get($offset, $default = null)
    {
        return isset($this->{$offset}) ? $this->{$offset} : $default;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($offset)
    {
        $this->offsetUnset($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        $returnValue = [];
        foreach (get_object_vars($this) as $key => $value) {
            $returnValue[$key] = $value instanceof Config ? $value->toArray() : $value;
        }

        return $returnValue;
    }

    /**
     * {@inheritdoc}
     */
    public function keys() : array
    {
        return array_keys(get_object_vars($this));
    }

    /**
     * Merge array replace config
     *
     * @param array $config
     *
     * @return Config
     */
    public function replace(array $config) : ConfigInterface
    {
        foreach ($config as $key => $configuration) {
            $this->set($key, $configuration);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function merge(ConfigInterface $config) : ConfigInterface
    {
        return $this->mergeConfigInstance($config);
    }

    /**
     * Method to handle merge config
     *
     * @param ConfigInterface $config
     * @param ConfigInterface|null $instance
     *
     * @return Config
     */
    final protected function mergeConfigInstance(
        ConfigInterface $config,
        ConfigInterface $instance = null
    ) : ConfigInterface {
        $instance  = $instance?: $this;

        // if offset detect as an increment array
        $arrayInstance  =  get_object_vars($instance);
        $arrayInstance[] = true;
        end($arrayInstance);

        $increment = key($arrayInstance);
        unset($arrayInstance);
        foreach (get_object_vars($config) as $key => $value) {
            if (isset($instance->{$key}) && $value instanceof Config) {
                $instance->mergeConfigInstance($value, $instance);
                continue;
            }

            if (isset($instance->{$key}) && is_numeric($key) && is_int(abs($key))) {
                $key = $increment;
                $increment++;
            }

            $instance->{$key} = $value;
        }

        return $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function clear() : ConfigInterface
    {
        foreach (get_object_vars($this) as $key => $value) {
            $this->remove($key);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset) : bool
    {
        return isset($this->{$offset});
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        if (isset($this->{$offset})) {
            return $this->{$offset};
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        // if offset detect as an increment array
        if ($offset === null) {
            $array  =  get_object_vars($this);
            $array[] = true;
            end($array);
            $offset = key($array);
        } elseif (is_string($offset) && substr($offset, 0, 1) === "\0") {
            // prevent to invalid offset
            return;
        }

        $this->{$offset} = is_array($value) ? new static($value) : $value;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }

    /**
     * {@inheritdoc}
     */
    public function count() : int
    {
        return count(get_object_vars($this));
    }

    /**
     * {@inheritdoc}
     */
    public function getIterator() : \Traversable
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke() : ConfigInterface
    {
        return $this;
    }
}
