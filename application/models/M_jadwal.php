<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include 'Algen.php';

class M_jadwal extends CI_Model {

  public function algen($param){
    $algen    = new Algen($param);
    $count    = 0;
    $kondisi  = false;

    while ($count < $param->maxGen && $kondisi === false) {
      $algen->crossover();
      // $algen->mutation();
      // $algen->crossover2();
      $kondisi = $algen->cekFitness();
      $count++;
    }
    // exit;
    $tabrakan_hari_jam  = 0;
    $tabrakan_hari      = 0;
    $tabrakan_jam       = 0;
    foreach ($algen->pop_bukit as $key => $value){
      foreach ($value as $key2 => $value2){
        if($value2['fitness'] == 0)
          $tabrakan_hari_jam++;
        if($value2['fitness'] == 0.25)
          $tabrakan_hari++;
        if($value2['fitness'] == 0.5)
          $tabrakan_jam++;
      } 
    }
    foreach ($algen->pop_layo as $key => $value){
      foreach ($value as $key2 => $value2){
        if($value2['fitness'] == 0)
          $tabrakan_hari_jam++;
        if($value2['fitness'] == 0.25)
          $tabrakan_hari++;
        if($value2['fitness'] == 0.5)
          $tabrakan_jam++;
      } 
    }
    $algen->tabrakan_hari_jam = $tabrakan_hari_jam;
    $algen->tabrakan_hari     = $tabrakan_hari;
    $algen->tabrakan_jam      = $tabrakan_jam;
    $algen->count             = $count;
    // echo "<pre>";
    // echo "TOTAL GENERASI: ".($count)."\n";
    // echo "TABRAKAN HARI JAM: ".($tabrakan_hari_jam)."\n";
    // echo "TABRAKAN HARI: ".($tabrakan_hari)."\n";
    // echo "TABRAKAN JAM: ".($tabrakan_jam)."\n";
    // print_r ($algen->pop_bukit);
    // print_r ($algen->pop_layo);
    // echo "</pre>";
    // exit;

    return $algen;
  }
}