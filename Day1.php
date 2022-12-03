<?php

class Day1
{
    public function day1_1(): int
    {
        $data = file_get_contents('data/input_1.txt');
        $char_use = count_chars($data, 1);

        return $char_use[40] - $char_use[41];
    }

    public function day1_2(): int|string
    {
        $data = file_get_contents('data/input_1.txt');
        $splitData = str_split($data);

        $floor = 0;
        foreach ($splitData as $key => $value) {
            if ($value == '(') {
                $floor++;
            } else {
                $floor--;
            }
            if ($floor == -1) {
                return $key + 1;
            }
        }

        return "No basement found";
    }
}

$object = new Day1();
echo "Floor : {$object->day1_1()}" . PHP_EOL;
echo "Position when entering basement : {$object->day1_2()}" . PHP_EOL;
