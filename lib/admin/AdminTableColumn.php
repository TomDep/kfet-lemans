<?php

class AdminTableColumn
{
    public string $db_name;
    public string $display_name;
    public bool $sortable;

    public function __construct(string $db_name, string $display_name, bool $sortable)
    {
        $this->db_name = $db_name;
        $this->display_name = $display_name;
        $this->sortable = $sortable;
    }

    public function head(): string
    {
        if ($this->sortable) {
            return '<th scope="col" class="sortable">' . $this->display_name . '</th>';
        } else {
            return '<th scope="col">' . $this->display_name . '</th>';
        }
    }
}