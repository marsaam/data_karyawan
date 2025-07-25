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
    public function up()
    {
        Schema::create('keluargas', function (Blueprint $table) {
            $table->id();
             $table->foreignId('karyawan_id')->constrained('karyawans')->onDelete('cascade');
            $table->string('nama_keluarga');
            $table->enum('hubungan', ['1', '2', '3', '4', '5', '6', '7'])->comment('1 = Ayah, 2 = Ibu, 3 = Suami, 4 = Istri, 5 = Anak', '6 = Saudara, 7 = Lainnya');
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
        Schema::dropIfExists('keluargas');
    }
};
