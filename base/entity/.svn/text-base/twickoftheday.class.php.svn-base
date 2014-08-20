<?php
require DOCUMENT_ROOT ."/entity/stubs/TwickOfTheDayStub.class.php";

class TwickOfTheDay extends TwickOfTheDayStub {
    
    public function getTodaysTwickOfTheDay() {
        $today = getCurrentShortDate();
        $twickOfTheDay = self::fetchTwickOfTheDay($today);
        if(!$twickOfTheDay) {
            $sql = "
                language='" . sec_mysql_input(getLanguage()) . "' AND rating_count >= 0 AND creation_date < '" . date("Y-m-d", time()-60*60*24*21) . "' AND id NOT IN (SELECT twick_id FROM tbl_twicks_of_the_day) ORDER BY rand() LIMIT 1
            ";
            $twick = array_pop(Twick::fetchBySQL($sql, true));

            $twickOfTheDay = new TwickOfTheDay();
            $twickOfTheDay->setLanguageCode(getLanguage());
            $twickOfTheDay->setDate($today);
            $twickOfTheDay->setTwickId($twick->getId());
            $twickOfTheDay->save();
        }
        return $twickOfTheDay;
    }


    public function findTwick() {
        return Twick::fetchById($this->getTwickId());
    }


    public static function fetchTwickOfTheDay($inDate) {
        return array_pop(self::fetch(array("date"=>$inDate)));
    }


    public static function fetchByTitle($inTitle) {
        $sql = "SELECT d.* FROM " . Twick::_getDatabaseName() . " t, " . TwickOfTheDay::_getDatabaseName() . " d WHERE t.id=d.twick_id AND t.title='" . sec_mysql_input($inTitle) . "'";
        return self::_fetch($sql, $inAllLanguages);
    }


    public static function fetchLatest($inCount) {
        return self::fetch(array(), false, array("ORDER BY"=>"date DESC", "LIMIT"=>$inCount));
    }
}
?>
