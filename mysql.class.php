<?php
/**
 * Description of mysql
 *
 * @author matasov
 */
class mysqlConnector {
    var $conLink,$error,$log;

    function connect($server,$username,$password,$database) {
        session_start();
        $this->conLink = mysql_connect($server, $username, $password);
        If (!$this->conLink) {
            $this->error = 'Ошибка соединения с сервером MySQL!';
            return false;
        } else {
            If (mysql_select_db($database, $this->conLink)) {
                mysql_query('SET NAMES cp1251',$this->conLink);
                $this->log .= '<b>'.date('d.m.Y H:i:s').'</b> Успешное соединение с БД:'.$database.'<br/>';
                return true;
            } else {
                $this->error = 'База '.$database.' не найдена на сервере MySQL!';
                return false;
            }
        }
    }

    function query($query) {
        $result = mysql_query($query, $this->conLink);
        If (!$result) {
            $this->error = 'Ошибка запроса MYSQL:'.  mysql_error($this->conLink);
            $this->log .= '<b>'.date('d.m.Y H:i:s').'</b> Запрос не выполнен:'.$query.'<br/>'.'Ошибка запроса MYSQL:'.  mysql_error($this->conLink);
            return false;
        } else {
            $this->log .= '<b>'.date('d.m.Y H:i:s').'</b> Выполнен запрос:'.$query.'<br/>';
            return $result;
        }
    }
   
    function last_id() {
        $lastId = mysql_insert_id($this->conLink);
        return $lastId;
    }
   
    function select_db($database) {
       if (mysql_select_db($database, $this->conLink)) {
           $this->log .= '<b>'.date('d.m.Y H:i:s').'</b> Успешное соединение с БД:'.$database.'<br/>';
           return true;
       } else {
           $this->error = 'База '.$database.' не найдена на сервере MySQL!';
           return false;
       }
    }

    function close() {
        $this->log .= '<b>'.date('d.m.Y H:i:s').'</b> Закрыто подключение к MYSQL базе.<br/>';
        mysql_close($this->conLink);
    }
}
?>
