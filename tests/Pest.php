<?php

use Illuminate\Support\Facades\Artisan;

// bootstrap your package’s service provider into a Test bench…
uses(\Orchestra\Testbench\TestCase::class)->in('Feature');
