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
 * Interface ConfigAdapterInterface
 * @package Apatis\Config
 */
interface ConfigAdapterInterface extends ConfigInterface
{
    /**
     * Adapter List
     * @type string
     */
    const ADAPTER_INI   = 'ini';
    const ADAPTER_PHP   = 'php';
    const ADAPTER_ARRAY = self::ADAPTER_PHP;
    const ADAPTER_YAML  = 'yaml';
    // alias
    const ADAPTER_YML   = self::ADAPTER_YAML;
    const ADAPTER_ENV   = 'env';

    /**
     * Create config instance from file
     *
     * @param string $file
     *
     * @return ConfigInterface
     */
    public static function fromFile(string $file) : ConfigInterface;
}
