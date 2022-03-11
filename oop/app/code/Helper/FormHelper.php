<?php

declare(strict_types=1);

namespace Helper;

class FormHelper
{
    private string $form;

    public function __construct(string $action, string $method)
    {
        $this->form = '<form action="' . BASE_URL . $action . '" method="' . $method . '">';
    }

    public function input(array $data): void
    {
        $this->form .= '<input ';
        foreach ($data as $attribute => $value) {
            $this->form .= $attribute . '="' . $value . '" ';
        }
        $this->form .= '><br>';
    }

    public function textArea(string $name, string $value = ""): void
    {
        $this->form .= '<textarea name="' . $name . '">'. $value .'</textarea><br>';
    }

    public function label(string $value = ""): void
    {
        $this->form .= '<label>'. $value .'</label>';
    }

    public function select(array $data): void
    {
        $this->form .= '<select name="' . $data['name'] . '">';
        foreach ($data['options'] as $key => $option) {
            $this->form .= '<option';
            if (isset($data['selected'])) {
                if ($data['selected'] == $key) {
                    $this->form .= ' selected ';
                }
            }
            $this->form .= ' value="' . $key . '">' . $option . '</option>';
        }
        $this->form .= '</select><br>';
    }

    public function submit(string $value, string $name): void
    {
        $this->form .= '<input type="submit" value="' . $value . '" name="' . $name . '">';
    }

    public function getForm(): string
    {
        $this->form .= '</form>';
        return $this->form;
    }
}