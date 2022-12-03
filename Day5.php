<?php

class Day5
{
    public function day5_1(): int
    {
        $data = trim(file_get_contents('data/input_5.txt'));
        $strings = explode(PHP_EOL, $data);

        $niceStrings = [];
        foreach ($strings as $string) {
            if (preg_match('/([a-z])\1/m', $string) &&
                preg_match_all('/[aeiou]/m', $string) >= 3 &&
                !preg_match('/ab|cd|pq|xy/m', $string)
            ) {
                $niceStrings[] = $string;
            }
        }

        return count($niceStrings);
    }

    public function day5_2()
    {
        $data = trim(file_get_contents('data/input_5.txt'));
        $strings = explode(PHP_EOL, $data);

        $niceStrings = [];
        foreach ($strings as $string) {
            if (preg_match('/([a-z]{2})[a-z]*(\1)/m', $string) &&
                preg_match('/([a-z])[a-z](\1)/m', $string)
            ) {
                $niceStrings[] = $string;
            }
        }

        return count($niceStrings);
    }
}

$object = new Day5();
echo "Number of nice string : {$object->day5_1()}" . PHP_EOL;
echo "Number of better nice string  : {$object->day5_2()}" . PHP_EOL;
