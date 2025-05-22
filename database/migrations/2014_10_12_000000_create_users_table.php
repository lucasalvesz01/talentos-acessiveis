<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->string('password');
            $table->string('curriculum')->nullable();
            $table->date('data_nascimento');
            $table->enum('sexo', ['masculino', 'feminino', 'outros'])->default('outros');
            $table->enum('disability_type', ['visual', 'auditiva', 'motora', 'outra'])->nullable()->default('outra');
            $table->enum('interest_area', ['Tecnologia',
                'Saúde',
                'Educação',
                'Finanças',
                'Entretenimento',
                'Esportes',
                'Ciência',
                'Arte'])->nullable();
            $table->string('linkedin')->nullable();
            $table->enum('work_availability', ['presencial', 'remoto', 'híbrido'])->nullable()->default('remoto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
