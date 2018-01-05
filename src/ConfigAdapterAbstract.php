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
 * Class ConfigAdapterAbstract
 * @package Apatis\Config\Adapter
 */
abstract class ConfigAdapterAbstract extends Config implements ConfigAdapterInterface
{
    /**
     * {@inheritdoc}
     */
    public static function fromFile(string $file) : ConfigInterface
    {
        $object = new static();
        $object->replace($object->readFile($file));
        return $object;
    }

    /**
     * Read current file
     *
     * @param string $file
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    protected function readFile(string $file) : array
    {
        if (!file_exists($file)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Configuration %s is not exists',
                    $file
                ),
                E_WARNING
            );
        }

        if (!is_array(($configs = $this->parseFromFile($file)))) {
            throw new \RuntimeException(
                sprintf(
                    'Invalid %s configuration from file: %s',
                    ltrim(strrchr(get_class($this), '\\'), '\\'),
                    $file
                ),
                E_NOTICE
            );
        }

        return $configs;
    }

    /**
     * Parse From given file
     *
     * @param string $file
     *
     * @return mixed
     */
    abstract protected function parseFromFile(string $file);
}
