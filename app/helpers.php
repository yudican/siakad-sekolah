<?php

// define permissions

use App\Models\DataJawabaEssay;
use App\Models\DataJawabanUjian;

if (!function_exists('permissionLists')) {
  function permissionLists()
  {
    $permissions = [
      'create' => 'Create',
      // 'read' => 'Read',
      'update' => 'Update',
      'delete' => 'Delete',
    ];
    return $permissions;
  }
}

if (!function_exists('statusPengumpulan')) {
  function statusPengumpulan($status = 0)
  {
    switch ($status) {
      case '1':
        return 'Sudah Dinilai';
      case '2':
        return 'Belum Dinilai';
      case '3':
        return 'Tidak Mengumpulkan';
      default:
        return 'Belum Mengumpulkan';
    }
  }
}

// get day name
if (!function_exists('namaHari')) {
  function namaHari($hari = 1)
  {
    switch ($hari) {
      case '1':
        return 'Senin';
      case '2':
        return 'Selasa';
      case '3':
        return 'Rabu';
      case '4':
        return 'Kamis';
      case '5':
        return 'Jumat';
      case '6':
        return 'Sabtu';
      default:
        return 'Minggu';
    }
  }
}

// get day name
if (!function_exists('isAnswered')) {
  function isAnswered($soal_id, $ujian_id, $type_soal = 'pg')
  {
    $jawaban = DataJawabanUjian::where('data_soal_ujian_id', $soal_id)->where('data_ujian_id', $ujian_id)->where('siswa_id', auth()->user()->siswa->id)->first();
    if ($type_soal == 'essay') {
      $jawaban = DataJawabaEssay::where('data_soal_ujian_id', $soal_id)->where('data_ujian_id', $ujian_id)->where('data_siswa_id', auth()->user()->siswa->id)->first();
    }

    if ($jawaban) {
      return true;
    }
    return false;
  }
}
// get day name
if (!function_exists('convertTime')) {
  function convertTime($iSeconds)
  {
    $min = intval($iSeconds / 60);
    return $min . ':' . str_pad(($iSeconds % 60), 2, '0', STR_PAD_LEFT);
  }
}


// get day name
if (!function_exists('getJawaban')) {
  function getJawaban($soal_id)
  {
    $jawaban = DataJawabanUjian::where('data_soal_ujian_id', $soal_id)->first();
    if ($jawaban) {
      return $jawaban->jawaban;
    }
    return '';
  }
}
