<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            // Identifiant unique
            $table->id();
            
            // Clé étrangère vers la table users avec suppression en cascade
            $table->foreignId('user_id')
                  ->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            
            // Informations de base
            $table->string('name', 255)->comment('Nom affiché du document');
            $table->enum('type', ['cv', 'letter', 'certificate', 'diploma', 'other'])
                  ->default('other')
                  ->comment('Type de document');
            
            // Gestion des fichiers
            $table->string('filename', 255)->comment('Nom original du fichier');
            $table->string('path', 1024)->comment('Chemin de stockage relatif');
            $table->string('disk')->default('local')->comment('Disque de stockage');
            $table->unsignedBigInteger('size')->comment('Taille en octets');
            $table->string('mime_type', 100)->comment('Type MIME du fichier');
            $table->string('extension', 10)->comment('Extension du fichier');
            
            // Statut et workflow
            $table->enum('status', [
                'uploaded',    // Document téléchargé
                'processing',  // En cours de traitement (ex: conversion)
                'analyzing',   // Analyse automatique en cours
                'completed',   // Traitement terminé
                'failed'       // Échec du traitement
            ])->default('uploaded');
            
            // Métadonnées structurées
            $table->json('metadata')->nullable()->comment('Données supplémentaires structurées');
            
            // Gestion des versions
            $table->unsignedInteger('version')->default(1);
            $table->foreignId('parent_id')
                  ->nullable()
                  ->constrained('documents')
                  ->comment('Document parent pour le versioning');
            
            // Timestamps standards
            $table->timestamps();
            
            // Soft delete
            $table->softDeletes();
            
            // Index pour les performances
            $table->index(['user_id', 'type', 'status']);
            $table->index(['type', 'status']);
            $table->index(['created_at']);
            
            // Index fulltext pour la recherche
            $table->fullText(['name', 'filename']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}