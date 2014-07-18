<?php

include(__DIR__ . 'include.php');
cInit::sessionClose();
cInit::timeLimit();
cInit::ignoreUserAbort();

cCallCron::start();
?>