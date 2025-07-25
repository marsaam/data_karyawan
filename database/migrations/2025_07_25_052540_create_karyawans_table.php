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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_karyawan')->unique(); // Nomor Induk Karyawan
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['1', '2'])->comment('1 = Laki-laki, 2 = Perempuan');
            $table->string('foto')->nullable(); // path foto
            // $table->text('id_pendidikan')->nullable();
            // $table->text('id_keluarga')->nullable(); // bisa nanti pakai relasi kalau mau
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
        Schema::dropIfExists('karyawans');
    }
};
