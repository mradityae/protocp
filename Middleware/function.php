<?php
    require_once "connection.php";

    function getListDate(){
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
            $k = 0;
            $newData = [];
            foreach($jsonArray as $jsonData){
                foreach($jsonData as $jsonDiti){
                    $newData[] = $jsonDiti -> TanggalLapor;
                    $k += 1;
                }
            }
    
            $response = array(
                'status' => 200,
                'message' => 'Success',
                'data' => $newData,
                'jumlah' => $k
            );
            //echo json_encode($response);
            return json_encode($response);
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

    function getTanggalLapor(){
        global $mysqli;
        $sql1 = "SELECT * FROM dataRecords";
        $result1 = $mysqli -> query($sql1);
        if ($result1 -> num_rows > 0){
            $listDate = json_decode(getListDate());
            $query = "select * from sourcedatagangguan where";
            $i = 1;
            foreach($listDate -> data as $tanggal){
                $time = str_replace('/','-',$tanggal);
                $newtime = date('d/m/Y H:i', strtotime($time));
                $query .= " TanggalLapor NOT like '%$newtime%' ";
                if ($i < $listDate -> jumlah){
                    $query .= " AND ";
                } 
                $i += 1;
            }
            return $query;
        }
        else {
            return false;
        }
    }

    function weekNumberOfMonth($date) {

        $tgl=date_parse($date);
        $tanggal = $tgl['day'];
        $bulan = $tgl['month'];
        $tahun = $tgl['year'];

        $tanggalAwalBulan = mktime(0, 0, 0, $bulan, 1, $tahun);
        $mingguAwalBulan = (int) date('W', $tanggalAwalBulan);

        //tanggal sekarang

        $tanggalYangDicari = mktime(0, 0, 0, $bulan, $tanggal, $tahun);
        $mingguTanggalYangDicari = (int) date('W', $tanggalYangDicari);
        $mingguKe = $mingguTanggalYangDicari - $mingguAwalBulan + 1;
        return $mingguKe;

    }
    //sample code
    // $tanggal='2022-08-08';
    // $minggu_ke=weekNumberOfMonth($tanggal);
    //echo ($tanggal." adalah minggu ke=".$minggu_ke);

    function tgl_indo($tanggal){
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);
    
        //return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
        return $bulan[ (int)$pecahkan[1] ];
    }
    //sample code
    // $time = '24/08/2022 18:12';
    // $time = str_replace('/', '-', $time);
    // $newformat = tgl_indo(date('Y-m-d',strtotime($time)));
    // echo $newformat;