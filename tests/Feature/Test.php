<?php

it('command is an object', function () {
    $cmd = new \OznerOmali\LaravelToI18nextLangParser\Console\ParseLangToI18NextCommand;
    $this->assertIsObject($cmd);
});
