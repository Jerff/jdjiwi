<?php

namespace Jdjiwi;

class Application {

    // авторизация приложения
    static public function authorization() {
        if (cUser::authorization()) {
            $config = cUser::config();
            if (cAdmin::user()->debugError === 'yes')
                GetDebug::setError();
            if (cAdmin::user()->debugSql === 'yes')
                GetDebug::setSql();
            if (cAdmin::user()->debugExplain === 'yes')
                GetDebug::setExplain();
            //if(cRegister::getAdmin()->debugCache==='yes')	GetCache\Control::setPages();
            //GetCache\Control::setData(cRegister::getAdmin()->debugCache==='yes');
        } else {
//            echo 'Для просмотра нужна авторизация';
//            exit;
        }
    }

}
