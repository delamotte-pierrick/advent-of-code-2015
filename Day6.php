<?php

class Day6
{
    /**
     * @throws Exception
     */
    public function day6_1(): int
    {
        $data = trim(file_get_contents('data/input_6.txt'));
        $instructions = array_map(function ($instruction_str) {
            preg_match('/(toggle|turn off|turn on) (\d+),(\d+) through (\d+),(\d+)/m', $instruction_str, $instruction);

            return [
                'action' => $instruction[1],
                'x_start' => intval($instruction[2]),
                'y_start' => intval($instruction[3]),
                'x_end' => intval($instruction[4]),
                'y_end' => intval($instruction[5]),
            ];
        }, explode(PHP_EOL, $data));

        echo "Generating Light ..." . PHP_EOL;
        $iter = 0;
        $lights = [];
        while ($iter < 1000) {
            $lights[] = str_repeat('0', 1000);
            $iter++;
        }

        echo "Processing ..." . PHP_EOL;
        //Start processing instructions
        foreach ($instructions as $instruction) {
            for ($y = $instruction['y_start']; $y <= $instruction['y_end']; $y++) {
                $callback = function () {
                    throw new Exception("Unknown action");
                };

                if ($instruction['action'] === 'toggle') {
                    $callback = function ($impacted) use ($instruction) {
                        return str_replace(['0', '1', 'X'], ['X', '0', '1'], $impacted);
                    };
                } elseif ($instruction['action'] === 'turn off') {
                    $callback = function () use ($instruction) {
                        return str_repeat('0', $instruction['x_end'] - $instruction['x_start'] + 1);
                    };
                } elseif ($instruction['action'] === 'turn on') {
                    $callback = function () use ($instruction) {
                        return str_repeat('1', $instruction['x_end'] - $instruction['x_start'] + 1);
                    };
                }

                $line = $this->executeInstruction(
                    $lights[$y],
                    $instruction['x_start'],
                    $instruction['x_end'],
                    $callback
                );

                if (strlen($line) < 1000) {
                    var_dump($instruction, $line);
                    throw new Exception("Offset destroy line");
                }

                $lights[$y] = $line;
            }
        }

        echo "Calculating ..." . PHP_EOL;

        $result = implode("", $lights);
        return substr_count($result, "1");
    }

    public function day6_2()
    {
        $data = trim(file_get_contents('data/input_6.txt'));
    }

    /**
     * @throws Exception
     */
    private function executeInstruction($lights_y, $x_start, $x_end, $callback): string
    {
        $x_start -= 1; //Because this is an offset not the starting point

        $impacted = substr($lights_y, $x_start, $x_end - $x_start);
        return substr_replace($lights_y, $callback($impacted), $x_start, strlen($impacted));
    }
}

try {
    $object = new Day6();
    echo "Answer : {$object->day6_1()}" . PHP_EOL;
//echo "Second Answer : {$object->day6_2()}" . PHP_EOL;
} catch (Exception $e) {
    throw new RuntimeException($e);
}
