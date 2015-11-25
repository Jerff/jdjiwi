<?php

class cApplication {

    // авторизация приложения
    static public function authorization() {
        if (cUser::authorization()) {
            $config = cUser::config();
            if (cAdmin::user()->debugError === 'yes')
                cDebug::setError();
            if (cAdmin::user()->debugSql === 'yes')
                cDebug::setSql();
            if (cAdmin::user()->debugExplain === 'yes')
                cDebug::setExplain();
            //if(cRegister::getAdmin()->debugCache==='yes')	cmfCache::setPages();
            //cmfCache::setData(cRegister::getAdmin()->debugCache==='yes');
        } else {
//            echo 'Для просмотра нужна авторизация';
//            exit;
        }
    }

}

