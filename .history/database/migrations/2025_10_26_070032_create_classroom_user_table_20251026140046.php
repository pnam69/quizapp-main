public function up(): void
{
    Schema::create('classroom_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('classroom_user');
}
