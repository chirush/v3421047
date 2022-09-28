<?php
	class database {
		private $dbhost;
		private $dbuser;
		private $dbpass;
		private $dbname;
		function __construct($a, $b, $c, $d){
			$this->dbhost = $a;
			$this->dbuser = $b;
			$this->dbpass = $c;
			$this->dbname = $d;
		}

	function conn_mysql(){
		$konek_db = mysqli_connect($this->dbhost,$this->dbuser,$this->dbpass,$this->dbname);
		return  $konek_db;
	}
}

		class penduduk{
			public $nik;
			public $nama;
			public $jk;
			public $alamat;
			public $umur;

		function set_all($set_nik, $set_nama, $set_jk, $set_alamat, $set_umur){
			$this->nik = $set_nik;
			$this->nama = $set_nama;
			$this->jk = $set_jk;
			$this->alamat = $set_alamat;
			$this->umur = $set_umur;
		}

		function get_nik(){
			return $this->nik;
		}
		function get_nama(){
			return $this->nama;
		}
		function get_jk(){
			return $this->jk;
		}
		function get_alamat(){
			return $this->alamat;
		}
		function get_umur(){
			return $this->umur;
		}

			
		function tambahpenduduk($koneksi, $nik, $nama, $jk, $alamat, $umur, $kriteria){
			$sql = mysqli_query($koneksi, "INSERT into penduduk (nik, nama, jk, alamat, umur, kriteria) values ('$nik', '$nama', '$jk', '$alamat', '$umur', '$kriteria');");
			if($sql){
						?>
					<script type="text/javascript">
						
						alert ("Data Berhasil Ditambah")
						window.location.href="penduduk.php";

					</script><?php	
			}
		}

		function updatependuduk($koneksi, $id, $nik, $nama, $jk, $alamat, $umur, $kriteria){
			$sql = mysqli_query($koneksi, "UPDATE penduduk set nik='$nik', nama='$nama', jk='$jk', alamat='$alamat', umur='$umur', kriteria='$kriteria' where id='$id'");
			if($sql){
						?>
					<script type="text/javascript">
						
						alert ("Update Data Berhasil")
						window.location.href="penduduk.php";

					</script><?php	
			}
		}

		function hapuspenduduk($koneksi, $id){
			$sql = mysqli_query($koneksi, "DELETE from penduduk where id = '$id'");
			if($sql){
						?>
					<script type="text/javascript">
						
						alert ("Data Berhasil Dihapus")
						window.location.href="penduduk.php";

					</script><?php	
			}
		}
	}




      $host = '127.0.0.1';
      $user = 'root';
      $pass = '';
      $db = 'bps';
      $db = new database($host,$user,$pass,$db);
      $koneksi = $db->conn_mysql();


	if (isset($_POST['submit'])){
		  if ($_POST['nik'] != '' and $_POST['nama'] != '' and $_POST['jk'] != ''  and $_POST['alamat'] != ''  and $_POST['umur'] != ''){
		    $post_nik = $_POST['nik'];
		    $post_nama = $_POST['nama'];
		    $post_jk = $_POST['jk'];
		    $post_alamat = $_POST['alamat'];
		    $post_umur = $_POST['umur'];

		$tes = new penduduk;

      	if ($post_umur <= 5){
		$kriteria = "Balita";
		}else if($post_umur <= 15){
			$kriteria = "Anak-Anak";
		}else if($post_umur <= 25){
			$kriteria = "Remaja";
		}else if($post_umur <= 50){
			$kriteria = "Dewasa";
		}else{
			$kriteria = "Tua";
		}

		$tes->tambahpenduduk($koneksi, $post_nik, $post_nama, $post_jk, $post_alamat, $post_umur, $kriteria);
	}
}

        function tampildata($koneksi){
        $tampil = mysqli_query($koneksi, "select * from penduduk");

        while($d = mysqli_fetch_array($tampil)){
	      ?>
	      <td><?= $d["nik"] ?></td>
	      <td><?= $d["nama"] ?></td>
	      <td><?= $d["jk"] ?></td>
	      <td><?= $d["alamat"] ?></td>
	      <td><?= $d["kawin"] ?></td>
	      <td><?= $d["pekerjaan"] ?></td>
	      <td><?= $d["kewarganegaraan"] ?></td>
	      <td><?= $d["tempatlahir"] ?></td>
	      <td><?= $d["tgllahir"] ?></td>
	      <td><?= $d["umur"] ?></td>
	      <td><?= $d["golongandarah"] ?></td>
	      <td><?= $d["kriteria"] ?></td>
	      <td>
        	<form method="post" action="function.php">
		  	<a class="btn btn-primary btnset2" href="edit.php?id=<?= $d["id"] ?>">Edit</a>
        	<input type="hidden" name="id" value="<?= $d["id"] ?>">
		  	<input type="submit" name="delete" class="btn btn-danger" value="Delete" onclick = "return confirm('Hapus Data ?')">
		  </td>
		  	</form>
	    </tr>
	      <?php
	       }}


	if (isset($_POST['delete'])){
		    $post_id = $_POST['id'];

		$hapus = new penduduk;
		$hapus->hapuspenduduk($koneksi, $post_id);
	}

	if (isset($_POST['update'])){
		    $post_id = $_POST['id'];		    
		    $post_nik = $_POST['nik'];
		    $post_nama = $_POST['nama'];
		    $post_jk = $_POST['jk'];
		    $post_alamat = $_POST['alamat'];
		    $post_umur = $_POST['umur'];

		$update = new penduduk;

		if ($post_umur <= 5){
		$kriteria = "Balita";
		}else if($post_umur <= 15){
			$kriteria = "Anak-Anak";
		}else if($post_umur <= 25){
			$kriteria = "Remaja";
		}else if($post_umur <= 50){
			$kriteria = "Dewasa";
		}else{
			$kriteria = "Tua";
		}

		$update->updatependuduk($koneksi, $post_id, $post_nik, $post_nama, $post_jk, $post_alamat, $post_umur, $kriteria);
	}
?>