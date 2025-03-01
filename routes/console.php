<?php

Schedule::command(\App\Console\Commands\FetchNewsFromDataSources::class)
    ->everySixHours()
    ->withoutOverlapping()
    ->onOneServer()
    ->runInBackground();
