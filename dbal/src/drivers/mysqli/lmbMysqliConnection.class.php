<?php
/*
 * Limb PHP Framework
 *
 * @link http://limb-project.com
 * @copyright  Copyright &copy; 2004-2009 BIT(http://bit-creative.com)
 * @license    LGPL http://www.gnu.org/copyleft/lesser.html
 */
namespace limb\dbal\src\drivers\mysqli;

use limb\dbal\src\drivers\lmbDbBaseConnection;
use limb\dbal\src\exception\lmbDbException;
use limb\dbal\src\drivers\mysqli\lmbMysqliDbInfo;
use limb\dbal\src\drivers\mysqli\lmbMysqliQueryStatement;
use limb\dbal\src\drivers\mysqli\lmbMysqliInsertStatement;
use limb\dbal\src\drivers\mysqli\lmbMysqliManipulationStatement;
use limb\dbal\src\drivers\mysqli\lmbMysqliStatement;
use limb\dbal\src\drivers\mysqli\lmbMysqliTypeInfo;
use limb\dbal\src\drivers\mysqli\lmbMysqliTableInfo;
use limb\dbal\src\drivers\mysqli\lmbMysqliRecord;
use limb\dbal\src\drivers\mysqli\lmbMysqliRecordSet;

/**
 * class lmbMysqlConnection.
 *
 * @package dbal
 * @version $Id: lmbMysqlConnection.class.php 6848 2008-03-21 13:44:08Z svk $
 */
class lmbMysqliConnection extends lmbDbBaseConnection
{
  protected $connectionId;

  function getType()
  {
    return 'mysqli';
  }

  function getConnectionId()
  {
    if(!isset($this->connectionId))
    {
      $this->connect();
    }
    return $this->connectionId;
  }

  function connect()
  {
    $port = !empty($this->config['port']) ? (int) $this->config['port'] : null;
    $socket = !empty($this->config['socket']) ? $this->config['socket'] : null;
    $this->connectionId = mysqli_connect(
      $this->config['host'], $this->config['user'], $this->config['password'],
      $this->config['database'], $port, $socket
    );

    if($this->connectionId === false)
    {
      $this->_raiseError();
    }

    if(!empty($this->config['charset']))
    {
      $this->execute("SET NAMES '{$this->config['charset']}'");
    }
  }

  function __wakeup()
  {
    $this->connectionId = null;
  }

  function disconnect()
  {
    if($this->connectionId)
    {
      mysqli_close($this->connectionId);
      $this->connectionId = null;
    }
  }

  function _raiseError($sql = null)
  {
    if(!$this->getConnectionId())
      throw new lmbDbException('Could not connect to host "' . $this->config['host'] . '" and database "' . $this->config['database'] . '"');

    $errno = mysqli_errno($this->getConnectionId());
    $id = 'DB_ERROR';
    $info = array('driver' => 'lmbMysql');
    if($errno != 0)
    {
      $info['errorno'] = $errno;
      $info['error'] = mysqli_error($this->getConnectionId());
      $id .= '_MESSAGE';
    }
    if(!is_null($sql))
    {
      $info['sql'] = $sql;
      $id .= '_SQL';
    }
    throw new lmbDbException(mysqli_error($this->getConnectionId()) . ' SQL: '. $sql, $info);
  }

  function execute($sql)
  {
    $result = mysqli_query($this->getConnectionId(), $sql);
    if($result === false)
    {
      $this->_raiseError($sql);
    }
    return $result;
  }

  function executeStatement($stmt)
  {
    return (bool) $this->execute($stmt->getSQL());
  }

  function beginTransaction()
  {
    $this->execute('BEGIN');
  }

  function commitTransaction()
  {
    $this->execute('COMMIT');
  }

  function rollbackTransaction()
  {
    $this->execute('ROLLBACK');
  }

  function newStatement($sql)
  {
    if(preg_match('/^\s*\(*\s*(\w+).*$/m', $sql, $match))
    {
      $statement = $match[1];
    }
    else
    {
      $statement = $sql;
    }
    switch(strtoupper($statement))
    {
      case 'SELECT':
      case 'SHOW':
      case 'DESCRIBE':
      case 'EXPLAIN':
      return new lmbMysqliQueryStatement($this, $sql);
      case 'INSERT':
      return new lmbMysqliInsertStatement($this, $sql);
      case 'UPDATE':
      case 'DELETE':
      return new lmbMysqliManipulationStatement($this, $sql);
      default:
      return new lmbMysqliStatement($this, $sql);
    }
  }

  function getTypeInfo()
  {
    return new lmbMysqliTypeInfo();
  }

  function getDatabaseInfo()
  {
    return new lmbMysqliDbInfo($this, $this->config['database'], true);
  }

  function quoteIdentifier($id)
  {
    if(!$id)
      return '';

    $pieces = explode('.', $id);
    $quoted = '`' . $pieces[0] . '`';
    if(isset($pieces[1]))
       $quoted .= '.`' . $pieces[1] . '`';
    return $quoted;
  }

  function escape($string)
  {
    return mysqli_escape_string($this->getConnectionId(), $string);
  }

  function getSequenceValue($table, $colname)
  {
    return mysqli_insert_id($this->connectionId);//???

  }
}


