<?php 
ini_set('display_errors', 1);
error_reporting(-1);
// kelas Koneksi DATABASE
class database {
	//properti yang dibuthkan
	private $dbhost;
	private $dbuser;
	private $dbpass;
	private $dbname;
	//construc
	function __construct($a, $b, $c, $d){
		$this->dbhost = $a;
		$this->dbuser = $b;
		$this->dbpass = $c;
		$this->dbname = $d;
	}
	//method koneksi mysql db
	function conn_mysql(){
		$konek_db = mysqli_connect($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);
		return  $konek_db;
	}

}


class penduduk{
    // Properties
	public $nama;
	public $nik;
	public $alamat;
    public $jenis;
	public $umur;

    //Method setting propertis
    function set_all_data ($nama,$nik,$alamat,$jenis,$umur){
		$this->nama = $nama;
		$this->nik = $nik;
		$this->alamat = $alamat;
        $this->jenis = $jenis;
        $this->umur = $umur;
	}

    //Method ambil data propertis
	function get_nama() {
		return $this->nama;
	}

    function get_nik() {
		return $this->nik;
	}

    function get_alamat() {
		return $this->alamat;
	}

    function get_jenis() {
		return $this->jenis;
	}

    function get_umur() {
		return $this->umur;
	}
    
    // tipe dibawah 5 -> balita , 5-15 --> anak , 16-25 --> Remaja, 26 - 50 --> Dewasa, 50 > Tua
    function klasifikasi(){
		if ($this->umur < 5){
			$klasifikasinya = "Balita";
		} else if ($this->umur >= 5 and $this->umur < 15){
			$klasifikasinya = "Kanak-Kanak";
		} else if ($this->umur >= 16 and $this->umur < 25){
			$klasifikasinya = "Remaja";
		} else if ($this->umur >= 26 and $this->umur < 50){
            $klasifikasinya = "Dewasa";
        } else {
            $klasifikasinya = "Tua";
        }
		//echo $klasifikasinya;
	  }

    	// Tambah Penduduk
	function tambahpenduduk ($koneksi,$nama,$nik,$alamat,$jenis,$umur,$klasifikasi){

        $tambahdata = "INSERT INTO tbl_penduduk (nama,nik,alamat,kelamin,umur,klasifikasi) VALUES ('$nama','$nik','$alamat','$jenis','$umur','$klasifikasi')";
		$proses_tambah =mysqli_query($koneksi, $tambahdata);
		//if ($proses_tambah) echo "Data Berhasil Ditambah";
		//else echo "Data Gagal Ditambah";
	}

    function ambildata_penduduk ($koneksi){
        $data_penduduk = "select * from tbl_penduduk";
        $proses_ambil =mysqli_query($koneksi, $data_penduduk);
        return  $proses_ambil;
    }

    function hapus_data ($koneksi, $id){
      $hapus = "DELETE FROM tbl_penduduk WHERE id_penduduk = '$id'";
      $proses_hapus = mysqli_query($koneksi,$hapus);
      return "Berhasil";
    }
}
// Koneksi
// Konfigurasi DB
      // Parameter Data MYSQL
      $host = '127.0.0.1';
      $user = 'root';
      $pass = '';
      $db = 'backend';
      // Instantitasi dan setting obyek
      $db = new database($host,$user,$pass,$db);
      // Koneksi DB
      $koneksi = $db->conn_mysql();

 // Post Data
 if (isset($_POST['submit']) ){
      
  if ($_POST['nama'] != '' and $_POST['nik'] != '' and $_POST['alamat'] != ''  and $_POST['jenis'] != ''  and $_POST['umur'] != ''){
    $post_nama = $_POST['nama'];
    $post_nik = $_POST['nik'];
    $post_alamat = $_POST['alamat'];
    $post_jenis = $_POST['jenis'];
    $post_umur = $_POST['umur'];
    

    $penduduk_post = new penduduk();
    $klasifikasi = $penduduk_post->klasifikasi();
    $penduduk_post->tambahpenduduk($koneksi,$post_nama,$post_nik,$post_alamat,$post_jenis,$post_umur,$penduduk_post->klasifikasi());


    $data_penduduk_db = $penduduk_post->ambildata_penduduk($koneksi);

   } 
  
  }

  if (isset($_POST['Hapus'])){
    if ($_POST['id'] != ''){
      $penduduk_hapus = new penduduk();
      $hapus_data = $penduduk_hapus->hapus_data($koneksi,$_POST['id']);
     
      $data_penduduk_db = $penduduk_hapus->ambildata_penduduk($koneksi);
      
     }

  }


?>