<?

class cCallCron {

    static public function start() {
        ob_start();
        if (cCronRun::isRun()) {
            exit;
        }

        $res = cBase::placeholder("SELECT id, name FROM ?t WHERE status='start' AND visible='yes' LIMIT 0, 1", cDb::table('sys.cron'))
                ->fetchAssoc();
        if ($res) {
            cCronRun::runModul($res['name'], $res['id']);
        }
        $res = cBase::placeholder("SELECT id, name, changefreq, status, date FROM ?t WHERE visible='yes'", cDb::table('sys.cron'))
                ->fetchAssocAll('id');
        foreach ($res as $id => $row) {
            $modul = $row['name'];
            if ($row['status'] === 'none') {
                cCronRun::runModul($modul, $id);
            }
            $time = strtotime($row['date']);
            $changefreq = explode(' ', $row['changefreq']);
            $isRun = false;
            switch ($changefreq[0]) {
                case 'minutes':
                    $isRun = (time() > ($time + 60 * 30));
                    break;

                case 'hourly':
                    if (date('Y-m-d', $time) !== date('Y-m-d')) {
                        $isRun = true;
                    } else {
                        $hour = (int) get($changefreq, 1, 1);
                        $isRun = (time() > ($time + 60 * 60 * $hour));
                    }
                    break;

                case 'daily':
                    $hour = (int) get($changefreq, 1);
                    if ((time() - $time) > 24 * 60 * 60) {
                        $isRun = true;
                    } elseif ($hour) {
                        if (date('H') >= $hour) {
                            if (date('Y-m-d', $time) !== date('Y-m-d')) {
                                $isRun = true;
                            } else {
                                $isRun = date('H', $time) <= $hour;
                            }
                        }
                    } else {
                        $isRun = date('Y-m-d', $time) !== date('Y-m-d');
                    }
                    break;

                case 'weekly':
                    $isRun = date('Y-W', $time) !== date('Y-W');
                    break;
            }
            if ($isRun) {
                cCronRun::runModul($modul, $id);
            }
        }
        ob_end_clean();
    }

}

?>