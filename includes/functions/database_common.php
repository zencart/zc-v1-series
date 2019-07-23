<?php 
  function zen_db_perform($table, $data, $action = 'insert', $parameters = '') {
    global $db;
    if (strtolower($action) == 'insert') {
      $query = 'INSERT INTO ' . $table . ' (';
      foreach($data as $columns => $value) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') VALUES (';
      foreach($data as $value) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'NULL':
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . zen_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif (strtolower($action) == 'update') {
      $query = 'UPDATE ' . $table . ' SET ';
      foreach($data as $columns => $value) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'NULL':
          case 'null':
            $query .= $columns . ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . zen_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' WHERE ' . $parameters;
    }

    return $db->Execute($query);
  }

/**
 * Alias to $db->prepareInput() for sanitizing db inserts
 * @param string $string
 * @return string
 */
  function zen_db_input($string) {
    global $db;
    return $db->prepareInput($string);
  }

  function zen_db_output($string) {
    if (IS_ADMIN_FLAG) {
       return htmlspecialchars($string, ENT_COMPAT, CHARSET, TRUE);
    } else {
       return htmlspecialchars($string);
    }
  }

  function zen_db_prepare_input($string, $trimspace = true) {
    if (is_string($string)) {
      if ($trimspace == true) {
        return trim(stripslashes($string));
      } else {
        return stripslashes($string);
      }
    } elseif (is_array($string)) {
      foreach($string as $key => $value) {
        $string[$key] = zen_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }
