<?php

namespace App\Interfaces\Admin;


interface SalesMarketingInterfaces {
    public function add($input);
    public function edit($id);
    public function delete($id);
}