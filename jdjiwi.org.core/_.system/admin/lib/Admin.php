<?php

namespace Jdjiwi;

use Jdjiwi\Admin\User;

class Admin {

    // авторизация приложения
    static public function authorization() {
        if (User::authorization()) {
            if (User::debugError === 'yes') {
                Debug::setError();
            }
            if (User::debugSql === 'yes') {
                Debug::setSql();
            } if (User::debugExplain === 'yes') {
                Debug::setExplain();
            }
            //if(cRegister::getAdmin()->debugCache==='yes')	Cache\Control::setPages();
            //Cache\Control::setData(cRegister::getAdmin()->debugCache==='yes');
        } else {
//            echo 'Для просмотра нужна авторизация';
//            exit;
        }
    }

    // инициализация админ панели
    static protected function initAdmin() {
        if (Ajax::is()) {
            if (!User::authorization()) {
                cPages::setMain('/admin/enter/');
            } else {
                if (cPages::isMain('/admin/index/') or cPages::isMain('/admin/enter/')) {
                    Ajax::get()->redirect(cBaseAdminUrl);
                }
                if (Ajax::isCommand('exit')) {
                    User::logOut();
                    Ajax::get()->alert('Выход из системы')
                            ->reload();
                }
                if (User::debugError === 'yes') {
                    Debug::setError();
                }
                if (User::debugSql === 'yes') {
                    Debug::setSql();
                }
//        if ($admin->debugExplain === 'yes')
//            Debug::setExplain();
            }
        }
        Init::timeLimit();
        Init::ignoreUserAbort();

        Log::memory();
        self::template()->start();
        Log::memory();
    }

}
