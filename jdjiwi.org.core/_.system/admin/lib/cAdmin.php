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
            //if(cRegister::getAdmin()->debugCache==='yes')	cmfCache::setPages();
            //cmfCache::setData(cRegister::getAdmin()->debugCache==='yes');
        } else {
//            echo 'Для просмотра нужна авторизация';
//            exit;
        }
    }

    // инициализация админ панели
    static protected function initAdmin() {
        if (cAjax::is()) {
            if (!cAdmin::user()->authorization()) {
                cPages::setMain('/admin/enter/');
            } else {
                if (cPages::isMain('/admin/index/') or cPages::isMain('/admin/enter/')) {
                    cAjax::get()->redirect(cBaseAdminUrl);
                }
                if (cAjax::isCommand('exit')) {
                    cAdmin::user()->logOut();
                    cAjax::get()->alert('Выход из системы')
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
        cInit::timeLimit();
        cInit::ignoreUserAbort();

        \Jdjiwi\Log::memory();
        cAdmin::template()->start();
        \Jdjiwi\Log::memory();
    }

}

