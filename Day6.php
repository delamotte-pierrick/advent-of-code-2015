<?php

class Day6
{
    /**
     * @throws Exception
     */
    public function day6_1(): int
    {
        $callback = function ($instruction) {
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

            return $callback;
        };

        return $this->processingInstructions($callback);
    }

    /**
     * @throws Exception
     */
    public function day6_2(): int
    {
        $callback = function ($instruction) {
            return function ($impacted) use ($instruction) {
                return implode('', array_map(function ($char) use ($instruction) {
                    $increase = 0;
                    if ($instruction['action'] === 'toggle') {
                        $increase = 2;
                    } elseif ($instruction['action'] === 'turn off') {
                        $increase = -1;
                    } elseif ($instruction['action'] === 'turn on') {
                        $increase = 1;
                    }

                    // To overcome the bug when $value become superior to 10 (decimal alphabet) and making string 1001 characters,
                    // I transform the character in his ascii value to obtain more range on one character length
                    // This solution work only if $value is lower than 78 (78 + 48 = 126 = "~")
                    $value = ord($char) + $increase;
                    if ($value < 48) {
                        $value = 48;
                    }

                    if ($value > 126) {
                        throw new Exception("superior to ascii table");
                    }

                    return chr($value);
                }, str_split($impacted)));
            };
        };

        return $this->processingInstructions($callback);
    }

    /**
     * @throws Exception
     */
    private function executeInstruction($lights_y, $x_start, $x_end, $callback): string
    {
        $offset = $x_start > 0 ? $x_start : null; //Because this is an offset not the starting point
        $impacted = substr($lights_y, $offset, $x_end - $x_start + 1);

        return substr_replace($lights_y, $callback($impacted), $offset, strlen($impacted));
    }

    /**
     * @throws Exception
     */
    private function processingInstructions($callback): int
    {
        $gridSize = 1000;
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

        while ($iter < $gridSize) {
            $lights[] = str_repeat('0', $gridSize);
            $iter++;
        }

        echo "Processing ..." . PHP_EOL;
        //Start processing instructions
        foreach ($instructions as $instruction) {
            for ($y = $instruction['y_start']; $y <= $instruction['y_end']; $y++) {

                $line = $this->executeInstruction(
                    $lights[$y],
                    $instruction['x_start'],
                    $instruction['x_end'],
                    $callback($instruction)
                );

                if (strlen($line) < $gridSize) {
                    throw new Exception("Offset destroy line");
                }

                $lights[$y] = $line;
            }
        }

        echo "Calculating ..." . PHP_EOL;

        // transform the huge array in a string and count each type character and multiply it with his ascii decimal value to obtain the total brightness
        $result = count_chars(implode("", $lights), 1);

        return array_sum(
            array_map(function ($value, $key) {
            return $value * ($key - 48);
        }, $result, array_keys($result)));
    }
}

try {
    $object = new Day6();
    echo "Answer : {$object->day6_1()}" . PHP_EOL;
    echo "Second Answer : {$object->day6_2()}" . PHP_EOL;
} catch (Exception $e) {
    throw new RuntimeException($e);
}
