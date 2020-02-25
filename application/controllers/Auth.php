<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct() //function construct untuk semua method didalam class tsb
    {
        parent::__construct();
        $this->load->library('form_validation'); //mengambil library form_validation
    }
    public function index()
    {
        //membuat rules form valid
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        //ketika form dijalankan atau di submitt
        if ($this->form_validation->run() == false) {

            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi sukses
            $this->_login(); //memanggil fungsi _login 
        }
    }


    private function _login()
    {
        //deklarasi variabel untuk mengambil data dari inputan di form
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //query 
        $user = $this->db->get_where('user', ['email' => $email])->row_array(); //SELECT *FROM where email==email , row_array:data seluruh sesuai email
        //var_dump($user);

        //jika usernya aktif
        if ($user) {
            if ($user['is_active'] == 1) {
                //menyamakan password yg di login form dengan yang di HASH
                if (password_verify($password, $user['password'])) {
                    //siapkan data untuk session 
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data); //buat session userdata
                    redirect('user');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Wrong Password. 
          </div>');
                }
            } else { //email blm aktif
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            This email has not been activated. 
          </div>');
            }
        } else { //email blm terdaftar
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered. 
          </div>');
        }
        redirect('auth');
    }
    public function registration()
    {
        //buat rule form validation
        $this->form_validation->set_rules('name', 'Name', 'required|trim'); //set_rules('name/index','alias','required/wajib|trim untuk spasi ga masuk db)
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This Email has already exist!'
        ]); //is_unique[table.field] dia ngecek sudah ada atau belum emailnya di db
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]); //set_rules('name/index','alias','required/wajib|trim untuk spasi ga masuk db)
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[3]|matches[password1]'); //set_rules('name/index','alias','required/wajib|trim untuk spasi ga masuk db)

        if ($this->form_validation->run() == false) { //ketika dijalankan / run

            $data['title'] = 'WPU Registration'; //untuk title regist
            $this->load->view('templates/auth_header', $data); //memanggil isi $data
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $data = [
                /*nama field table user 'name','email'*/
                'name' => htmlspecialchars($this->input->post('name', true)), //$this->input->post('nama name dr form bukan field db', true)
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT), //password_hash:buat enkripsi, PASSWORD_DEFAULT:algoritma yg digunakan untk encrypt
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()


            ];

            $this->db->insert('user', $data); //input ke database table user
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations! your account has been created. 
          </div>'); //membuat session
            redirect('auth');
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('email'); //menghapus session
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
       You have been logged out. 
      </div>'); //membuat session
        redirect('auth');
    }
}
