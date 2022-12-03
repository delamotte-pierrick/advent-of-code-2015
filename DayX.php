<?php

class DayX
{
    public function dayX_1(): int
    {
        $data = trim(file_get_contents('data/input_X.txt'));
    }

    public function dayX_2(): int
    {
        $data = trim(file_get_contents('data/input_X.txt'));
    }
}

$object = new DayX();
echo "Answer : {$object->dayX_1()}" . PHP_EOL;
echo "Second Answer : {$object->dayX_2()}" . PHP_EOL;
