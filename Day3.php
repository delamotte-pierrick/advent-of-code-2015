<?php

class Day3
{
    /**
     * @throws Exception
     */
    public function day3_1(): int
    {
        $data = trim(file_get_contents('data/input_3.txt'));
        $directions = str_split($data);

        $visitedHouses = [];
        $lastHouse = [0, 0];

        foreach ($directions as $direction) {
            $visitedHouses[] = implode(',', $lastHouse);

            switch ($direction) {
                case '^':
                    $lastHouse[0] += 1;
                    break;
                case 'v':
                    $lastHouse[0] -= 1;
                    break;
                case '>':
                    $lastHouse[1] += 1;
                    break;
                case '<':
                    $lastHouse[1] -= 1;
                    break;
                default :
                    throw new Exception("Unknown direction '{$direction}'");
            }
        }

        return count(array_unique($visitedHouses));
    }

    /**
     * @throws Exception
     */
    public function day3_2()
    {
        $data = trim(file_get_contents('data/input_3.txt'));
        $grouped_directions = array_chunk(str_split($data), 2);

        $visitedHouses = [];
        $lastHouse = [
            [0, 0],
            [0, 0]
        ];
        foreach ($grouped_directions as $grouped_direction) {
            foreach ($grouped_direction as $user => $direction) {
                $visitedHouses[] = implode(',', $lastHouse[$user]);

                switch ($direction) {
                    case '^':
                        $lastHouse[$user][0] += 1;
                        break;
                    case 'v':
                        $lastHouse[$user][0] -= 1;
                        break;
                    case '>':
                        $lastHouse[$user][1] += 1;
                        break;
                    case '<':
                        $lastHouse[$user][1] -= 1;
                        break;
                    default :
                        throw new Exception("Unknown direction '{$direction}'");
                }
            }
        }

        return count(array_unique($visitedHouses));
    }
}

$object = new Day3();
try {
    echo "Number of house visited : {$object->day3_1()}" . PHP_EOL;
    echo "Number of house visited : {$object->day3_2()}" . PHP_EOL;
} catch (Exception $e) {
    echo 'Error found:';
    throw $e;
}
