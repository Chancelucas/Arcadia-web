<?php

namespace Lib\config;

class Form
{
  private $formCode = '';

  //create
  public function create()
  {
    return $this->formCode;
  }

  //validate
  public static function validate(array $form, array $fields)
  {
    foreach ($fields as $field) {
      if (!isset($form[$field]) || empty($form[$field])) {
        return false;
      }
    }
    return true;
  }

  //addParams
  private function addParams(array $params): string
  {
    $str = '';
    $short = ['checked', 'disabled', 'readonly', 'multiple', 'required', 'autofocus', 'novalidate', 'formnovalidate'];
    foreach ($params as $param => $value) {
      if (in_array($param, $short) && $value == true) {
        $str .= " $param";
      } else {
        $str .= " $param='$value'";
      }
    }
    return $str;
  }

  //startForm
  public function startForm(string $methode = 'POST', string $action = '', array $params = []): self
  {
    $this->formCode .= "<form action='$action' method='$methode'";
    $this->formCode .= $params ? $this->addParams($params) . '>' : '>';
    return $this;
  }

  //endForm
  public function endForm(): self
  {
    $this->formCode .= '</form>';
    return $this;
  }

  //addLabelFor
  public function addLabelFor(string $for, string $texte, array $params = []): self
  {
    $this->formCode .= "<label for='$for'";
    $this->formCode .= $params ? $this->addParams($params) : '';
    $this->formCode .= ">$texte</label>";
    return $this;
  }

  //addInput
  public function addInput(string $type, string $name, array $params = []): self
  {
    $this->formCode .= "<input type='$type' name='$name'";
    $this->formCode .= $params ? $this->addParams($params) . '>' : '>';
    return $this;
  }

  //addTextarea
  public function addTextarea(string $name, ?string $value = '', array $params = []): self
  {
    $this->formCode .= "<textarea name='$name'";
    $this->formCode .= $params ? $this->addParams($params) : '';
    $this->formCode .= ">$value</textarea>";
    return $this;
  }

  //addSelect
  public function addSelect(string $name, array $options, array $params = []): self
  {
    $this->formCode .= "<select name='$name'";
    $this->formCode .= $params ? $this->addParams($params) . '>' : '>';
    foreach ($options as $value => $texte) {
      if (isset($params['value']) && $params['value'] == $value) {
        $this->formCode .= "<option selected value='$value'>$texte</option>";
      } else {
        $this->formCode .= "<option value='$value'>$texte</option>";
      }
    }
    $this->formCode .= '</select>';
    return $this;
  }

  //addButon
  public function addBouton(string $texte, array $params = []): self
  {
    $this->formCode .= '<button ';
    $this->formCode .= $params ? $this->addParams($params) : '';
    $this->formCode .= ">$texte</button>";
    return $this;
  }

  //startDiv
  public function startDiv(array $params): self
  {

    $this->formCode .= "<div ";
    $this->formCode .= $params ? $this->addParams($params) . '>' : '>';
    return $this;
  }

  //endDiv
  public function endDiv(): self
  {
    $this->formCode .= '</div>';
    return $this;
  }
}
