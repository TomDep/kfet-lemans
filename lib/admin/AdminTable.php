<?php

class AdminTable
{
    public array $cols;
    public array $rows;

    public string $edit_url;
    public string $delete_url;

    public string $db_table;
    private mysqli $mysqli;

    public function __construct(string $db_table, string $edit_url, string $delete_url, mysqli $mysqli)
    {
        $this->edit_url = $edit_url;
        $this->delete_url = $delete_url;
        $this->db_table = $db_table;
        $this->mysqli = $mysqli;
    }

    public function getRows() : bool {

        // Create the request
        $req = 'SELECT ';
        foreach ($this->cols as $i => $col) {
            /**
             * @var $col AdminTableColumn
             */

            if($i != 0) {
                $req .= ', ';
            }

            $req .= $col->db_name;
        }
        $req .= ' FROM ' . $this->db_table;

        // Query the database
        $result = $this->mysqli->query($req);
        if(!$result) return false;

        while ($row = $result->fetch_assoc()) {
            $this->rows[] = $row;
        }

        return true;
    }

    public function add_column(AdminTableColumn $column) {
        $this->cols[] = $column;
    }

    private function header(): string
    {
        $str = '
            <table id="table" class="table table-hover table-sm sortable-table table-striped">
                        <thead class="thead-dark">
                            <tr>';

        foreach ($this->cols as $col) {
            /**
             * @var $col AdminTableColumn
             */
            $str .= $col->head();
        }

        $str .= '
                            </tr>
                        </thead>
        ';

        return $str;
    }

    private function body()
    {
        $str = '<tbody>';

        foreach ($this->rows as $i => $row) {
            
        }

        $str .= '</tbody>';

        return $str;
    }

    public function __toString()
    {
        $str = '<table id="table" class="table table-hover table-sm sortable-table table-striped">';
        $str .= $this->header();
        $str .= $this->body();
        $str .= '</table>';

        return $str;
    }
}