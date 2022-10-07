<?php

    require_once "connection.php";
    require_once "function.php";

    if(function_exists($_GET['function'])) {
        $_GET['function']();
    } 

    function get_data(){
        header('Content-Type: application/json');
        global $mysqli;
        try{
            $sql = "SELECT dataRecord FROM datarecords";
            $statement = $mysqli-> prepare($sql);
            $jsonArray = [];
    
            $statement->execute(); // Execute the statement.
            $result = $statement->get_result();
            $i = 0;
            while($row = $result -> fetch_assoc()){
                $jsonArray[] = json_decode($row['dataRecord']);
                $i += 1;
            }
            
            $newData = [];
            foreach($jsonArray as $jsonData){
                foreach($jsonData as $jsonDiti){
                    $newData[] = $jsonDiti;
                }
            }
    
            $response = array(
                'status' => 200,
                'message' => 'Success',
                'data' => $newData
            );
            echo json_encode($response);
        }     
        catch(Exception $Error){
            $response = array(
                'status' => 500,
                'message' => 'Error',
                'data' => $Error
            );
            echo json_encode($response);
        }
        $mysqli -> close();
    }

    function insert_data(){
        global $mysqli;
        try{
            $check = array('date' => '');
            $check_match = count(array_intersect_key($_POST, $check));

            if ($check_match == count($check)){
                $datePost = date('m/Y',strtotime($_POST['date']));
                $sql1 = "SELECT * FROM dataRecords where dataRecord";
                $result1 = $mysqli -> query($sql1);
                $sql = "";
                if ($result1 -> num_rows == 0){
                    if (getTanggalLapor() == false){
                        $sql .= "SELECT * FROM sourcedatagangguan where TanggalLapor like '%$datePost%' ORDER BY ID_Data";
                    }
                    else {
                        $sql .= getTanggalLapor();
                    }
                    echo $sql;
                    $result = $mysqli -> query($sql);
                    if ($result -> num_rows > 0){
                        $i = 0;
                        while($row = $result -> fetch_array(MYSQLI_ASSOC)){
                            $time = str_replace('/', '-', $row["TanggalLapor"]);
                            $newtime = date('Y-m-d',strtotime($time));
                            $yeartime = date('Y', strtotime($time));
                            $data = "Data Penanganan Gangguan Jaringan Via Tiket BULAN ".tgl_indo($newtime)." MINGGU KE ".weekNumberOfMonth($newtime)." ".$yeartime;
                            $json[] = $row;
                            $json[$i]['Title'] = $data;
                            $i += 1;
                        }
                        $dataString = json_encode($json);
                        
                        $sqlTwo = "INSERT INTO datarecords (dataRecord) VALUES ('$dataString')";
                        
                        header('Content-Type: application/json');

                        if ($mysqli->query($sqlTwo) === true) {
                            $response = array(
                                'status' => 200,
                                'message' => 'New record created successfully'
                            );
                        } else {
                            $response = array(
                                'status' => 500,
                                'message' => 'New record created failed'
                            );
                        }
                        echo json_encode($response);
                    }
                    else {
                        header('Content-Type: application/json');

                        $response = array(
                            'status' => 201,
                            'message' => 'No Record from sourcedataGangguan'
                        );
                        echo json_encode($response);
                    }
                }
                else {
                    header('Content-Type: application/json');
                    $response = array(
                        'status' => 201,
                        'message' => 'No Record from dataRecords'
                    );
                    echo json_encode($response);
                }
            } 
            else {
                header('Content-Type: application/json');
                $response=array(
                    'status' => 400,
                    'message' =>'Wrong Parameter'
                 );
                 echo json_encode($response);
            }
        }  
        catch(Exception $e){
            header('Content-Type: application/json');
            printf(" Error : ", $e);
            $response = array(
                'status' => 500,
                'message' => $e
            );
            echo json_encode($response);
        }
        $mysqli -> close();
    }