<?php

namespace Atarek\Jwt\Core;

use Illuminate\Contracts\Pipeline\Pipeline;

class StreamPipeline implements Pipeline
{
    private $stream;

    private $stops;

    public function via($method)
    {
        return $this;
    }

    public function send($traveler)
    {
        $this->stream = $traveler;
        return $this;
    }

    public function through($stops)
    {
        $this->stops = $stops;
        return $this;
    }

    public function then(\Closure $destination)
    {
        foreach ($this->stops as $stop) {
            foreach ($stop as $identifier => $handle) {
                $resolved  = $this->resolve($identifier);

                $this->stream = (is_array($this->stream)) ?
                    $resolved->$handle(...$this->stream) : $resolved->$handle($this->stream);
            }
        }
        return $destination($this->stream);
    }

    private $instances = [];

    private function resolve(string $class)
    {
        if (array_key_exists($class, $this->instances) === false) {
            $this->instances[$class] = new $class;
        }
        return $this->instances[$class];
    }
}
