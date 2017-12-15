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

use Apatis\Config\Adapter\Env;
use Apatis\Config\Adapter\Ini;
use Apatis\Config\Adapter\Php;
use Apatis\Config\Adapter\Yaml;

/**
 * Class Factory
 * @package Apatis\Config
 */
class Factory
{
    /**
     * Available adapter
     *
     * @var string[]
     */
    protected static $availableAdapter = [
        ConfigAdapterInterface::ADAPTER_YAML => Yaml::class,
        ConfigAdapterInterface::ADAPTER_PHP  => Php::class,
        ConfigAdapterInterface::ADAPTER_INI  => Ini::class, # default
        ConfigAdapterInterface::ADAPTER_ENV  => Env::class,
    ];

    const DEFAULT_ADAPTER = ConfigAdapterInterface::ADAPTER_INI;

    /**
     * @param array $array
     *
     * @return ConfigInterface
     */
    public static function fromArray(array $array = []) : ConfigInterface
    {
        /**
         * Use array Default
         */
        $driver = new Config($array);
        return $driver;
    }

    /**
     * Get from file
     *
     * @param string $file
     * @param string|null $driver
     *
     * @return ConfigInterface
     */
    public static function fromFile(string $file, string $driver = null) : ConfigInterface
    {
        if (!$driver) {
            $ext = strtolower((string) pathinfo($file, PATHINFO_EXTENSION));
            /**
             * extension yml is also known as .yaml also
             * @link https://en.wikipedia.org/wiki/YAML
             */
            if ($ext === 'yml') {
                $ext = ConfigAdapterInterface::ADAPTER_YAML;
            }

            $driver = isset(static::$availableAdapter[$ext])
                ? static::$availableAdapter[$ext]
                : static::$availableAdapter[static::DEFAULT_ADAPTER];
        }

        if (! is_subclass_of($driver, ConfigAdapterInterface::class)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Config Driver invalid. Driver %s must be implement interface %s',
                    $driver,
                    ConfigAdapterInterface::class
                ),
                E_WARNING
            );
        }

        /**
         * @var ConfigAdapterInterface $driver
         */
        return $driver::fromFile($file);
    }
}
