<?php
$this->load->view('/layout/header', ['title' => $title]);
$this->load->view('/layout/sidebar');
$this->load->view('/layout/navbar');
$this->load->view('/' . $content);
$this->load->view('/layout/footer');
