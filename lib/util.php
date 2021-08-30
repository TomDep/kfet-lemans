<?php

function dynamicBindVariables($stmt, $params)
{
    if ($params != null)
    {
        // Generate the Type String (eg: 'issisd')
        $types = '';
        foreach($params as $param)
        {
            if(is_int($param)) {
                // Integer
                $types .= 'i';
            } elseif (is_float($param)) {
                // Double
                $types .= 'd';
            } elseif (is_string($param)) {
                // String
                $types .= 's';
            } else {
                // Blob and Unknown
                $types .= 'b';
            }
        }
  
        // Add the Type String as the first Parameter
        $bind_names[] = $types;
  
        // Loop thru the given Parameters
        for ($i=0; $i<count($params);$i++)
        {
            // Create a variable Name
            $bind_name = 'bind' . $i;
            // Add the Parameter to the variable Variable
            $$bind_name = $params[$i];
            // Associate the Variable as an Element in the Array
            $bind_names[] = &$$bind_name;
        }
         
        // Call the Function bind_param with dynamic Parameters
        call_user_func_array(array($stmt,'bind_param'), $bind_names);
    }
    return $stmt;
}

function update($mysqli, $table, $values, $id) {
    // Create the request string
    $req = 'UPDATE '. $table .' SET ';
    $variables = [];

    for($i = 0; $i < count($values); $i++) {
        if($i != 0) $req .= ' ,';
        $req .= $values[$i]['key'] . ' = ?';
        $variables[] = $values[$i]['value'];
    }

    $req .= ' WHERE id = ?';
    $variables[] = $id;

    if($stmt = $mysqli->prepare($req)) {
        $stmt = dynamicBindVariables($stmt, $variables);
        if($stmt->execute()) {
            $successMessage = 'Successfully updated the product with id = ' . $id;
            return true;
        }
    }

    return false;
}

function select($mysqli, $table, $values, $id) {
    $req = 'SELECT ';

    for($i = 0; $i < count($values); $i++) {
        if($i != 0) $req .= ' ,';
        $req .= $values[$i];
    }

    $req .= ' FROM ' . $table . ' WHERE id = ?';

    if($stmt = $mysqli->prepare($req)) {
        $stmt->bind_param('i', $id);
        if($stmt->execute()) {
            $result = $stmt->get_result();
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            $successMessage = 'Successfully updated the product with id = ' . $id;
            return $data;
        }
    }
}

function insert($mysqli, $table, $values) {

    $req = 'INSERT INTO ' . $table . ' (';

    for($i = 0; $i < count($values); $i++) {
        if($i != 0) $req .= ', ';
        $req .= $values[$i]['key'];
    }

    $req .= ') VALUES (';
    for($i = 0; $i < count($values); $i++) {
        if($i != 0) $req .= ' ,';
        $req .= '\'' . $values[$i]['value'] . '\'';
    }
    $req .= ')';

    var_dump($req);

    return $mysqli->query($req);
}

function getRandomString($length = 6) {
    $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?";
    $validCharNumber = strlen($validCharacters);
 
    $result = "";
 
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
 
    return $result;
}

?>