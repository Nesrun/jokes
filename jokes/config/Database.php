<?php


class database
{
    private $host = "localhost";
    private $db_name = "chucknorris";
    private $username = "root";
    private $password = "";

    public $conn;
    public function getConnection()
    {
        $this->conn = null;
        try {
            $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db_name);
            $this->conn->set_charset("utf8");

        } catch (PDOException $e) {
            echo "Bağlantı hatası: " . $e->getMessage();
        }
        return $this->conn;
    }


	function createDataBase()
	{
		try {
			$sql = "CREATE TABLE `category` (
	`cat_id` INT(11) NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(200) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`cat_id`) USING BTREE
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;";
			$rs = mysqli_query($this->conn, $sql);
			if ($rs)
				return true;
			else
				return false;
		} catch (Exception $e) {
			die($e);
		}
	}
	function createDataBase2()
	{
		try {
			$sql = "CREATE TABLE `jokes` (
	`jokes_id` INT(11) NOT NULL AUTO_INCREMENT,
	`cat_id` INT(11) NULL DEFAULT NULL,
	`contents` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	PRIMARY KEY (`jokes_id`) USING BTREE,
	INDEX `category` (`cat_id`) USING BTREE,
	CONSTRAINT `category` FOREIGN KEY (`cat_id`) REFERENCES `category` (`cat_id`) ON UPDATE RESTRICT ON DELETE RESTRICT
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
;
";
			$rs = mysqli_query($this->conn, $sql);
			if ($rs)
				return true;
			else
				return false;
		} catch (Exception $e) {
			die($e);
		}
	}


}