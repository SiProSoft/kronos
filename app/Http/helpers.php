<?php

function showAsTime($seconds)
{
    return sprintf('%02d:%02d:%02d', ($seconds/3600),($seconds/60%60), $seconds%60);
}

function getSumInSecondsFromTimeEntries($timeEntries) {
    
    $times = $timeEntries->map(function($t) {
        return $t->getTime();
    });
    
    $timeSum = array_sum($times->toArray());

    return $timeSum;
}