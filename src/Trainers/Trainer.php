<?php

namespace KeltyNN\Trainers;

interface Trainer
{
    function run($ontick);
    function bestNetwork();
}
