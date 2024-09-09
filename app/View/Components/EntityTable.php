<?php
namespace App\View\Components;

use Illuminate\View\Component;

class EntityTable extends Component
{
    public $entities;
    public $entityName;
    public $column1;
    public $column2;
    public $column3;
    public $field1;
    public $field2;
    public $field3;
    public $createRoute;
    public $editRoute;
    public $deleteRoute;

    public function __construct($entities, $entityName, $column1, $column2, $column3, $field1, $field2, $field3, $createRoute, $editRoute, $deleteRoute)
    {
        $this->entities = $entities;
        $this->entityName = $entityName;
        $this->column1 = $column1;
        $this->column2 = $column2;
        $this->column3 = $column3;
        $this->field1 = $field1;
        $this->field2 = $field2;
        $this->field3 = $field3;
        $this->createRoute = $createRoute;
        $this->editRoute = $editRoute;
        $this->deleteRoute = $deleteRoute;
    }

    public function render()
    {
        return view('components.entity-table');
    }
}