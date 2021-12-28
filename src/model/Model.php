<?php

    namespace App\src\model;

  use App\config\Session;
  use App\src\constraint\Validation;
  use App\config\Request;

  abstract  class Model
    {
      protected Validation $validation;
      protected  Session $session;
      private Request $request;

      public function  __construct()
      {
          $this->validation = new Validation();
          $this->request = new Request();
          $this->session = $this->request->getSession();
      }
    }