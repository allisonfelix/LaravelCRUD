<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('albuns', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Remove a chave estrangeira antiga
            $table->dropColumn('user_id');    // Remove a coluna antiga
        });

        Schema::table('albuns', function (Blueprint $table) {
            $table->string('user_id')->index(); // Cria a nova coluna como string
        });
    }

    public function down(): void
    {
        Schema::table('albuns', function (Blueprint $table) {
            $table->dropColumn('user_id'); // Remove a nova coluna

            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Restaura como inteiro e chave estrangeira
        });
    }
};
