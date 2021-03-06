<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

$data_user = [
  [
    'nik' => '619008',
    'nama' => 'Viery Darmawan',
  ],
  [
    'nik' => '619010',
    'nama' => 'Sulis',
  ],
  [
    'nik' => '619009',
    'nama' => 'Ade',
  ],
];

$data_karyawan = [
  [
    'nik' => '619008',
    'nama' => 'Viery Darmawan',
    'alamat' => 'Perum. Muka Kuning Permai II No. 220 RT/RW: 006/020, Kel. Buliang, Kec. Batu Aji - Batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Malang',
    'tanggal_lahir' => '1997-12-13',
    'no_ktp' => '999999999999',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'IT',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619009',
    'nama' => 'Sulis 1',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'HR',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619001',
    'nama' => 'Sulis 2',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'PPC',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619002',
    'nama' => 'Sulis 3',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'HR',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619003',
    'nama' => 'Sulis 4',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'HR',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619004',
    'nama' => 'Sulis 5',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'HR',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619005',
    'nama' => 'Sulis 6',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'PPC',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619006',
    'nama' => 'Sulis 7',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'PPC',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619007',
    'nama' => 'Sulis 8',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'IT',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ],
  [
    'nik' => '619010',
    'nama' => 'Sulis 9',
    'alamat' => 'batam',
    'jabatan' => 'Manager',
    'jenis_kelamin' => 'Laki-laki',
    'tempat_lahir' => 'Batam',
    'tanggal_lahir' => '30 Februari 1998',
    'no_ktp' => '8888888888888',
    'tanggal_bergabung' => '2019-01-10',
    'department' => 'IT',
    'title' => 'Yard Attendant',
    'grade' => '8 (bc)',
    'cc' => 'P05101',
    'gaji_pokok' => '100.000.000',
    'tunjangan_transport' => '30.000',
    'tunjangan_makan' => '20.000',
    'status_keluarga' => 'Menikah',
    'status_gol_gaji' => 'Staff',
    'tanggungan_keluarga' => '1',
    'status_pajak' => 'TK0'
  ]
];
// $dt = DATA_NIK;

defined('DATA_NIK')      OR define('DATA_NIK', $data_karyawan);
defined('DATA_USER')      OR define('DATA_USER', $data_user);
