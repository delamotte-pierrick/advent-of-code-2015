<?php

class Day2
{
    public function day2_1()
    {
        $data = trim(file_get_contents('data/input_2.txt'));
        $splitData = explode(PHP_EOL, $data);

        $total = 0;
        foreach ($splitData as $value) {
            $dimensions = array_map(function ($dimension) {
                return intval($dimension);
            }, explode('x', $value));

            $sides = [
                $dimensions[0] * $dimensions[1],
                $dimensions[1] * $dimensions[2],
                $dimensions[0] * $dimensions[2],
            ];

            $total += min($sides) + array_sum(array_map(function ($side) {
                    return $side * 2;
                }, $sides));
        }

        return $total;
    }

    public function day2_2()
    {
        $data = trim(file_get_contents('data/input_2.txt'));
        $splitData = explode(PHP_EOL, $data);

        $total = 0;
        foreach ($splitData as $value) {
            $dimensions = array_map(function ($dimension) {
                return intval($dimension);
            }, explode('x', $value));
            sort($dimensions);
            $ribbon = $dimensions[0] * 2 + $dimensions[1] * 2;
            $total += array_product($dimensions) + $ribbon;
        }

        return $total;
    }
}

$object = new Day2();
echo "Square feet of paper needed : {$object->day2_1()}" . PHP_EOL;
echo "Square feet of ribbon needed : {$object->day2_2()}" . PHP_EOL;
