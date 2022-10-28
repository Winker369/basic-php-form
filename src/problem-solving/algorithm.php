<?php
    class Algorithm
    {
        public $numbers;

        function __construct($numbers)
        {
            $this->numbers = $numbers;
            $this->bubbleSort();
        }

        function bubbleSort()
        {
            $size = count($this->numbers) - 1;

            for ($i = 0; $i < $size; $i++) {
                for ($j = 0; $j < $size - $i; $j++) {
                    $k = $j + 1;

                    if ($this->numbers[$k] < $this->numbers[$j]) {
                        // Swap elements at indices: $j, $k
                        list($this->numbers[$j], $this->numbers[$k]) = array($this->numbers[$k], $this->numbers[$j]);
                    }
                }
            }
        }

        function getMedian()
        {
            // Get array length
            $length = count($this->numbers);

            // Divide length by 2
            $second_half_length = $length / 2;

            // Subtract 1 from $second_half_length
            $first_half_length = $second_half_length - 1;

            // Get index values
            $first_half = $this->numbers[$first_half_length];
            $second_half = $this->numbers[$second_half_length];

            // Get average of these values
            $median = ($first_half + $second_half) / 2;

            return $median;
        }

        function getHighest()
        {
            return $this->numbers[count($this->numbers) - 1];
        }
    }

    $algorithm = new Algorithm([6, 11, 4, 21, 12, 18]);
    // var_dump($algorithm->bubbleSort());
    echo 'Median: ';
    var_dump($algorithm->getMedian());
    echo 'Highest: ';
    var_dump($algorithm->getHighest());