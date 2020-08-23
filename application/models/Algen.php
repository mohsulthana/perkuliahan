<?php
  class Algen{
    public function __construct($param){
      $this->param = $param;
      $this->init_available();
      $this->init_jadwal_bukit();
      $this->init_jadwal_layo();
      $this->calcFitness();
    }
    public function cek_ignore($temp,$ignore){
      $flag = true;
      // CEK APAKAH I DAN J SUDAH DI-BOOKING
      foreach ($ignore as $key => $value) {
        // JIKA IYA, JANGAN DIISI
        if($temp === $value){
          $flag = false;
          break;
        }
      }
      return $flag;
    }
    public function init_available(){
      $total_jam_bukit    = $this->param->bukit->total_jam;
      $total_kelas_bukit  = count($this->param->bukit->kelas);
      $total_jam_layo    = $this->param->layo->total_jam;
      $total_kelas_layo  = count($this->param->layo->kelas);
      $ignore_bukit = $this->param->ignore_bukit;
      $ignore_layo  = $this->param->ignore_layo;
      $sisa_bukit   = [];
      $sisa_layo    = [];

      // CEK BOOKING BUKIT
      for ($i = 0; $i < $total_jam_bukit; $i++) {
        for ($j = 0; $j < $total_kelas_bukit ; $j++) {
          $flag_bukit = $this->cek_ignore([$i,$j], $ignore_bukit);
          // JIKA FLAG TRUE (JADWAL TIDAK DI-BOOKING), MAKA ISI 
          if($flag_bukit)
            $sisa_bukit[] = [$i,$j];
        }
      }
      // CEK BOOKING INDERALAYA
      for ($i = 0; $i < $total_jam_layo; $i++) {
        for ($j = 0; $j < $total_kelas_layo ; $j++) {
          $flag_layo = $this->cek_ignore([$i,$j], $ignore_layo);
          // JIKA FLAG TRUE (JADWAL TIDAK DI-BOOKING), MAKA ISI 
          if($flag_layo)
            $sisa_layo[] = [$i,$j];
        }
      }
      $this->sisa_bukit = $sisa_bukit;
      $this->sisa_layo  = $sisa_layo;
    }
    public function init_jadwal_bukit(){
      $mk           = $this->param->bukit->jadwal;
      $total_mk     = count($mk);
      $kelas        = $this->param->bukit->kelas;
      $total_kelas  = count($kelas);
      $jam          = $this->param->jam;
      $pop_bukit    = [];
      $count        = 0;
      $total_jam    = $this->param->bukit->total_jam;

      $ignore_bukit = $this->param->ignore_bukit;
      for ($i = 0; $i < $total_jam; $i++) {
        for ($j = 0; $j < $total_kelas ; $j++) {
          
          // CEK APAKAH I DAN J SUDAH DI-BOOKING
          $flag = $this->cek_ignore([$i,$j], $ignore_bukit);

          // JIKA IYA, MAKA FITNESS-NYA 1
          if($flag === false){
            $pop_bukit[$i][$j]['kromosom'] = ['dosen1' => '', 'dosen2' => ''];
            $pop_bukit[$i][$j]['fitness']  = 1;
          }
          else{
            // JIKA TIDAK, MAKA MASUKKAN JADWAL YANG AKAN DIOPTIMASI
            if($count !== $total_mk){
              $pop_bukit[$i][$j]['kromosom'] = $mk[$count];
              $pop_bukit[$i][$j]['fitness']  = 0;
              $count++;
            }
            else{
              $pop_bukit[$i][$j]['kromosom'] = ['dosen1' => '', 'dosen2' => ''];
              $pop_bukit[$i][$j]['fitness']  = 0.5;
            }   
          }
        } 
      }
      $this->pop_bukit = $pop_bukit;
    }
    public function init_jadwal_layo(){
      $mk           = $this->param->layo->jadwal;
      $total_mk     = count($mk);
      $kelas        = $this->param->layo->kelas;
      $total_kelas  = count($kelas);
      $jam          = $this->param->jam;
      $pop_layo     = [];
      $count        = 0;
      $total_jam    = $this->param->layo->total_jam;

      $ignore_layo  = $this->param->ignore_layo;
      for ($i = 0; $i < $total_jam; $i++) {
        for ($j = 0; $j < $total_kelas ; $j++) {

          // CEK APAKAH I DAN J SUDAH DI-BOOKING
          $flag = $this->cek_ignore([$i,$j], $ignore_layo);

          // JIKA IYA, MAKA FITNESS-NYA 1
          if($flag === false){
            $pop_layo[$i][$j]['kromosom'] = ['dosen1' => '', 'dosen2' => ''];
            $pop_layo[$i][$j]['fitness']  = 1;
          }
          else{
            // JIKA TIDAK, MAKA MASUKKAN JADWAL YANG AKAN DIOPTIMASI
            if($count !== $total_mk){
              $pop_layo[$i][$j]['kromosom'] = $mk[$count];
              $pop_layo[$i][$j]['fitness']  = 0;
              $count++;
            }
            else{
              $pop_layo[$i][$j]['kromosom'] = ['dosen1' => '', 'dosen2' => ''];
              $pop_layo[$i][$j]['fitness']  = 0.5;
            }
          }
        } 
      }
      $this->pop_layo = $pop_layo;
    }
    public function get_list_dosen_except($j,$pop){
      $dosen = [];
      
      // LAKUKAN LOOP TERHADAP POPULASI PADA JAM KE-J
      foreach ($pop as $key => $value) {
        // KALAU NILAI $j ADA PADA LOOP, LEWATI
        if($key == $j)
          continue;
        // JIKA NILAI DOSEN1 DAN DOSEN2 TIDAK KOSONG / TIDAK NULL
        // MAKA MASUKKAN NAMA DOSEN KE ARRAY DOSEN[]
        else{
          if($value['kromosom']['dosen1'] != "")
            $dosen[] = $value['kromosom']['dosen1'];
          if($value['kromosom']['dosen2'] != "" && !is_null($value['kromosom']['dosen2']))
            $dosen[] = $value['kromosom']['dosen2'];
        }
      }
      return $dosen;
    }
    public function get_list_dosen_hari($i, $pop, $lokasi){
      $pop_layo   = $this->pop_layo;
      $pop_bukit  = $this->pop_bukit;
      // JIKA LOKASI DI BUKIT, MAKA CEK JADWAL INDERALAYA
      $dosen = [];

      if($lokasi === 'bukit'){
        $index = intdiv($i, 3) * 3;

        if($i >= 14)
          $temp_layo = [];
        else if($index === 12)
          $temp_layo = [$pop_layo[$index+0], $pop_layo[$index+1]];
        
        else
          $temp_layo = [$pop_layo[$index+0], $pop_layo[$index+1], $pop_layo[$index+2]];
        
        foreach ($temp_layo as $key => $mk) {
          foreach ($mk as $key2 => $value2) {
            if($value2['kromosom']['dosen1'] !== "")
              $dosen[] = $value2['kromosom']['dosen1'];
            if($value2['kromosom']['dosen2'] !== "" && !is_null($value2['kromosom']['dosen2'])){
              $dosen[] = $value2['kromosom']['dosen2'];
            }
          }
        }
      }
      else{
        $index = intdiv($i, 3) * 3;

        if($index === 12)
          $temp_bukit = [$pop_bukit[$index+0], $pop_bukit[$index+1]];
        else
          $temp_bukit = [$pop_bukit[$index+0], $pop_bukit[$index+1], $pop_bukit[$index+2]];
        foreach ($temp_bukit as $key => $mk) {
          foreach ($mk as $key2 => $value2) {
            if($value2['kromosom']['dosen1'] !== "")
              $dosen[] = $value2['kromosom']['dosen1'];
            if($value2['kromosom']['dosen2'] !== "" && !is_null($value2['kromosom']['dosen2'])){
              $dosen[] = $value2['kromosom']['dosen2'];
            }
          }
        }
      }
      return $dosen;
      // 0*3 + 0
      // 1*3 + 0
      // 2*3 + 0
      // 0 1 2 = /3 = 0
      // 3 4 5 = /3 = 1
      // 6 7 8 = /3 = 2
      // 9 10 11 = /3 = 3
      // 12 13 14 = /3 = 4
      // 15 16 17 = /3 = 5
    }
    public function calcFitness(){
      // FITNESS
      // 1 - OK
      // 0 - HARI KENA, JAM KENA
      // 0.25 - JAM KENA
      // 0.5 - HARI KENA

      // INIT POPULASI
      $pop_bukit  = $this->pop_bukit;
      $pop_layo   = $this->pop_layo;
      $pop_bukit = $this->pop_bukit;

      // 1. CEK JADWAL BUKIT, APAKAH ADA HARI YANG TUMBURAN
      // LOOP JADWAL BUKIT
      for ($i = 0; $i < count($pop_bukit); $i++) {
        // AMBIL LIST DOSEN INDERALAYA PADA HARI KE-$i
        $list_dosen_hari = $this->get_list_dosen_hari($i,$pop_bukit,'bukit');  
        for ($j = 0; $j < count($pop_bukit[0]); $j++) {
          // AMBIL LIST DOSEN BUKIT PADA JAM KE-$j
          $list_dosen = $this->get_list_dosen_except($j,$pop_bukit[$i]);
          
          $dosen1 = $pop_bukit[$i][$j]['kromosom']['dosen1'];
          $dosen2 = $pop_bukit[$i][$j]['kromosom']['dosen2'];

          // CEK CONFLICT DOSEN 1 DAN DOSEN 2
          // CONFLICT: HARI DAN JAM, FITNESS = 0
          // CONFLICT: JAM, FITNESS = 0.25
          // CONFLICT: HARI, FITNESS = 0.5
          
          // $CONFLICT_HARI = in_array($dosen1, $list_dosen_hari) || in_array($dosen2, $list_dosen_hari);
          // $CONFLICT_JAM  = in_array($dosen1, $list_dosen) || in_array($dosen2, $list_dosen);
          // edit
          $CONFLICT_HARI = in_array($dosen1, $list_dosen_hari);
          $CONFLICT_JAM  = in_array($dosen1, $list_dosen);
          // edit
          if($CONFLICT_HARI && $CONFLICT_JAM)
            $pop_bukit[$i][$j]['fitness'] = 0;
          else if($CONFLICT_HARI)
          // if($CONFLICT_HARI)
            $pop_bukit[$i][$j]['fitness'] = 0.25;
          else if($CONFLICT_JAM)
          // if($CONFLICT_JAM)
            $pop_bukit[$i][$j]['fitness'] = 0.5;
          else
            $pop_bukit[$i][$j]['fitness'] = 1;
        }
      }
      
      // 2. CEK JADWAL INDERALAYA, APAKAH ADA HARI YANG TUMBURAN
      // LOOP JADWAL INDERALAYA
      for ($i = 0; $i < count($pop_layo); $i++) {
        // AMBIL LIST DOSEN INDERALAYA PADA HARI KE-$i
        $list_dosen_hari = $this->get_list_dosen_hari($i,$pop_layo,'layo');  
        for ($j = 0; $j < count($pop_layo[0]); $j++) {
          // AMBIL LIST DOSEN INDERALAYA PADA JAM KE-$j
          $list_dosen = $this->get_list_dosen_except($j,$pop_layo[$i]);
          
          $dosen1 = $pop_layo[$i][$j]['kromosom']['dosen1'];
          $dosen2 = $pop_layo[$i][$j]['kromosom']['dosen2'];

          // CEK CONFLICT DOSEN 1 DAN DOSEN 2
          // CONFLICT: HARI DAN JAM, FITNESS = 0
          // CONFLICT: JAM, FITNESS = 0.25
          // CONFLICT: HARI, FITNESS = 0.5
          
          $CONFLICT_HARI = in_array($dosen1, $list_dosen_hari) || in_array($dosen2, $list_dosen_hari);
          $CONFLICT_JAM  = in_array($dosen1, $list_dosen) || in_array($dosen2, $list_dosen);
          
          if($CONFLICT_HARI && $CONFLICT_JAM)
            $pop_layo[$i][$j]['fitness'] = 0;
          else if($CONFLICT_HARI)
          // if($CONFLICT_HARI)
            $pop_layo[$i][$j]['fitness'] = 0.25;
          else if($CONFLICT_JAM)
          // if($CONFLICT_JAM)
            $pop_layo[$i][$j]['fitness'] = 0.5;
          else
            $pop_layo[$i][$j]['fitness'] = 1;
        }
      }
      // SIMPAN POPULASI BARU
      $this->pop_bukit = $pop_bukit;
      $this->pop_layo  = $pop_layo;

      // VERSI LAMA
        // CEK BUKIT, JIKA DOSEN TUMBURAN JAM, MAKA FITNESS = 0.25
        // for ($i = 0; $i < count($pop_bukit); $i++) {
        //   for ($j = 0; $j < count($pop_bukit[0]); $j++) {
        //     $list_dosen = $this->get_list_dosen_except($j,$pop_bukit[$i]);
        //     $dosen1 = $pop_bukit[$i][$j]['kromosom']['dosen1'];
        //     $dosen2 = $pop_bukit[$i][$j]['kromosom']['dosen2'];

        //     // CEK JIKA ADA DOSEN 1 ATAU DOSEN 2 YANG SAMA PADA 
        //     // JAM DAN HARI YANG SAMA
        //     if(in_array($dosen1, $list_dosen) || in_array($dosen2, $list_dosen))
        //       $pop_bukit[$i][$j]['fitness'] = 0.25;
        //     else
        //       $pop_bukit[$i][$j]['fitness'] = 1;
        //   }
        // }
        // $this->pop_bukit = $pop_bukit;

        // // PINDAH RUANG DAN JAM INDERALAYA
        // $pop_layo = $this->pop_layo;

        // for ($i = 0; $i < count($pop_layo); $i++) {
        //   for ($j = 0; $j < count($pop_layo[0]); $j++) {
        //     $list_dosen = $this->get_list_dosen_except($j,$pop_layo[$i]);
        //     $dosen1 = $pop_layo[$i][$j]['kromosom']['dosen1'];
        //     $dosen2 = $pop_layo[$i][$j]['kromosom']['dosen2'];

        //     // JIKA ADA DOSEN 1 ATAU DOSEN 2 YANG SAMA PADA JAM DAN HARI YANG SAMA
        //     if(in_array($dosen1, $list_dosen) || in_array($dosen2, $list_dosen)){
        //       $pop_layo[$i][$j]['fitness'] = 0;
        //     }
        //     else{
        //       // echo "$i $j FITNESS2<br>";
        //       $pop_layo[$i][$j]['fitness'] = 1;
        //     }
        //   }
        // }
        // $this->pop_layo = $pop_layo;

        // // PINDAH HARI DAN JAM BUKIT
        // $pop_bukit = $this->pop_bukit;
        // for ($i = 0; $i < count($pop_bukit); $i++) {
        //   $list_dosen_hari = $this->get_list_dosen_hari($i,$pop_bukit,'bukit');  
        //   for ($j = 0; $j < count($pop_bukit[0]); $j++) {
        //     // BEGIN EDIT 
        //     $list_dosen = $this->get_list_dosen_except($j,$pop_bukit[$i]);
        //     // END EDIT
        //     $dosen1 = $pop_bukit[$i][$j]['kromosom']['dosen1'];
        //     $dosen2 = $pop_bukit[$i][$j]['kromosom']['dosen2'];

        //     // JIKA ADA DOSEN 1 ATAU DOSEN 2 YANG SAMA PADA JAM DAN HARI YANG SAMA
        //     if(in_array($dosen1, $list_dosen_hari) || in_array($dosen2, $list_dosen_hari)){
        //       $pop_bukit[$i][$j]['fitness'] = 0.2;
        //       // $this->mutation($i,$j);
        //     }
        //     // if(in_array($dosen1, $list_dosen) || in_array($dosen2, $list_dosen)){
        //     //   $pop_bukit[$i][$j]['fitness'] = 0;
        //     // }
        //     // if(in_array($dosen1, $list_dosen) || in_array($dosen2, $list_dosen) || 
        //     //   in_array($dosen1, $list_dosen_hari) || in_array($dosen2, $list_dosen_hari)){
        //     //   $pop_bukit[$i][$j]['fitness'] = 0.2;
        //     // }
        //     else{
        //       // echo "$i $j FITNESS3<br>";
        //       $pop_bukit[$i][$j]['fitness'] = 1;
        //     }
        //   }
        // }
        // $this->pop_bukit = $pop_bukit;
    }
    public function pindah_hari($i, $j,$lokasi){
      if($lokasi == 'bukit'){
        $pop_bukit  = $this->pop_bukit;
        $sisa_bukit = $this->sisa_bukit;

        // DO RANDOM I DAN J
        $rand  = mt_rand(0,count($sisa_bukit)-1);
        $randi = $sisa_bukit[$rand][0];
        $randj = $sisa_bukit[$rand][1];

        // SWAP
        $temp                      = $pop_bukit[$i][$j];
        $pop_bukit[$i][$j]         = $pop_bukit[$randi][$randj];
        $pop_bukit[$randi][$randj] = $temp;

        $this->pop_bukit = $pop_bukit;
      }
      else{
        $pop_layo  = $this->pop_layo;
        $sisa_layo = $this->sisa_layo;

        // DO RANDOM I DAN J
        $rand  = mt_rand(0,count($sisa_layo)-1);
        $randi = $sisa_layo[$rand][0];
        $randj = $sisa_layo[$rand][1];

        // SWAP
        $temp                     = $pop_layo[$i][$j];
        $pop_layo[$i][$j]         = $pop_layo[$randi][$randj];
        $pop_layo[$randi][$randj] = $temp;

        $this->pop_layo = $pop_layo;
      }
    }
    public function pindah_jam($i, $j,$lokasi){
      if($lokasi == 'bukit'){
        $pop_bukit    = $this->pop_bukit;  
        $sisa_bukit   = $this->sisa_bukit;

        // NORMALISASI NILAI $i, UNTUK TAU PADA HARI APA
        $index = intdiv($i, 3) * 3; 
        $day      = [$index+0, $index+1, $index+2];
        $all_days = [];

        // AMBIL SEMUA JAM (1 HARI = 3 JAM, KECUALI JUMAT)
        for ($k = 0; $k < count($pop_bukit) ; $k++)
          $all_days[] = $k;  
        
        // DIFF = HARI YANG DIPERBOLEHKAN UNTUK SWAP
        $ignorei = [];
        $ignorej = [];
        $diff = array_diff($all_days, $day);

        // DO RANDOM I DAN J
        $rand  = mt_rand(0,count($sisa_bukit)-1);
        $randi = $sisa_bukit[$rand][0];
        $randj = $sisa_bukit[$rand][1];

        // JIKA NILAI RANDOM TIDAK ADA PADA DIFF, MAKA ULANGI RANDOM, MAX 10 KALI
        $count = 0;
        while(!in_array($randi, $diff)){
          $rand  = mt_rand(0,count($sisa_bukit)-1);
          $randi = $sisa_bukit[$rand][0];
          $randj = $sisa_bukit[$rand][1];
          $count++;
          if($count >= 10) break;
        }
        // SWAP
        $temp                      = $pop_bukit[$i][$j];
        $pop_bukit[$i][$j]         = $pop_bukit[$randi][$randj];
        $pop_bukit[$randi][$randj] = $temp;
        $this->pop_bukit = $pop_bukit;
      }
      else{
        $pop_layo    = $this->pop_layo;  
        $sisa_layo   = $this->sisa_layo;

        // NORMALISASI NILAI $i, UNTUK TAU PADA HARI APA
        $index    = intdiv($i, 3) * 3; 
        $day      = [$index+0, $index+1, $index+2];
        $all_days = [];

        // AMBIL SEMUA JAM (1 HARI = 3 JAM, KECUALI JUMAT)
        for ($k = 0; $k < count($pop_layo) ; $k++)
          $all_days[] = $k;  
        
        // DIFF = HARI YANG DIPERBOLEHKAN UNTUK SWAP
        $ignorei = [];
        $ignorej = [];
        $diff = array_diff($all_days, $day);

        // DO RANDOM I DAN J
        $rand  = mt_rand(0,count($sisa_layo)-1);
        $randi = $sisa_layo[$rand][0];
        $randj = $sisa_layo[$rand][1];

        // JIKA NILAI RANDOM TIDAK ADA PADA DIFF, MAKA ULANGI RANDOM, MAX 10 KALI
        $count = 0;
        while(!in_array($randi, $diff)){
          $rand  = mt_rand(0,count($sisa_layo)-1);
          $randi = $sisa_layo[$rand][0];
          $randj = $sisa_layo[$rand][1];
          $count++;
          if($count >= 10) break;
        }

        // SWAP
        $temp                     = $pop_layo[$i][$j];
        $pop_layo[$i][$j]         = $pop_layo[$randi][$randj];
        $pop_layo[$randi][$randj] = $temp;

        $this->pop_layo = $pop_layo;
      }
    }
    public function crossover(){
      // INIT IGNORE (BOOKING), SISA (AVAILABLE), DAN POPULASI
      $ignore_bukit = $this->param->ignore_bukit;
      $ignore_layo  = $this->param->ignore_layo;
      $sisa_bukit   = $this->sisa_bukit;
      $sisa_layo    = $this->sisa_layo;
      $pop_bukit    = $this->pop_bukit;
      $pop_layo     = $this->pop_layo;
      

      // 1. BEGIN CROSSOVER BUKIT
      // LOOP JADWAL BUKIT
      
      for ($i = 0; $i < count($pop_bukit); $i++) {
        for ($j = 0; $j < count($pop_bukit[0]); $j++) {
          // CEK BOOKING
          $flag_bukit  = $this->cek_ignore([$i,$j], $ignore_bukit);
          // JIKA [$i,$j] DI BOOKING, MAKA LEWATI
          if($flag_bukit === false){
            continue;
          }
          // JIKA TIDAK, LAKUKAN CROSSOVER
          else{
            $fitness = $pop_bukit[$i][$j]['fitness'];
            // JIKA FITNESS <= 0.25, MAKA PINDAH HARI
            if($fitness <= 0.25)
              $this->pindah_hari($i, $j,'bukit');
            // JIKA 0.5, MAKA PINDAH JAM
            else if($fitness == 0.5)
              $this->pindah_jam($i, $j,'bukit');
            $this->calcFitness();
          }
        }
      }
      // $this->pop_bukit = $pop_bukit;
      // POP BUKIT TIDAK BERUBAH
      // END CROSSOVER BUKIT
      // 2. BEGIN CROSSOVER INDERALAYA
      // LOOP JADWAL INDERALAYA
      for ($i = 0; $i < count($pop_layo); $i++) {
        for ($j = 0; $j < count($pop_layo[0]); $j++) {
          // CEK BOOKING
          $flag_layo  = $this->cek_ignore([$i,$j], $ignore_layo);
          // JIKA [$i,$j] DI BOOKING, MAKA LEWATI
          if($flag_layo === false)
            continue;
          // JIKA TIDAK, LAKUKAN CROSSOVER
          else{
            $fitness = $pop_layo[$i][$j]['fitness'];
            // JIKA FITNESS <= 0.25, MAKA PINDAH HARI
            if($fitness <= 0.25)
              $this->pindah_hari($i, $j,'layo');
            // JIKA 0.5, MAKA PINDAH JAM
            else if($fitness == 0.5)
              $this->pindah_jam($i, $j,'layo');
            $this->calcFitness();
          }
        }
      }
      // $this->pop_layo = $pop_layo;
      // END CROSSOVER INDERALAYA
      // VERSI LAMA
        // BEGIN CROSSOVER INDERALAYA
        // $pop_layo = $this->pop_layo;

        // for ($i = 0; $i < count($pop_layo); $i++) {
        //   for ($j = 0; $j < count($pop_layo[0]); $j++) {
        //     // if($pop_layo[$i][$j]['fitness'] !== 1){
        //     $flag_layo  = $this->cek_ignore([$i,$j], $ignore_layo);

        //     if($flag_layo === false)
        //       continue;
        //     else{
        //       if($pop_layo[$i][$j]['fitness'] === 0 || $pop_layo[$i][$j]['fitness'] === 0.5){
        //         // DO RANDOM I DAN J
        //         $rand  = mt_rand(0,count($sisa_layo)-1);
        //         $randi = $sisa_layo[$rand][0];
        //         $randj = $sisa_layo[$rand][1];

        //         // SWAP
        //         $temp = $pop_layo[$i][$j];
        //         $pop_layo[$i][$j] = $pop_layo[$randi][$randj];
        //         $pop_layo[$randi][$randj] = $temp;

        //         $this->pop_layo = $pop_layo;
        //         $this->calcFitness();
        //       }
        //     }
        //   }
        // }
        // $this->pop_layo = $pop_layo;
        // $this->calcFitness();
        // END CROSSOVER INDERALAYA
    }
    public function crossover2(){
      $ignore_bukit = $this->param->ignore_bukit;
      $ignore_layo  = $this->param->ignore_layo;
      $sisa_bukit   = $this->sisa_bukit; 
      $pop_bukit = $this->pop_bukit;

      for ($i = 0; $i < count($pop_bukit); $i++) {
        for ($j = 0; $j < count($pop_bukit[0]); $j++) {
          
          
          // CEK APAKAH I DAN J SUDAH DI-BOOKING
          $flag_bukit  = $this->cek_ignore([$i,$j], $ignore_bukit);
          
          if($flag_bukit === false)
            continue;
          else{
            if($pop_bukit[$i][$j]['fitness'] === 0.2){

              $index = intdiv($i, 3) * 3; 
              $day      = [$index+0, $index+1, $index+2];
              $all_days = [];

              for ($k = 0; $k < count($pop_bukit) ; $k++) {
                $all_days[] = $k;  
              }
              
              // DIFF = HARI YANG DIPERBOLEHKAN SWAP
              $ignorei = [];
              $ignorej = [];
              $diff = array_diff($all_days, $day);

              // DO RANDOM I DAN J
              $rand  = mt_rand(0,count($sisa_bukit)-1);
              $randi = $sisa_bukit[$rand][0];
              $randj = $sisa_bukit[$rand][1];

              $count = 0;
              while(!in_array($randi, $diff)){
                $rand  = mt_rand(0,count($sisa_bukit)-1);
                $randi = $sisa_bukit[$rand][0];
                $randj = $sisa_bukit[$rand][1];
                $count++;

                if($count >= 10) break;
              }
              
              // $randi = mt_rand(min($diff),max($diff));
              // $randj = mt_rand(0,count($pop_bukit[0])-1);              

              // SWAP
              $temp = $pop_bukit[$i][$j];
              $pop_bukit[$i][$j] = $pop_bukit[$randi][$randj];
              $pop_bukit[$randi][$randj] = $temp;

              $this->pop_bukit = $pop_bukit;
              $this->calcFitness();
            }
          }
        }
      }
      $this->pop_bukit = $pop_bukit;
      $this->calcFitness();
    }
    public function mutation(){
      // CEK SELURUH INDERALAYA
      // LAKUKAN SWAP
      $ignore_layo = $this->param->ignore_layo;
      $pop_layo = $this->pop_layo;
      $mr = $this->param->mr;
      // PINDAH HARI DAN JAM BUKIT

      for ($i = 0; $i < count($pop_layo); $i++) {
        $list_dosen_hari = $this->get_list_dosen_hari($i,$pop_layo,'layo');
        for ($j = 0; $j < count($pop_layo[0]); $j++) {
          $random = mt_rand() / mt_getrandmax();
          if($random <= $mr){
            // DO MUTATION
            // $pop_layo[$i][$j]['fitness'] = 0;
            $list_dosen = $this->get_list_dosen_except($j,$pop_layo[$i]);
            $dosen1 = $pop_layo[$i][$j]['kromosom']['dosen1'];
            $dosen2 = $pop_layo[$i][$j]['kromosom']['dosen2'];

            // JIKA ADA DOSEN 1 ATAU DOSEN 2 YANG SAMA PADA JAM DAN HARI YANG SAMA
            if(in_array($dosen1, $list_dosen_hari) || in_array($dosen2, $list_dosen_hari)){
              // $pop_layo[$i][$j]['fitness'] = 0.2;
              $pop_layo[$i][$j]['fitness'] = 0;
            }
            else{
              // echo "$i $j FITNESS3<br>";
              $pop_layo[$i][$j]['fitness'] = 1;
            }
          }
        }
      }
      
    }
    public function cekFitness(){
      $pop_bukit = $this->pop_bukit;
      $pop_layo = $this->pop_layo;
      $flag = true;

      $this->calcFitness();
      for ($i = 0; $i < count($pop_bukit); $i++) {
        for ($j = 0; $j < count($pop_bukit[0]); $j++) {
          if($pop_bukit[$i][$j]['fitness'] !== 1){
            $flag = false;
            break;
          }
        }
      }
      for ($i = 0; $i < count($pop_layo); $i++) {
        for ($j = 0; $j < count($pop_layo[0]); $j++) {
          if($pop_layo[$i][$j]['fitness'] !== 1){
            $flag = false;
            break;
          }
        }
      }
      return $flag;
    }
  }
?>