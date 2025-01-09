<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Sandbox extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sandbox';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sandbox of code I want to test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        \Modules\Adam\Prompts\CreateNoobPortrait::prompt()
            ->noob(\Modules\Adam\Models\Noob::find(5))
            ->resolve();
    }

    public function noiseMap()
    {
        $seed = mt_rand(1,9);

        for ($x = 0; $x < 20; $x++) {
            $line = [];
            for ($y = 0; $y < 20; $y++) {
                $line[] = sin(($x + $seed) / 10) + sin(($y + $seed) / 10);
            }

            $normalized_line = array_map(function ($l) {
                return ($l + 1) / 2;
            }, $line);

            $formatted_line = array_map(function ($l) {
                return substr('' . $l, 0, 4);
            }, $normalized_line);
            $this->line(implode(' # ', $formatted_line));
            // $this->info('SD: ' . $this->getStandardDeviation($normalized_line));
        }
    }

    function getStandardDeviation(array $a, $sample = false) {
        $n = count($a);
        if ($n === 0) {
            trigger_error("The array has zero elements", E_USER_WARNING);
            return false;
        }
        if ($sample && $n === 1) {
            trigger_error("The array has only 1 element", E_USER_WARNING);
            return false;
        }
        $mean = array_sum($a) / $n;
        $carry = 0.0;
        foreach ($a as $val) {
            $d = ((double) $val) - $mean;
            $carry += $d * $d;
        };
        if ($sample) {
           --$n;
        }
        return sqrt($carry / $n);
    }
}
