<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Document extends Model
{
    use HasFactory;
    protected $table = 'download_document';
    protected $fillable = ['title', 'title_hindi', 'file_path'];
}
