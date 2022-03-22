<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Nota;
use Illuminate\Http\Request;
use Auth;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notas = Nota::where('users_id',Auth::id())->get();
        return Inertia::render('Notas/Index',[
            "notas"=> $notas
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     
        return Inertia::render('Notas/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
        ]);
      

         $nota = New Nota;
         $nota->titulo = $request->titulo;
         $nota->contenido = $request->contenido;
         $nota->users_id = Auth::id(); 
         $nota->save();
  
         return redirect()->route('nota.index')->with('status','La noticia se ha creado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

       return Inertia::render('Notas/Show',[
        'nota'=> Nota::where('id',$id)
        ->where('users_id',Auth::id())
        ->first()
    ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Inertia::render('Notas/Edit', [
            'nota'=> Nota::where('id',$id)
            ->where('users_id',Auth::id())
            ->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required',
            'contenido' => 'required',
          ]);
  
          $nota =  Nota::findOrFail($id)
            ->where('users_id',Auth::id())
            ->first();
          
          $nota->update($request->all());
          return redirect()->route('nota.index')->with('status','La noticia se ha actualizado');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\nota  $nota
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $nota =  Nota::findOrFail($id)
            ->where('users_id',Auth::id())
            ->first();
        $nota->delete(); 
        return redirect('nota')->with('status','La noticia se ha eliminado');
    }
}
