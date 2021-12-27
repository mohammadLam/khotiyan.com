<?php 
	ob_start();
	include 'lib/session.php';
	include_once 'lib/Database.php';
	include_once 'helpers/format.php';

class adminlogin{

	private $db;
	private $fm;
	public function __construct(){
		$this->db = new Database();
		$this->fm = new format();
	}

	public function adminlogin($username, $password, $remember){

		$username = $this->fm->validation($username);
		$password = $this->fm->validation($password);
		$remember = $this->fm->validation($remember);

		$username = mysqli_real_escape_string($this->db->link, $username);
		$password = mysqli_real_escape_string($this->db->link, $password);



		if (empty($username) || empty($password)) {
			$loginmsg = "সবগুলো ঘর পূরণ করুন";
			return $loginmsg;

		}else{
			$sql = "SELECT * FROM table_user WHERE (username = '$username' OR email = '$username') AND password = '$password'";
			$run = $this->db->select($sql);

			if($run){
				$result = $run->fetch_assoc();
				$status = $result['status'];

				if($status == 0){
					$loginmsg = "আপনার অ্যাকাউন্টটি অ্যাডমিনের অ্যাপ্রুভের অপেক্ষায় আছে";
					return $loginmsg;
				}elseif ($run != false && $remember == 1) {
					setcookie('adminlogin', 'b326b5062b2f0e69046810717534cb09', time()+(86400*15), "/"); // this is hash value. This means true
					setcookie('userid', md5($result['id']), time()+(86400*15), "/");
					setcookie('role', md5($result['role']), time()+(86400*15), "/");
					echo "<script>window.location = 'index.php';</script>";
				}else{
					setcookie('adminlogin', 'b326b5062b2f0e69046810717534cb09'); // this is hash value. This means true
					setcookie('userid', md5($result['id']));
					setcookie('role', md5($result['role']));
					echo "<script>window.location = 'index.php';</script>";
				}
			}else{
				$loginmsg = "আপনার দেওয়া তথ্যগুলো সঠিক নয়";
				return $loginmsg;
			}

		}

	}

}