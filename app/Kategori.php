<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facade\Session;

class Kategori extends Model
{
	protected $fillable = ['name'];

	public function beritas()
	{
		return $this->hasMany('App\Berita');
	}    
	 public static function boot()	
    {
    	parent::boot();

    	self::deleting(function($kategori){
    		// Mengecek apakah penulis masih punya buku
    		if ($kategori->beritas->count()> 0) {
    			// menyiapkan pesan error
    			$html='penulis tidak bisa dihapus karena masih memiliki berita :';
    			$html .='<ul>';
    			foreach ($kategori ->beritas as $berita) {
    				$html.="<li>$berita->title</li>";

    			}
    			$html.='</ul>';

    			Session::flash("flash_notification",[
    				"level"=>"danger",
    				"message"=>$html
    				]);
    			return false;
    			
    		}
    	});
    
    }
}


