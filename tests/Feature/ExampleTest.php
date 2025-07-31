<?php

it('parses a trivial array', function () {
    $cmd = new \OznerOmali\LaravelToI18nextLangParser\Console\ParseLangToI18NextCommand;
    $this->assertIsObject($cmd);
});
