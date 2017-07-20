<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Html\Builder;
use Yajra\Datatables\Datatables;
use App\Berita;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
class BeritasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Builder $htmlBuilder)
    {
        if ($request->ajax()){
            $beritas = Berita::with('kategori');
            return Datatables::of($beritas)
            ->addColumn('cover', function($berita){
                return '<img src="/img/'.$berita->cover.'" height="100px" widht="100px" >';
            })
            ->addColumn('action',function($berita){
                return view('datatable._action',[
                    'model'=>$berita,
                    'form_url'=>route('berita.destroy',$berita->id),
                    'edit_url'=>route('berita.edit',$berita->id),
                    'confirm_message'=>'Yakin mau menghapus'. $berita->title . '?'
                    ]);
            })->make(true);
        }
        $html = $htmlBuilder
        ->addColumn(['data'=>'cover','name'=>'cover','title'=>'Gambar'])
        ->addColumn(['data'=>'judul','name'=>'judul','title'=>'Judul'])
        ->addColumn(['data'=>'isi_berita','name'=>'isi_berita','title'=>'Isi Berita'])
        ->addColumn(['data'=>'kategori.name','name'=>'kategori.name','title'=>'Kategori Berita'])
        ->addColumn(['data'=>'action','name'=>'action','title'=>'','orderable'=>false,'searchable'=>false]);
        return view('berita.index')->with(compact('html'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('berita.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'judul'=>'required|unique:beritas,judul',
            'kategori_id'=>'required|exists:kategoris,id',
            'isi_berita'=>'required|unique:beritas,isi_berita',
            'cover'=>'image|max:2048'
            ]);

        $berita = Berita::create($request->except('cover'));
        if($request->hasFile('cover')){
            $uploaded_cover=$request->file('cover');
            $extension=$uploaded_cover->getClientOriginalExtension();
            $filename=md5(time()).'.'.$extension;
            $destinationPath=public_path().DIRECTORY_SEPARATOR.'img';
            $uploaded_cover->move($destinationPath,$filename);
            $berita->cover = $filename;
            $berita->save();
        }
        Session::flash("flash_notification",[
            "level"=>"success",
            "message"=>"Berhasil menyimpan $berita->title"
            ]);
        return redirect()->route('berita.index');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $berita = Berita::find($id);
        return view('berita.edit')->with(compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        $berita = Berita::find($id);
        $berita->update($request->all());

            if ($request->hasFile('cover')){
                $filename = null;
                $uploaded_cover=$request->file('cover');
                $extension=$uploaded_cover->getClientOriginalExtension();
                $filename=md5(time()).'.'.$extension;
                $destinationPath=public_path().DIRECTORY_SEPARATOR.'img';
                $uploaded_cover->move($destinationPath,$filename);
                if ($berita->cover) {
                    $old_cover=$berita->cover;
                    $filepath=public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$berita->cover;
                    try{
                        File::delete($filepath);
                    } catch (FileNotFoundException $e){

                    }
                }
                $berita->cover=$filename;
                $berita->save();
            }
            Session::flash("flash_notification",[
                "level"=>"success",
                "message"=>"Berhasil menyimpan $berita->title"]);
            return redirect()->route('berita.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $berita=Berita::find($id);
        if($berita->cover){
            $old_cover=$berita->cover;
            $filepath=public_path().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPARATOR.$berita->cover;
            try{
                File::delete($filepath);
            } catch (FileNotFoundException $e){

            }
        }
        $berita->delete();
        
        Session::flash("flash_notification",[
            "level"=>"success",
            "message"=>"Berita berhasil dihapus"]);
        return redirect()->route('berita.index');
    }
}
