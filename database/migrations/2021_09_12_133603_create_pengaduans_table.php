        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class CreatePengaduansTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
            Schema::create('pengaduan', function (Blueprint $table) {
            $table->id('id_pengaduan');
            $table->string('nik'); // relasi ke masyarakat
            $table->string('nama_pelapor');
            $table->string('nama_pelanggar');
            $table->enum('kategori_pelanggar', ['Dosen', 'Tendik']);
            $table->text('isi_laporan');
            $table->date('tgl_kejadian');
            $table->string('lokasi_kejadian');
            $table->string('foto')->nullable();
            $table->enum('status', ['menunggu_verifikasi', 'proses', 'selesai']);
            $table->timestamps();

            $table->foreign('nik')
                ->references('nik')
                ->on('masyarakat')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });

            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('pengaduan');
            }
        }
