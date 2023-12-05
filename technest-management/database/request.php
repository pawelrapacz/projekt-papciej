<?php
    session_start();
    if (!isset($_SESSION['loginStatus']) || !$_SESSION['loginStatus'])
    {
        header('Location: /technest-management/login/');
        exit;        
    }

    if (
        !isset($_POST['requestType']) ||
        !isset($_POST['table'])
    ) {/* error */}

    require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/error_codes.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';

    try { $db = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME); }
    catch (mysqli_sql_exception $e) {
        $_SESSION['error'] = ERR_DB_CONNECT;
        $_SESSION['errorMessage'] = $e->getMessage();
        $_SESSION['errorCode'] = $e->getCode();

        header('Location: /technest-management/error/');
        exit; 
    }
    
    // REQUEST TYPES
    const DELETE_CHECKED = 'DELETE_CHECKED';
    const DELETE = 'DELETE';
    const EDIT = 'EDIT';
    const CREATE_NEW = 'CREATE_NEW';

    
    $requestType = $_POST['requestType'];
    $table = $_POST['table'];
    $idField = getTableIdFieldName($table);

    if ($requestType === DELETE_CHECKED)
    {
        if (!($amountToDelete = $_POST['amountToDelete'])) {/* error */}
        
        for ($i = 0; $i < $amountToDelete; $i++)
        {
            if (!($id = $_POST[$i])) {/* error */}
            $db->query("DELETE FROM $table WHERE $idField = $id");
        }
        goBackToPreviousPage();
    }

    if ($requestType === DELETE)
    {
        if (!($id = $_POST['id'])) {/* error */}
        $db->query("DELETE FROM $table WHERE $idField = $id");
        goBackToPreviousPage();
    }

    if ($requestType === EDIT)
    {
        echo 'dasdfas';
        if (!($id = $_POST['id'])) {/* error */}
        $tableFields = getTableFieldsNames($table);
        $tableFieldTypes = getTableFieldsTypes($table);
        $insertValues = Array();

        foreach ($tableFields as $key => $value) {
            if ($value === $idField)
            {
                array_push($insertValues, 'NULL');
                continue;
            }

            array_push( $insertValues, processDataForSqlUsage($_POST[$value], $tableFieldTypes[$key]) );
        }

        $sql = 'UPDATE '.$table.' SET ';

        foreach ($insertValues as $key => $value)
        {
            if ($tableFields[$key] === $idField) continue;
            if ($key === 1)
            {
                $sql .= $tableFields[$key].' = '.$value;
                continue;
            }
            $sql .= ', '.$tableFields[$key].' = '.$value;
        }

        $sql .= ' WHERE '.$idField.' = '.$id.';';
        $db->query($sql);
        goBackToPreviousPage();
    }

    if ($requestType === CREATE_NEW)
    {
        $tableFields = getTableFieldsNames($table);
        $tableFieldTypes = getTableFieldsTypes($table);
        $insertValues = Array();

        array_shift($tableFields);
        array_shift($tableFieldTypes);

        foreach ($tableFields as $key => $value)
            array_push( $insertValues, processDataForSqlUsage($_POST[$value], $tableFieldTypes[$key]) );

        $sql = 'INSERT INTO '.$table.' ('.implode(', ', $tableFields).') VALUES ('.implode(', ', $insertValues).')';
        echo $sql;
        $db->query($sql);
        goBackToPreviousPage();
    }




    function goBackToPreviousPage()
    {
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }

    function getTableIdFieldName(string $table)
    {
        global $db;
        $result = $db->query('DESCRIBE '.$table);
        return $result->fetch_row()[0];
    }

    function getTableFieldsNames(string $table)
    {
        global $db;
        $result = $db->query('DESCRIBE '.$table);
        $tabFields = Array();

        while ($row = $result->fetch_row())
            array_push($tabFields, $row[0]);

        return $tabFields;
    }

    function getTableFieldsTypes(string $table)
    {
        global $db;
        $result = $db->query('DESCRIBE '.$table);
        $tabFields = Array();

        while ($row = $result->fetch_row())
            array_push($tabFields, explode('(', $row[1])[0]);

        return $tabFields;
    }

    function processDataForSqlUsage($value, string $type)
    {
        if (
            $type === 'char' ||
            $type === 'varchar' ||
            $type === 'text' ||
            $type === 'tinytext' ||
            $type === 'mediumtext' ||
            $type === 'longtext' ||
            $type === 'date' ||
            $type === 'datetime' ||
            $type === 'timestamp' ||
            $type === 'time' ||
            $type === 'year' ||
            $type === 'enum'
        ) { return '"'.$value.'"'; }
        
        return $value;
    }

    $db->close();
?>