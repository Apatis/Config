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
use Symfony\Component\Yaml\Yaml as SymfonyYAML;

/**
 * Class Yaml
 * @package Apatis\Config\Adapter
 */
class Yaml extends ConfigAdapterAbstract
{
    /**
     * {@inheritdoc}
     * @throws \Throwable
     */
    protected function parseFromFile(string $file) : array
    {
        if (function_exists('yaml_parse_file')) {
            try {
                set_error_handler(function ($code, $message) {
                    throw new \RuntimeException(
                        $message,
                        $code
                    );
                });

                $array = yaml_parse_file($file);
                restore_error_handler();
                if (is_array($array)) {
                    throw new \RuntimeException(
                        sprintf(
                            'Configuration file in : %s does not return array',
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

        $array =  SymfonyYAML::parse(file_get_contents($file));
        if (is_array($array)) {
            throw new \RuntimeException(
                sprintf(
                    'Configuration file in : %s does not return array',
                    $file
                )
            );
        }

        return $array;
    }
}
