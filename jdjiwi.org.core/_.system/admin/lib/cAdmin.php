<?php

class cAdmin {

    // авторизация приложения
    static public function authorization() {
        if (cAdmin::user()->authorization()) {
            if (cAdmin::user()->debugError === 'yes')
                \Jdjiwi\Debug::setError();
            if (cAdmin::user()->debugSql === 'yes')
                \Jdjiwi\Debug::setSql();
            if (cAdmin::user()->debugExplain === 'yes')
                \Jdjiwi\Debug::setExplain();
            //if(cRegister::getAdmin()->debugCache==='yes')	\Jdjiwi\Cache\Control::setPages();
            //\Jdjiwi\Cache\Control::setData(cRegister::getAdmin()->debugCache==='yes');
        } else {
//            echo 'Для просмотра нужна авторизация';
//            exit;
        }
    }

    // инициализация админ панели
    static protected function initAdmin() {
        if (\Jdjiwi\Ajax::is()) {
            if (!cAdmin::user()->authorization()) {
                cPages::setMain('/admin/enter/');
            } else {
                if (cPages::isMain('/admin/index/') or cPages::isMain('/admin/enter/')) {
                    \Jdjiwi\Ajax::get()->redirect(cBaseAdminUrl);
                }
                if (\Jdjiwi\Ajax::isCommand('exit')) {
                    cAdmin::user()->logOut();
                    \Jdjiwi\Ajax::get()->alert('Выход из системы')
                            ->reload();
                }
                if (cAdmin::user()->debugError === 'yes')
                    \Jdjiwi\Debug::setError();
                if (cAdmin::user()->debugSql === 'yes')
                    \Jdjiwi\Debug::setSql();
//        if ($admin->debugExplain === 'yes')
//            \Jdjiwi\Debug::setExplain();
            }
        }
        \Jdjiwi\Init::timeLimit();
        \Jdjiwi\Init::ignoreUserAbort();

        \Jdjiwi\Log::memory();
        cAdmin::template()->start();
        \Jdjiwi\Log::memory();
    }

}

