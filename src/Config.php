<?php

namespace Oktokod\Config;

class Config implements ConfigInterface
{
    protected array $config = [];

    public function get(string $key): mixed
    {
        $config = $this->config;

        foreach (explode('.', $key) as $k) {
            if (!array_key_exists($k, $config)) {
                return null;
            }

            $config = $config[$k];
        }

        return $config;
    }

    public function set(string $key, mixed $value): static
    {
        $this->config[$key] = $value;

        return $this;
    }

    public function load(): static
    {
        if (!defined('APP_ROOT')) {
            define('APP_ROOT', __DIR__);
        }

        $files = glob(APP_ROOT . '/config/*.yml');

        foreach ($files as $file) {
            $prefix = pathinfo($file, PATHINFO_FILENAME);

            if ($prefix === 'default') {
                $this->config = array_merge_recursive($this->config, yaml_parse_file($file));
            } else {
                $this->config = array_merge_recursive($this->config, [$prefix => yaml_parse_file($file)]);
            }
        }

        return $this;
    }
}