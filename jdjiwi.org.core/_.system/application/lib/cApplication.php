<?php

class cApplication {

    // авторизация приложения
    static public function authorization() {
        if (cUser::authorization()) {
            $config = cUser::config();
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

}

