<?php
class Product{
    private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "India_voyage";
    private $productTable = 'Indianplaces';    
    private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
    private function getData($sqlQuery) {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if(!$result){
            die('Error in query: '. mysqli_error());
        }
        $data= array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[]=$row;            
        }
        return $data;
    }
    private function getNumRows($sqlQuery) {
        $result = mysqli_query($this->dbConnect, $sqlQuery);
        if(!$result){
            die('Error in query: '. mysqli_error());
        }
        $numRows = mysqli_num_rows($result);
        return $numRows;
    }  
    public function cleanString($str){
        return str_replace(' ','_',$str);
    }
    public function getstate() {      
        $sqlQuery = "
            SELECT DISTINCT state
            FROM ".$this->productTable."
            WHERE zone = 'Eastern'";
        return  $this->getData($sqlQuery);
    }
    public function getcity() {
        $sql = '';
        if(isset($_POST['state']) && $_POST['state']!="") {
            $state = $_POST['state'];
            $sql.=" WHERE category_id IN ('".implode("','",$state)."')";
        }
        $sqlQuery = "
            SELECT distinct state
            FROM ".$this->productTable."
            $sql GROUP BY state";
        return  $this->getData($sqlQuery);
    }
    public function getsignificance () {
        $sql = '';
        if(isset($_POST['Significance']) && $_POST['Significance']!="") {
            $brand = $_POST['type'];
            $sql.=" WHERE Significance IN ('".implode("','",$type)."')";
        }
        $sqlQuery = "
            SELECT distinct Significance
            FROM ".$this->productTable."
            $sql GROUP BY Significance";
        return  $this->getData($sqlQuery);
    }
    
}
?>