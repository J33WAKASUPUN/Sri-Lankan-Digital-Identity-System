// database/migrations/xxxx_create_digital_cards_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('digital_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->string('card_number')->unique();
            $table->json('qr_code_data');
            $table->string('qr_code_path');
            $table->date('issue_date');
            $table->date('expiry_date');
            $table->enum('status', ['active', 'expired'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('digital_cards');
    }
};
