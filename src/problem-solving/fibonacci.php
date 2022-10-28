<?php
    function fibonacci($n, $first = 0, $second = 1)
    {
        $fib = [$first, $second];

        for($i = 1; $i < $n - 1; $i++) {
            $fib[] = $fib[$i] + $fib[$i - 1];
        }

        return implode(', ', $fib);
    }

    var_dump(fibonacci(15));