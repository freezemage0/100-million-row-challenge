<?php

namespace App;

final class Parser
{
    public function parse(string $inputPath, string $outputPath): void
    {
        $result = [];

        $file = \fopen($inputPath, 'r');
        while ($line = \fgets($file)) {
            // Practically unsafe, but \fgetcsv is slow
            $line = \explode(',', $line);

            $result[\substr($line[0], 19)][] = \substr($line[1], 0, 10);
        }

        foreach ($result as &$visits) {
            $visits = \array_count_values($visits);
            \ksort($visits);
        }

        \file_put_contents($outputPath, \json_encode($result, \JSON_PRETTY_PRINT));
    }
}
