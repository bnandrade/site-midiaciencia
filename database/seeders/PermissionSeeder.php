<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'usuario-listar',
            'usuario-editar',
            'role-criar',
            'role-listar',
            'role-editar',
            'role-deletar',
            'permissao-criar',
            'permissao-listar',
            'permissao-editar',
            'permissao-deletar',
            'banner-criar',
            'banner-listar',
            'banner-deletar',
            'produto-criar',
            'produto-listar',
            'produto-editar',
            'produto-deletar',
        ];
        foreach ($permissions as $permission) {
            $p = Permission::create(['name' => $permission]);
        }
        $this->command->info('Permissões padrões adicionadas com sucesso!');
    }
}
