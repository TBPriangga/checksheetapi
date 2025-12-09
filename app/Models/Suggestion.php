<?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Factories\HasFactory;
   use Illuminate\Database\Eloquent\Model;

   class Suggestion extends Model
   {
       use HasFactory;

       protected $fillable = [
           'nama',
           'npk',
           'departemen',
           'section',
           'kategori_ide',
           'cost_currency',
           'cost_amount',
           'judul_ide',
           'before',
           'after',
           'before_image',
           'after_image',
           'user_id',
       ];
   }