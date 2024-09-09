<?php
namespace App\View\Components;

use Illuminate\View\Component;

class CreateFormComponent extends Component
{
    public $entity;
    public $action;
    public $fields;
    public $actionName;
    public $imageUploader;
    public $resetButton;
    public $actionType;

    public function __construct($entity, $action, $fields, $actionName, $imageUploader=false, $resetButton=false, $actionType )
    {
        $this->entity = $entity;
        $this->action = $action;
        $this->fields = $fields;
        $this->actionName = $actionName;
        $this->imageUploader = $imageUploader;
        $this->resetButton = $resetButton;
        $this->actionType = $actionType;
    }

    public function render()
    {
        return view('components.create-form-component');
    }
}