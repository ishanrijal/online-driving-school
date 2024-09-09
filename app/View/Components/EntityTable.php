<?php
namespace App\View\Components;

use Illuminate\View\Component;

class EntityTable extends Component
{
    public $entities;
    public $entityName;
    public $tableheadings;
    public $fields;
    public $createroute;
    public $editroute;
    public $deleteroute;

    public function __construct($entities, $entityName, $tableheadings, $fields, $createroute, $editroute, $deleteroute)
    {
        $this->entities = $entities;
        $this->entityName = $entityName;
        $this->tableheadings = $tableheadings;
        $this->fields = $fields;
        $this->createroute = $createroute;
        $this->editroute = $editroute;
        $this->deleteroute = $deleteroute;
    }

    public function render()
    {
        return view('components.entity-table');
    }
}