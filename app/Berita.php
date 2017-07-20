<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $fillable = ['judul','kategori_id','isi_berita'];

    public function kategori()
    {
    	return $this->belongsTo('App\Kategori');
    }
}
