<?php
include($_SERVER['DOCUMENT_ROOT'] . "/includes/error.inc.php");
include $_SERVER['DOCUMENT_ROOT'] . '/classes/Url.class.php';



class Database{
    private function ConnectDatabase(){

        $servername = "servername";
        $dbName = "Database name";
        $username = "Username";
        $password = "Password";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
        return $conn;
    }


    function Get($formName, $param, $multiRow, $whereKey, $whereValue, $orderBy, $isASC){

            $prepare = false;
            $sort = $isASC ? "ASC" : "DESC";
            if($whereKey != null && $whereValue != null){
                if ($param == null){
                    $prepare = true;
                    $stmt = $this->ConnectDatabase()->prepare("SELECT * FROM $formName WHERE $whereKey=:$whereKey");
                }
                else $stmt = $this->ConnectDatabase()->query("SELECT $param FROM $formName");
            }else{
                if ($param == null) $stmt = $this->ConnectDatabase()->query("SELECT * FROM $formName");
                else $stmt = $this->ConnectDatabase()->query("SELECT $param FROM $formName");
            }

            if ($orderBy != null && $orderBy != "" && !$prepare) $stmt = $this->ConnectDatabase()->query($stmt->queryString . " ORDER BY " . $orderBy . " " . $sort);
            elseif ($orderBy != null && $orderBy != "" && $prepare) $stmt = $this->ConnectDatabase()->prepare($stmt->queryString . " ORDER BY " . $orderBy . " " . $sort);

            //echo $stmt->queryString;

            if($multiRow){
                if($whereValue != null) $stmt->execute([$whereKey => $whereValue]);
                if ($orderBy != null) $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
                else $output = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                if($whereKey != null) $stmt->execute([$whereKey => $whereValue]);
                if ($orderBy != null) $output = $stmt->fetch(PDO::FETCH_ASSOC);
                else $output = $stmt->fetch(PDO::FETCH_ASSOC);
            }

        return $output;
    }

    function Save($formName, $data){
        try{
            $key = "";
            $keyHolder = "";

            foreach($data as $x => $value) {
                if(floatval(phpversion()) <= 7.2){
                    end($array);
                    if ($key === key($array)) {
                        $key .= $x;
                        $keyHolder .= ":" . $x;
                    }else{
                        $key .= $x . ", ";
                        $keyHolder .= ":" . $x . ", ";
                    }
                }else{
                    if ($x === array_key_last($data)) {
                        $key .= $x;
                        $keyHolder .= ":" . $x;
                    }else{
                        $key .= $x . ", ";
                        $keyHolder .= ":" . $x . ", ";
                    }
                }

            }
            $sql = "INSERT INTO $formName ($key) VALUES ($keyHolder)";
            $stmt = $this->ConnectDatabase()->prepare($sql);
            $stmt->execute($data);

            //Check if it is inserted
            if($stmt){
                return true;
            }else{
                echo "Save error";
                return;
            }
        }catch(PDOException $e){
            throw new PDOException($e->getMessage());
            return;
        }
        return true;
    }

    function Update($formName, $data, $where){
        $key = "";
        foreach($data as $x => $value) {

            if(floatval(phpversion()) <= 7.2){
                end($array);
                if ($x === key($data)) {
                    $key .= $x . "=:" . $x;
                }else{
                    $key .= $x . "=:" . $x. ",";
                }
            }else{
                if ($x === array_key_last($data)) {
                    $key .= $x . "=:" . $x;
                }else{
                    $key .= $x . "=:" . $x. ",";
                }
            }
        }

        if($where != null){
            $whereKey = "";
            foreach($where as $x => $value) {

                if(floatval(phpversion()) <= 7.2){
                    end($array);
                    if ($x === key($where)) {
                        $whereKey .= $x . "=:" . $x;
                    }else{
                        $whereKey .= $x . "=:" . $x. ",";
                    }
                }else{
                    if ($x === array_key_last($where)) {
                        $whereKey .= $x . "=:" . $x;
                    }else{
                        $whereKey .= $x . "=:" . $x. ",";
                    }
                }
            }
            $sql = "UPDATE $formName SET $key WHERE $whereKey";
            $data += $where;
        }else{
            $sql = "UPDATE $formName SET $key";
        }

        $stmt= $this->ConnectDatabase()->prepare($sql);
        $stmt->execute($data);
        if($stmt){
            //echo "successfull update";
        }else{
            echo "Update error";
        }
    }

    function Delete($formName,$whereKey, $whereID){
        if($whereID == null){

        }else{
           $delete =  $this->ConnectDatabase()->prepare("DELETE FROM $formName WHERE $whereKey=?")->execute([$whereID]);
        }
        return $delete;
    }

    function SearchDatabase($isCart, $formName, $data, $where){
        $stmt = $this->ConnectDatabase()->query("SELECT * FROM $formName WHERE $where LIKE '{$data}%'");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>
