<?php

    // $jsonobj = '[{"Peter":35,"Ben":37,"Joe":43},{"Peter":33,"Ben":38,"Joe":41}]';

    // $obj = json_decode($jsonobj);

    // print_r($obj[0]->Peter);

    // echo $obj->Peter;
    // echo $obj->Ben;
    // echo $obj->Joe;


    require_once "connection.php";
    try{
        // $json = file_get_contents('data.json');
        // $json_data = json_decode($json, true);

        // $i = 0;
        // foreach($json_data as $jsonRecord){
        //     echo $jsonRecord['ID_Data'];
        //     $i += 1;
        // }
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
        
        $key_ = array();

        foreach($newData[0] as $key => $value){
            array_push($key_, $key);
        }
        $l = 0;
        foreach($newData as $newDatas){
            foreach($key_ as $key){
                echo $key." : ".$newDatas -> $key;
                $l += 1;
            }
        }
        echo $l;

        // for ($i = 0; $i < count($jsonArray); $i++){
        //     for ($j = 0; $j < count($jsonArray[$i]); $j++){
        //         foreach($jsonArray[$i][$j] as $key => $value){
        //             echo $key;
        //             echo "\n";
        //         }
        //     }
        //     echo count($jsonArray[$i]);
        //     echo "\n";
        // }

        //$json_Record = json_decode($json_data["dataRecord"], true);

        // $dataJson = json_encode(($result->fetch_assoc()));
    
        // $json_data = json_decode($dataJson, true);
        // $json_Record = json_decode($json_data["dataRecord"], true);
        
        // $i = 0;
        // foreach($json_Record as $jsonRecord){
        //     print_r($jsonRecord["ID_Data"]);
        //     echo "\n";
        //     $i += 1;
        // }
        //print_r($json);
        $mysqli -> close();    
    }  
    catch(Exception $e){
        printf(" Error : ", $e);
        $mysqli -> close();
    }