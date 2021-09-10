<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['CALL','CHAT','EMAIL'])->nullable();
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onCascade('delete');
            $table->bigInteger('title_id')->unsigned()->nullable();
            $table->foreign('title_id')->references('id')->on('titles')->onCascade('delete');
            $table->bigInteger('lawyer_id')->unsigned()->nullable();
            $table->foreign('lawyer_id')->references('id')->on('lawyers')->onCascade('delete');
            $table->longtext('client_message')->nullable();
            $table->longtext('lawyer_response')->nullable();
            $table->enum('status', ['PENDING','IN_PROGRESS','ANSWERED','REJECTED'])->default('PENDING');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
