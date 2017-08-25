<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(!session_id()) session_start();

class Model extends CI_Model 
{
    function __construct()
    {
        parent::__construct();  
    }

     function getDataPeminjaman($nomor=''){
        if ($nomor=='') {
            $kondisi = 'WHERE a.nomor=b.nomor AND b.ruang=kd_ruang AND flag=1 AND flag_ppaa = 1';
        } else {
            $kondisi = "WHERE a.nomor=b.nomor AND b.ruang=kd_ruang AND flag=1 AND flag_ppaa = 1 AND a.nomor = '$nomor'";
        }   
        $data = array();
        $sql = "SELECT a.*, event_id as id, start_date, end_date, 
                        TIMESTAMPDIFF(minute, start_date, end_date) as lama, 
                        CONCAT(event_name, ' ', prodi, ' ', jml_peserta) as html, b.ruang as ruang, kd_ruang, nm_ruang,
                        (CASE
                            WHEN DAYNAME(start_date) = 'Sunday' THEN 'Minggu'
                            WHEN DAYNAME(start_date) = 'Monday' THEN 'Senin'
                            WHEN DAYNAME(start_date) = 'Tuesday' THEN 'Selasa'
                            WHEN DAYNAME(start_date) = 'Wednesday' THEN 'Rabu'
                            WHEN DAYNAME(start_date) = 'Thursday' THEN 'Kamis'
                            WHEN DAYNAME(start_date) = 'Friday' THEN 'Jumat'
                            WHEN DAYNAME(start_date) = 'Saturday' THEN 'Sabtu'
                        END) as hari,
                        (CASE
                            WHEN DAYNAME(tgl_permohonan) = 'Sunday' THEN 'Minggu'
                            WHEN DAYNAME(tgl_permohonan) = 'Monday' THEN 'Senin'
                            WHEN DAYNAME(tgl_permohonan) = 'Tuesday' THEN 'Selasa'
                            WHEN DAYNAME(tgl_permohonan) = 'Wednesday' THEN 'Rabu'
                            WHEN DAYNAME(tgl_permohonan) = 'Thursday' THEN 'Kamis'
                            WHEN DAYNAME(tgl_permohonan) = 'Friday' THEN 'Jumat'
                            WHEN DAYNAME(tgl_permohonan) = 'Saturday' THEN 'Sabtu'
                        END) as hari_permohonan,
                        DAY(tgl_permohonan) as day_permohonan, MONTH(tgl_permohonan) as bulan_permohonan, YEAR(tgl_permohonan) as tahun_permohonan,
                        DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, DATE(start_date) as tgl_kegiatan, nama_peminjam, no_telp, email,
                        TIME_FORMAT(start_date, '%h:%i') as start_time, TIME_FORMAT(end_date, '%h:%i') as end_time,
                        TIME_FORMAT(start_date, '%h') as jam_mulai, TIME_FORMAT(start_date, '%i') as menit_mulai,
                        TIME_FORMAT(end_date, '%h') as jam_selesai, TIME_FORMAT(end_date, '%i') as menit_selesai
                FROM kegiatan a, waktu b, ruang_rapat c
                WHERE a.nomor=b.nomor AND b.ruang=kd_ruang AND flag=1 AND flag_ppaa = 1
                ORDER BY tgl_kegiatan desc";

        $result = mysql_query($sql) or die(mysql_error());

        while($rows = mysql_fetch_object($result)){
            $data[] = $rows;
        }
        return $data;
    }

    function getDataFormEdit($nomor){
        $sql = "SELECT a.*, b.event_id as event_id, start_date, end_date,  a.nomor as nomor,
                        TIMESTAMPDIFF(minute, start_date, end_date) as lama, 
                        CONCAT(event_name, ' ', prodi, ' ', jml_peserta) as html, b.ruang as ruang, kd_ruang, nm_ruang,
                        (CASE
                            WHEN DAYNAME(start_date) = 'Sunday' THEN 'Minggu'
                            WHEN DAYNAME(start_date) = 'Monday' THEN 'Senin'
                            WHEN DAYNAME(start_date) = 'Tuesday' THEN 'Selasa'
                            WHEN DAYNAME(start_date) = 'Wednesday' THEN 'Rabu'
                            WHEN DAYNAME(start_date) = 'Thursday' THEN 'Kamis'
                            WHEN DAYNAME(start_date) = 'Friday' THEN 'Jumat'
                            WHEN DAYNAME(start_date) = 'Saturday' THEN 'Sabtu'
                        END) as hari,
                        (CASE
                            WHEN DAYNAME(tgl_permohonan) = 'Sunday' THEN 'Minggu'
                            WHEN DAYNAME(tgl_permohonan) = 'Monday' THEN 'Senin'
                            WHEN DAYNAME(tgl_permohonan) = 'Tuesday' THEN 'Selasa'
                            WHEN DAYNAME(tgl_permohonan) = 'Wednesday' THEN 'Rabu'
                            WHEN DAYNAME(tgl_permohonan) = 'Thursday' THEN 'Kamis'
                            WHEN DAYNAME(tgl_permohonan) = 'Friday' THEN 'Jumat'
                            WHEN DAYNAME(tgl_permohonan) = 'Saturday' THEN 'Sabtu'
                        END) as hari_permohonan,
                        DAY(tgl_permohonan) as day_permohonan, MONTH(tgl_permohonan) as bulan_permohonan, YEAR(tgl_permohonan) as tahun_permohonan,
                        DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun, DATE(start_date) as tgl_kegiatan, nama_peminjam, no_telp, email,
                        TIME_FORMAT(start_date, '%h:%i') as start_time, TIME_FORMAT(end_date, '%h:%i') as end_time,
                        TIME_FORMAT(start_date, '%h') as jam_mulai, TIME_FORMAT(start_date, '%i') as menit_mulai,
                        TIME_FORMAT(end_date, '%h') as jam_selesai, TIME_FORMAT(end_date, '%i') as menit_selesai
                FROM kegiatan a, waktu b, ruang_rapat c
                WHERE a.nomor=b.nomor AND b.ruang=kd_ruang AND flag=1 AND flag_ppaa = 1 AND a.nomor = '$nomor'";
        $result = mysql_query($sql) or die(mysql_error());
        while($rows = mysql_fetch_object($result)){
            $data[] = $rows;
        }
        return $data;
    }

    function jadwalBentrok($event_id, $start_date, $end_date, $ruang)   //event_id supaya tidak memeriksa dirinya sendiri
    {
        $this->db->select('*, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun');
        $this->db->from('kegiatan a, waktu b, ruang_rapat c');
        $this->db->where("end_date >= '$start_date' AND start_date <= '$end_date' AND b.ruang = '$ruang' AND event_id <> '$event_id' AND b.ruang = kd_ruang AND a.nomor = b.nomor");
        $data = $this->db->get()->result();
        return $data;
    }

    function cekJadwalBentrok($start_date, $end_date, $ruang)  //cek jadwal bentrok pada saat add row jadwal
    {
        $this->db->select('*, DAY(start_date) as tgl, MONTH(start_date) as bulan, YEAR(start_date) as tahun');
        $this->db->from('kegiatan a, waktu b, ruang_rapat c');
        $this->db->where("end_date >= '$start_date' AND start_date <= '$end_date' AND b.ruang = '$ruang' AND b.ruang = kd_ruang AND a.nomor = b.nomor");
        $data = $this->db->get()->result();
        return $data;
    }

    function getRuang()
    {
        $sql = "SELECT * FROM ruang_rapat WHERE kd_ruang in (208, 210)
                UNION
                SELECT * FROM ruang_rapat WHERE kd_ruang < 80";
        $result = mysql_query($sql);
        $data = array();
        while($rows = mysql_fetch_object($result)){
            $data[] = $rows;
        }
        return $data;
    }

    function insertKegiatan($data){
        $this->db->insert('kegiatan', $data);
        //echo 'data kegiatan sudah disimpan';
    }

    function insertJadwal($data){
        $this->db->insert('waktu', $data);     
    }
 
    function editKegiatan($data, $nomor){
        $this->db->where('nomor', $nomor);
        $this->db->update('kegiatan', $data);
    }

    function editJadwal($data, $nomor){
        $this->db->where('nomor', $nomor);
        $this->db->update('waktu', $data); 
    }

    function deleteData($nomor){
        $this->db->where('nomor', $nomor);
        $this->db->delete('kegiatan');
        $this->db->where('nomor', $nomor);
        $this->db->delete('waktu');
    }

    function getTanggalKuliah($thsmt){
        $this->db->select('*');
        $this->db->from('term_kuliah');
        $this->db->where("term = '$thsmt'");
        $data = $this->db->get()->result();
        return $data;
    }
}
