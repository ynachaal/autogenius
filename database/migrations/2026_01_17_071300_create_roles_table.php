<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default roles
        DB::table('roles')->insert([
            [
                'name' => 'Admin',
                'code' => '01',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User',
                'code' => '02',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

         Schema::table('users', function (Blueprint $table) {
            // Make sure the column exists before altering
            if (Schema::hasColumn('users', 'role')) {
                // Add comment (depends on DB engine support)
                $table->string('role', 10)
                    ->comment('Role code: 01=Admin, 02=User')
                    ->change();

                // Add foreign key linking to roles.code
                $table->foreign('role')
                    ->references('code')
                    ->on('roles')
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
