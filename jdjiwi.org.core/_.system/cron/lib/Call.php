<?

namespace Jdjiwi\Cron;

use Jdjiwi\Init,
    Jdjiwi\Modul,
    Jdjiwi\Application;

class Call {

    static public function start() {
        Application::authorization();
        Init::sessionClose();
        Init::timeLimit();
        Init::ignoreUserAbort();

        ob_start();
        if (Cron::is()) {
            exit;
        }

        $res = cDb::placeholder("SELECT id, name FROM ?t WHERE status='start' AND visible='yes' LIMIT 0, 1", cDb::table('sys.cron'))
                ->fetchAssoc();
        if ($res) {
            self::run($res['name'], $res['id']);
        }
        $res = cDb::placeholder("SELECT id, name, changefreq, status, date FROM ?t WHERE visible='yes'", cDb::table('sys.cron'))
                ->fetchAssocAll('id');
        foreach ($res as $id => $row) {
            $modul = $row['name'];
            if ($row['status'] === 'none') {
                Cron::runModul($modul, $id);
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
                self::run($modul, $id);
            }
        }
        ob_end_clean();
    }

    static public function run($name, $id = 0) {
        if ($id) {
            cDb::update(cDb::table('sys.cron'), array('status' => 'start', 'date' => date('Y-m-d H:i:s')), $id);
        }
        Cron::start();
        $isOk = Modul::cron($name);
        Cron::stop();
        if ($id and $isOk) {
            cDb::update(cDb::table('sys.cron'), array('status' => 'end', 'date' => date('Y-m-d H:i:s')), $id);
        }
        exit;
    }

}
