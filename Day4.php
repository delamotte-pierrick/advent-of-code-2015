<?php

class Day4
{
    private static string $secretKey = 'iwrupvqb';

    public function day4_1(): int
    {
        $answer = -1;
        do {
            $answer++;
            $hash = md5(self::$secretKey . $answer);
        } while (!str_starts_with($hash, '00000'));

        return $answer;
    }

    public function day4_2(): int
    {
        $answer = -1;
        do {
            $answer++;
            $hash = md5(self::$secretKey . $answer);
        } while (!str_starts_with($hash, '000000'));

        return $answer;
    }
}

$object = new Day4();
echo "Answer : {$object->day4_1()}" . PHP_EOL;
echo "Second Answer : {$object->day4_2()}" . PHP_EOL;
