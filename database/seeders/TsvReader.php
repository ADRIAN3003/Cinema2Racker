<?php

namespace Database\Seeders;

class TsvReader
{
    public static function read(string $name): array
    {
        $lines = file(__DIR__.'/data/'.$name.'.tsv', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $header = explode("\t", array_shift($lines));

        $rows = [];
        foreach ($lines as $line) {
            $cells = array_map(fn ($c) => $c === '' ? null : $c, explode("\t", $line));
            $rows[] = array_combine($header, array_pad($cells, count($header), null));
        }

        return $rows;
    }
}
