<?php

cInit::sessionClose();
cInit::timeLimit();
cInit::ignoreUserAbort();

cLoader::library('cron:cCallCron');
cCallCron::start();
?>