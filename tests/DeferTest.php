<?php

namespace Youngduc\Defer\Tests;

use PHPUnit\Framework\TestCase;

class DeferTest extends TestCase {
    public function test1 () {
        $a = new A;
        $this->append($a);
        exec_time();
        $this->assertEquals(['c','b','a'], $a->get());
    }

    public function append (A $a) {
        $_ = defer(function () use ($a) {
            $a->push('a');
        });
        $_->push(function () use ($a){
            $a->push('b');
        });
        $a->push('c');
    }

    public function test2 () {
        $_ = exec_time();
        sleep(2);
    }

}

class A {
    protected $arr =[];
    public function push ($a) {
        array_push($this->arr,$a);
    }

    public function get () {
        return $this->arr;
    }
}