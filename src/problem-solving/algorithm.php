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
                        list($this->numbers[$j], $this->numbers[$k]) = array($this->numbers[$k], $this->numbers[$j]);
                    }
                }
            }
        }

        function getMedian()
        {
            $secondHalfLength = count($this->numbers) / 2;
            $firstHalfLength = $secondHalfLength - 1;
            $firstHalf = $this->numbers[$firstHalfLength];
            $secondHalf = $this->numbers[$secondHalfLength];
            $median = ($firstHalf + $secondHalf) / 2;

            return $median;
        }

        function getHighest()
        {
            return $this->numbers[count($this->numbers) - 1];
        }
    }

    // Take input
    $numbers = explode(' ', readline('Enter multiple space separated values: '));
    $algorithm = new Algorithm($numbers);
    echo 'Median: ';
    var_dump($algorithm->getMedian());
    echo 'Highest: ';
    var_dump($algorithm->getHighest());