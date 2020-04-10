<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
        if (!$this->session->userdata('email')) {
            redirect('auth');
        } else if ($this->session->userdata('role_id') == 2) {
            redirect('auth/goToDefaultPage');
        }
    }
    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['users'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('menu/index');
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    New Menu added!. 
                  </div>');
            redirect('menu');
        }
    }

    public function delete($id)
    {
        $this->db->delete('user_menu', array('id' => $id));
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Menu has deleted!. 
                  </div>');
        redirect('menu');
    }

    public function edit($id)
    {
        //$menu = $this->input->get('menu');
        $get = $this->input->get();
        $this->id = $get['id'];
        $this->menu = $get['menu'];
        $this->db->update('user_menu', $this, array('id' => $id));
        $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">
                    Menu has Edited!. 
                  </div>');
        redirect('menu');
    }


    public function submenu()
    {
        $data['title'] = 'Submenu Management';
        $data['users'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->load->model('Menu_model', 'menu'); //load ke model (nama model, alias)
        $data['submenu'] = $this->menu->getSubMenu();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'menu', 'required');
        $this->form_validation->set_rules('url', 'url', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar');
            $this->load->view('templates/topbar');
            $this->load->view('menu/submenu');
            $this->load->view('templates/footer');
        } else {

            $post = $this->input->post();
            $this->title = $post['title'];
            $this->menu_id = $post['menu_id'];
            $this->url = $post['url'];
            $this->icon = $post['icon'];
            $this->is_active = $post['is_active'];

            $this->db->insert('user_sub_menu', $this);
            $this->session->set_flashdata('message', '<div class="alert alert-primary" role="alert">
                    Sub Menu has Added!. 
                  </div>');
            redirect('menu/submenu');
        }
    }
}
