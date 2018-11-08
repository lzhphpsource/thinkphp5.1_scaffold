<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AdminRule extends Migrator
{
    public function change()
    {
        $table = $this->fetchAll('SELECT * FROM `hd_auth_rule`');
        foreach ($table as $rs) {
            $id = $rs['id'];
            $exp = explode('/', $rs['name']);
            $end = array_pop($exp);
            $str = strtolower(implode('/', $exp));
            $this->execute('UPDATE `hd_auth_rule` SET `name`=\'' . $str . '/' . $end . '\' WHERE `id`=' . $id);
        }

    }
}
