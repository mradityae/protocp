<?php

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

    require_once "connection.php";

    try{
        $sql = "SELECT * FROM sourcedatagangguan ORDER BY ID_Data";
        $result = $mysqli -> query($sql);
        $i = 0;
        while($row = $result -> fetch_array(MYSQLI_ASSOC)){
            $time = str_replace('/', '-', $row["TanggalLapor"]);
            $newtime = date('Y-m-d',strtotime($time));
            $yeartime = date('Y', strtotime($time));
            $data = "Data Penanganan Gangguan Jaringan Via Tiket BULAN ".tgl_indo($newtime)." MINGGU KE ".weekNumberOfMonth($newtime)." ".$yeartime;
            // $json[] = $row;
            $json[] = $row;
            $json[$i]['Title'] = $data;
            $i += 1;
        }
        $dataString = json_encode($json);
        
        $sql2 = "INSERT INTO datarecords (dataRecord) VALUES ('$dataString')";

        if ($mysqli->query($sql2) === true) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql2 . "<br>" . $mysqli->error;
        }
        //print_r($json);
        $mysqli -> close();    
    }  
    catch(Exception $e){
        printf(" Error : ", $e);
        $mysqli -> close();
    }