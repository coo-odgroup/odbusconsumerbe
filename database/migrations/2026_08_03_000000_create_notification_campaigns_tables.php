<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notification_campaigns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('campaign_name', 150);
            $table->string('title', 255);
            $table->text('message');
            $table->string('image', 500)->nullable();
            $table->enum('type', ['PROMOTIONAL', 'TRANSACTIONAL', 'REMINDER', 'CUSTOM'])->default('PROMOTIONAL');
            $table->tinyInteger('active_status')->default(1)->comment('1=Active,0=Inactive');
            $table->unsignedInteger('total_users')->default(0);
            $table->unsignedInteger('processed_users')->default(0);
            $table->unsignedInteger('success_users')->default(0);
            $table->unsignedInteger('failed_users')->default(0);
            $table->enum('target_type', ['ALL', 'ACTIVE', 'INACTIVE', 'VERIFIED', 'CUSTOM'])->nullable();
            $table->enum('schedule_type', ['IMMEDIATE', 'SCHEDULED', 'BEFORE_EVENT', 'AFTER_EVENT'])->nullable();
            $table->integer('schedule_minutes')->default(0);
            $table->dateTime('schedule_at')->nullable();
            $table->tinyInteger('is_completed')->default(0);
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('notification_campaign_queue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('campaign_id');
            $table->unsignedBigInteger('user_id');
            $table->string('email', 150)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->text('fcm_token')->nullable();
            $table->enum('status', ['PENDING', 'PROCESSING', 'SUCCESS', 'FAILED', 'INVALID_TOKEN'])->default('PENDING');
            $table->unsignedTinyInteger('retry_count')->default(0);
            $table->dateTime('scheduled_time');
            $table->dateTime('processed_at')->nullable();
            $table->string('error_code', 100)->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('created_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();

            $table->foreign('campaign_id')->references('id')->on('notification_campaigns')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notification_campaign_queue');
        Schema::dropIfExists('notification_campaigns');
    }
};
