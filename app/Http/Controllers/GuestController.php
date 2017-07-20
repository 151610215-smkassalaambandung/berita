<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Berita;
use Laratrust\LaratrustFacade as Laratrust;

class GuestController extends Controller
{
    public function index(Request $request,Builder $htmlBuilder)
    {
    	if($request->ajax()) {
    		$berita=Berita::with('kategori');
    		return Datatables::of($berita);
    		->addColumn('cover', function($berita){
            return '<img src="/img/'.$berita->cover.'" height="100px" widht="100px" >'
        })->make(true);


    	}

    		        $html = $htmlBuilder
        ->addColumn(['data'=>'cover','name'=>'cover','title'=>'Gambar'])
        ->addColumn(['data'=>'judul','name'=>'judul','title'=>'Judul'])
        ->addColumn(['data'=>'isi_berita','name'=>'isi_berita','title'=>'Isi Berita'])
        ->addColumn(['data'=>'kategori.name','name'=>'kategori.name','title'=>'Kategori Berita'])
        ->addColumn(['data'=>'action','name'=>'action','title'=>'','orderable'=>false,'searchable'=>false]);
        return view('guest.index')->with(compact('html'));
    	}
    }
