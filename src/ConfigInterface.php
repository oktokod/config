<?php

namespace Oktokod\Config;

interface ConfigInterface
{
    public function get(string $key): mixed;

    public function set(string $key, mixed $value): static;

    public function load(): static;
}