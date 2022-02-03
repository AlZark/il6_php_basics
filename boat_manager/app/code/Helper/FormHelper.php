<?php

namespace Helper;
class FormHelper
{
    private $form;

    public function __construct($action, $method)
    {
        $this->form = '<form action="'. BASE_URL . $action . '" method="' . $method . '">';
    }

    public function input($data)
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . '="' . $value . '" ';
        }
        $this->form .= '><br>';
    }

    public function select($data, $table)
    {
        $this->form .= '<select name='.$table.'>';
        foreach ($data as $key => $value){
            $this->form .= '<option value='.$key.'>'.$value.'</option>';
        }
        $this->form .= '</select></br>';
    }

    public function submit($value, $name)
    {
        $this->form .= '<input type="submit" value="' . $value . '" name="' . $name . '">';
    }

    public function getForm()
    {
        $this->form .= '</form>';
        return $this->form;
    }
}