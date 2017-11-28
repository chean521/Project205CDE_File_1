<?php

/**
*	MySQL Runtime Engine, Universal Process Engine
*	Version: 1.0 beta
*	Created By: Oscar Loh, Date: 10 Oct 2017
 *      Main Engine System
 *      
 *      Use this must import this file. eg-> require('MySQL_Engine.php');
*/

define('MYSQL_ENG_VER','1.0beta');
require('MySQL_BaseObj.php');
require('Error_Handling.php');

class MySQL_Engine implements MYSQL_BaseObj
{
    /** @var string */
    protected $host;
    protected $id;
    protected $pw;
    protected $db;
    
    /** @var mysqli */
    private $Connection;
    
    private $isConnected = FALSE;
    private $isDataSet = FALSE;
    
    public function __construct()
    {
        $this->isDataSet = FALSE;
    }
    
    /** 
     *  To Set Connection Data 
     *  @param string $host Host Name for the Connection
     *  @param string $id User ID for Login In Database verification
     *  @param string $pwd Password for login database
     *  @param string $db Schema Name for Database
     */
    public function SetConnection($host,$id,$pwd,$db)
    {
        $this->host = $host;
        $this->id = $id;
        $this->pw = $pwd;
        $this->db = $db;
        $this->isDataSet = TRUE;
    }
    
    /**
     * A function to Connect Database
     * 
     * @throws DataException
     * @throws ConnectionException
     */
    public function Connect()
    {
        if($this->isDataSet == FALSE)
        {
            throw new DataException('Error: Data Error, Data Not Set.');
        }
        else
        {
            if($this->isConnected == FALSE)
            {
                $Conn = new mysqli($this->host, $this->id, $this->pw, $this->db);
                
                if($Conn->connect_error)
                {
                    throw new ConnectionException('Error: Unable to Connect, Connection Problem. Please check connection data.');
                }
                else
                {
                    $this->Connection = $Conn;
                    $this->isConnected = TRUE;
                }
            }
        }
    }
    
    /**
     * Disconnect Function
     */
    public function Disconnect()
    {
        if($this->isConnected == TRUE)
        {
            $this->Connection->close();
            $this->isConnected = FALSE;
        }
    }
    
    /**
     * Get MySQL Whole parmanent connection
     * 
     * @return mysqli Return MySql Connections
     * @throws ConnectionException Throws Connection Error if Problem exists.
     */
    public function GetConnection() {
        if($this->isConnected == TRUE)
        {
            return $this->Connection;
        }
        else
        {
            throw new ConnectionException('Error: Unable to Connect, Not Connected.');
        }
    }
    
    /**
     *   $query paramater. Must input as ËXAMPLE: SELECT col1, col2, col3 FROM tb_name WHERE col1=? (use ? as param input)
     *   $param. A parameter data type recognizer. (i for integer, s for string, d for decimals)
     *   $value parameter. Data in array stored into it for param.
     * 
	 *	 @param string $query Query String
	 *	 @param string $param Parameters
	 *	 @param array $value Values in Paramaters
     *   @return array Return Data in array format
     *   @throws QueryException
     *   @throws ResultException
    */
    public function Single_Line_Query($query,$param,$value)
    {  
        if($this->isConnected== TRUE)
        {   
            $arr_data = 0;
            
            if(!$param == NULL && strlen($param) > 0)
            {
                $str_query = str_replace(array('%','?'), array('%%','%s'), $query);
                $bind = vsprintf($str_query, $value);
                $result = $this->Connection->query($bind);
            }
            else
            {
                $result = $this->Connection->query($query);
            }
            
            if($result == FALSE)
            {
                throw new QueryException('Error: Query Error. Wrong Query.');
            }
            
            if($result->num_rows == 0)
            {
                throw new ResultException('Error: Result Error. No Data.');
            }
            else
            {
                $data = array();
            
                while($row = $result->fetch_assoc())
                {
                    $data[] = $row;
                }
            
                $result->close();
                return $data;
            }
        }
        else
        {
            throw new QueryException('Error: Query Error. Connection Not Establish.');
        }
    }
    
    /**
     * Stored Procedure Select Query function
     * 
     * @param string $method_name   Name of Stored Procedure
     * @param array $value         Value of parameter in array
     * @return array Return data in Array format
     * @throws QueryException
     * @throws ResultException
     */
    public function Stored_Proc_Query($method_name,$value)
    {
        if($this->isConnected== TRUE)
        {
            $arr_size = count($value);
            $connector = '';
            
            if(count($value) != 0)
            {
            	for($i=0; $i<$arr_size; $i++)
            	{
                    if($i == $arr_size - 1)
                    {
                        $connector = $connector  . "'" . $value[$i]  . "'" ;
                    }
                    else
                    {
                        $connector = $connector  . "'" . $value[$i]  . "'" . ',';
                    }
                }
            }
            
            $query = 'CALL '.$method_name. '('.$connector.');';
            $result = $this->Connection->query($query);
            
            if(!$result)
            {
                throw new QueryException('Error: Query Error. Wrong Query.');
            }
            
            if($result->num_rows == 0)
            {
                return 0;
            }
            else
            {
                $data = array();
            
                while($row = $result->fetch_assoc())
                {
                    $data[] = $row;
                }
            
                $result->close();
                       
                return $data;
            }
        }
        else
        {
            throw new QueryException('Error: Query Error. Connection Not Establish.');
        }
    }
    
    /**
     * Insert Data into database table
     * 
     * @param string $table_name    Name of Table
     * @param array $param_name     Name of Parameter in array
     * @param array $data           Data in array (Must be same array length as parameter.)
	 * @return bool Return true if success.
     * @throws QueryException
     */
    public function Write($table_name, $param_name, $data)
    {
        if($this->isConnected== TRUE)
        {
            $arr_size1 = count($param_name);
            $arr_size2 = count($data);
            $connector1 = '';
            $connector2 = '';
            
            for($i=0; $i<$arr_size1; $i++)
            {
                if($i == $arr_size1 - 1)
                {
                    $connector1 = $connector1  . $param_name[$i] ;
                }
                else
                {
                    $connector1 = $connector1  . $param_name[$i] . ',';
                }
            }
            
            for($i=0; $i<$arr_size2; $i++)
            {
                if($i == $arr_size2 - 1)
                {
                    $connector2 = $connector2 . "'" .$data[$i]  . "'" ;
                }
                else
                {
                    $connector2 = $connector2 . "'" .$data[$i] . "'" . ',';
                }
            }
            
            $query = "INSERT INTO " .$table_name. "(".$connector1.")VALUES(".$connector2.")";
            $result = $this->Connection->query($query);
            
            if(!$result)
            {
                throw new QueryException('Error: Query Error. Wrong Query.');
            }
            else
            {
                return true;
            }
        }
        else
        {
            throw new QueryException('Error: Query Error. Connection Not Establish.');
        }
    }
    
    /**
     * Convert Result array into data variable array
     * @param array $data Data in array from database
     * @return array Return array data.
     */
    public function Result_Convert($data)
    {
        if(is_array($data))
        {
            $arr = array();
            
            foreach($data as $row)
            {
                $arr[] = $row;
            }
            
            return $arr;
        }
    }
            
    /**
     * Destruct
     */
    public function __destruct() {
        exit();
    }
}
