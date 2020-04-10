<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
<<<<<<< HEAD
    public function __construct() //function construct untuk semua method didalam class tsb
    {
        parent::__construct();
        $this->load->library('form_validation'); //mengambil library form_validation
    }
    public function index()
    {
=======
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('role_id') == 1) {
            redirect('admin');
        } else if ($this->session->userdata('role_id') == 2) {
            redirect('user');
        } else {
            // jika ada role_id yg lain maka tambahkan disini
        }
>>>>>>> menambahkan fitur user activation dan change password
        //membuat rules form valid
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

<<<<<<< HEAD
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
=======

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login.php');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi sukses
            $this->_login();
        }
    }
    public function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //query
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            if ($user['is_active'] == 1) {

                if (password_verify($password, $user['password'])) {

>>>>>>> menambahkan fitur user activation dan change password
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
<<<<<<< HEAD
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
=======
                    $this->session->set_userdata($data);

                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user'); //controler user
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Wrong Password. 
                  </div>');
                }
            }

            //email blm aktif
            else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                This email has been not active. 
              </div>');
            }
        }

        //email blm terdaftar
        else {
>>>>>>> menambahkan fitur user activation dan change password
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Email is not registered. 
          </div>');
        }
        redirect('auth');
    }
<<<<<<< HEAD
    public function registration()
    {
=======

    public function registration()
    {
        if ($this->session->userdata('role_id') == 1) {
            redirect('admin');
        } else if ($this->session->userdata('role_id') == 2) {
            redirect('user');
        } else {
            // jika ada role_id yg lain maka tambahkan disini
        }

>>>>>>> menambahkan fitur user activation dan change password
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
<<<<<<< HEAD
                'is_active' => 1,
=======
                'is_active' => 0,
>>>>>>> menambahkan fitur user activation dan change password
                'date_created' => time()


            ];

<<<<<<< HEAD
            $this->db->insert('user', $data); //input ke database table user
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations! your account has been created. 
=======
            //siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $this->input->post('email', true),
                'token' => $token,
                'date_created' => time()
            ];


            $this->db->insert('user', $data); //input ke database table user
            $this->db->insert('user_token', $user_token); //input ke database table user

            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Congratulations! your account has been created. Please activate your account! 
>>>>>>> menambahkan fitur user activation dan change password
          </div>'); //membuat session
            redirect('auth');
        }
    }

<<<<<<< HEAD
=======
    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'newxhakaboom@gmail.com',
            'smtp_pass' => 'alkatheo',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('newxhakaboom@gmail.com', 'Xhaka Boom');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link you account: <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            // var_dump($user_token);
            // die;
            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Email has been activated. Please login. 
      </div>'); //membuat session
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
       Account activation failed! token expired. 
      </div>'); //membuat session
                    redirect('auth');
                }
            } else {

                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
       Account activation failed! wrong token. 
      </div>'); //membuat session
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
       Account activation failed! wrong email. 
      </div>'); //membuat session
            redirect('auth');
        }
    }
>>>>>>> menambahkan fitur user activation dan change password

    public function logout()
    {
        $this->session->unset_userdata('email'); //menghapus session
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
       You have been logged out. 
      </div>'); //membuat session
        redirect('auth');
    }
<<<<<<< HEAD
=======

    public function goToDefaultPage()
    {
        if ($this->session->userdata('role_id') == 1) {
            redirect('admin');
        } else if ($this->session->userdata('role_id') == 2) {
            redirect('user');
        } else {
            // jika ada role_id yg lain maka tambahkan disini
        }
    }
>>>>>>> menambahkan fitur user activation dan change password
}
