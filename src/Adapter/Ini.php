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


namespace Apatis\Config\Adapter;

use Apatis\Config\ConfigAdapterAbstract;

/**
 * Class Ini
 * @package Apatis\Config\Adapter
 */
class Ini extends ConfigAdapterAbstract
{
    /**
     * {@inheritdoc}
     *
     * use INI_SCANNER_TYPED as scanner mode
     * in this case :
     *  numeric will be convert to integer / double
     *  true, false, yes, no, off, on will be convert into boolean
     * and "true" or escaped string will be convert as string
     * @see parse_ini_file();
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function parseFromFile(string $file) : array
    {
        try {
            set_error_handler(function ($code, $message) {
                throw new \RuntimeException(
                    $message,
                    $code
                );
            });

            $array = parse_ini_file($file, true, INI_SCANNER_TYPED);
            restore_error_handler();
            if ($array === false) {
                throw new \RuntimeException(
                    sprintf(
                        'Can not parse ini file in : %s',
                        $file
                    )
                );
            }

            return $array;
        } catch (\Throwable $e) {
            restore_error_handler();
            throw  $e;
        }
    }
}
