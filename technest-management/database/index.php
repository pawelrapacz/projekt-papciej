<?php
    session_start();
    
    if (!isset($_SESSION['loginStatus']) || !$_SESSION['loginStatus'])
    {
        header('Location: /technest-management/login/');
        exit;        
    }
?>
<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/head.html';

        if (isset($_GET['table']))
            echo '<script type="module" src="/technest-management/js/dbTable.js"></script>';
    ?>
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/common/loader.html';
        require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/sidebar.php';
    ?>
    <div class="wrapper">
        <main>
            <table class="table content-box">
                <?php
                    require_once $_SERVER['DOCUMENT_ROOT'].'/connect.php';
                    const TABLE = 0;
                    const VIEW = 1;
 

                    $db =  new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

                    //  RETURNS: false when table/view is empty, true otherwise
                    function displayHeader($name, $type) {
                        global $db;
                        $recordsNum = $db->query('SELECT COUNT(*) FROM '.$name)->fetch_row()[0];
                        $columns = $db->query('DESCRIBE '.$name);
                        $columnNum = $columns->num_rows;

                        // TODO: error handling;

                        
                        echo '<thead>';
                        
                        if ($type == TABLE)
                        {
                            $tableTitleColspan = ceil(($columnNum + 2) * 0.5);
                            $tableOptionsColspan = floor(($columnNum + 2) * 0.5);
                            echo '
                            <tr>
                                <th class="table-header" colspan="'.$tableTitleColspan.'">
                                    <div class="table-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4 21h15.893c1.103 0 2-.897 2-2V5c0-1.103-.897-2-2-2H4c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2zm0-2v-5h4v5H4zM14 7v5h-4V7h4zM8 7v5H4V7h4zm2 12v-5h4v5h-4zm6 0v-5h3.894v5H16zm3.893-7H16V7h3.893v5z"></path></svg>
                                        <span><span class="_table_name">'.$name.'</span>('.$recordsNum.')</span>
                                    </div>
                                </th>
                                <th class="table-header" colspan="'.$tableOptionsColspan.'">
                                    <div class="table-options">
                                        <button class="table-modify-btn _create_new">Utwórz nowy</button>
                                        <button class="table-modify-btn _delete_checked">Usuń zaznaczone</button>
                                    </div>
                                </th>
                            </tr>
                            ';
                        }
                        if ($type == VIEW)
                        {
                            echo '
                            <tr>
                                <th class="table-header" colspan="'.$columnNum.'">
                                    <div class="table-title">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path><path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path></svg>
                                        <span>'.$name.'('.$recordsNum.')</span>
                                    </div>
                                </th>
                            </tr>
                            ';
                        }


                        // display columns names
                        echo '<tr class="table-fields">';
                        if ($type == TABLE) echo '<th><input type="checkbox" class="_check_all"></th>';

                        while($col = $columns->fetch_object())
                            echo '<th>'.$col->Field.'</th>';

                        if ($type == TABLE) echo '<th></th>';
                        echo '
                            </tr>
                        </thead>
                        ';
                        

                        // check empty table/view
                        if ($recordsNum > 0) return true;

                        if ($type == TABLE) {
                            echo '
                            <tbody>
                                <tr><th class="no-records" colspan="'.($columnNum + 2).'">Brak wyników</th></tr>
                            </tbody>
                            ';
                            return false;
                        }
                        if ($type == VIEW) {
                            echo '
                            <tbody>
                                <tr><th class="no-records" colspan="'.$columnNum.'">Brak wyników</th></tr>
                            </tbody>
                            ';
                            return false;
                        }
                    }

                    function displayTable($name) {
                        global $db;
                        if (!displayHeader($name, TABLE)) return;

                        $sqlQuery = 'SELECT * FROM '.$name;
                        $result = $db->query($sqlQuery);

                        echo '<tbody>';

                        while ($row = $result->fetch_row())
                        {
                            echo '
                            <tr class="table-row" id="'.$row[0].'">
                               <td><input type="checkbox" class="_check_individual"></td>
                            ';

                            foreach ($row as $value)
                                echo '<td class="expandable"><span>'.$value.'</span></td>';

                            echo '
                                <td>
                                <div>
                                    <button class="el-modify-btn _edit" title="Edytuj">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M19.045 7.401c.378-.378.586-.88.586-1.414s-.208-1.036-.586-1.414l-1.586-1.586c-.378-.378-.88-.586-1.414-.586s-1.036.208-1.413.585L4 13.585V18h4.413L19.045 7.401zm-3-3 1.587 1.585-1.59 1.584-1.586-1.585 1.589-1.584zM6 16v-1.585l7.04-7.018 1.586 1.586L7.587 16H6zm-2 4h16v2H4z"></path></svg>
                                    </button>
                                    <button class="el-modify-btn _delete" title="Usuń">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;"><path d="M5 20a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8h2V6h-4V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2H3v2h2zM9 4h6v2H9zM8 8h9v12H7V8z"></path><path d="M9 10h2v8H9zm4 0h2v8h-2z"></path></svg>
                                    </button>
                                    </div>
                                </td>
                            </tr>
                            ';
                        }
                        echo '</tbody>';
                    }

                    function displayView($name) {
                        global $db;
                        if (!displayHeader($name, VIEW)) return;

                        $sqlQuery = 'SELECT * FROM '.$name;
                        $result = $db->query($sqlQuery);

                        echo '<tbody>';
                        while ($row = $result->fetch_row())
                        {
                            echo '<tr class="table-row">';

                            foreach ($row as $value)
                                echo '<td class="expandable"><span>'.$value.'</span></td>';
                        }
                        echo '</tbody>';
                    }

                    if (isset($_GET['table']))
                    {
                        displayTable($_GET['table']);
                        unset($_GET['table']);                        
                    }
                    if (isset($_GET['view']))
                    {
                        displayView($_GET['view']);
                        unset($_GET['view']);                        
                    }

                    $db->close();
                ?>
            </table>
        </main>
        <?php
            require_once $_SERVER['DOCUMENT_ROOT'].'/technest-management/common/footer.html';
        ?>
    </div>
</body>
</html>