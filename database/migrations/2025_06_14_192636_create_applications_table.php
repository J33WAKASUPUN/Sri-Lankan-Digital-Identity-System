// database/migrations/xxxx_create_applications_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('application_number')->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('date_of_birth');
            $table->enum('gender', ['male', 'female']);
            $table->string('nationality');
            $table->text('address');
            $table->string('phone');
            $table->string('birth_certificate_path');
            $table->string('photo_path');
            $table->enum('status', ['pending', 'gs_approved', 'ds_approved', 'rejected'])->default('pending');
            $table->text('gs_comments')->nullable();
            $table->text('ds_comments')->nullable();
            $table->foreignId('gs_verified_by')->nullable()->constrained('users');
            $table->foreignId('ds_verified_by')->nullable()->constrained('users');
            $table->timestamp('gs_verified_at')->nullable();
            $table->timestamp('ds_verified_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
};
