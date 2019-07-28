<?php

use think\migration\Migrator;
use think\migration\db\Column;

class AuthGroupAccess extends Migrator
{
    public function change()
    {
        $table = $this->table('auth_group_access');
        $table->addColumn('uid', 'integer', ['default'=>0]);
        $table->addColumn('group_id', 'integer', ['default'=>0]);
        $table->addIndex(['uid'], ['type'=>'index', 'name'=>'idx_uid']);
        $table->addIndex(['group_id'], ['type'=>'index', 'name'=>'idx_groupid']);
        $table->insert([
            'uid'=>1,
            'group_id'=>1
        ]);
        $table->save();
    }
}
