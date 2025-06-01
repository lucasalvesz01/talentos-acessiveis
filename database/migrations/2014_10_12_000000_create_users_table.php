<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('curriculum')->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('sexo', ['masculino', 'feminino', 'outro'])->nullable();
            $table->enum('disability_type', ['visual', 'auditiva', 'fisica', 'intelectual', 'nenhuma'])->nullable();
            $table->enum('interest_area', ['Tecnologia', 'Saúde', 'Educação', 'Finanças', 'Entretenimento', 'Esportes', 'Ciência', 'Arte'])->nullable();
            $table->string('linkedin')->nullable();
            $table->enum('work_availability', ['presencial', 'remoto', 'híbrido'])->nullable();
            $table->rememberToken();
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
