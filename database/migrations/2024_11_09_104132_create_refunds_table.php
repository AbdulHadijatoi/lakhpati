<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundsTable extends Migration
{
    public function up()
    {
        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_refund_amount', 10, 2)->default(0);
            $table->unsignedInteger('total_contests')->nullable();
            $table->unsignedInteger('total_participations')->nullable();
            $table->string('refund_status')->nullable()->comment('pending, approved, rejected');
            $table->timestamp('refund_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refunds');
    }
}
