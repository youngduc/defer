<?php

if (! function_exists('defer')) {
    function defer(Closure $closure)
    {
        $a = new class {
            protected $closures = [];

            public function push(Closure $closure)
            {
                array_push($this->closures, $closure);
            }

            public function __destruct()
            {
                foreach (array_reverse($this->closures) as $closure) {
                    $closure();
                }
            }
        };

        $a->push($closure);

        return $a;
    }
}

if (!function_exists('exec_time')) {
    function exec_time() {
        $start = microtime(true);

        return defer(function ()  use ($start) {
            $t = microtime(true) - $start;
            echo "执行时间是：{$t}\n";
        });
    }
}
