<?php

namespace App\Http\Controllers;
use App\Models\Anuncio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $search = request('search');

        if($search){
            $anuncios = Anuncio::where([
                ['titulo', 'like', '%'.$search.'%']
            ])->get();
        }else{
            $anuncios = Anuncio::with('user')->get();
        }
        
        return view('home', ['anuncios' => $anuncios, 'search' => $search]);
    }

    public function storeAnuncio(Request $request)
    {
        $anuncio = new Anuncio; 
        $anuncio->titulo = $request->tituloAnuncio;
        $anuncio->descricao = $request->descricaoAnuncio;
        $anuncio->user_id = auth()->user()->id;
        $anuncio->save();

        return redirect()->route('home');
    }

    public function destroyAnuncio($id)
    {
        Anuncio::findOrFail($id)->delete();
        
        return redirect()->route('home');
    }

    public function updateAnuncio(Request $request)
    {
        $anuncio = Anuncio::findOrFail($request->id);
        $anuncio->titulo = $request->updateTitulo;
        $anuncio->descricao = $request->updateDescricao;
        
        $anuncio->save();

        return redirect()->route('home');
    }

    public function updatePerfil(Request $request)
    {
        $user = auth()->user();
        $user->name = $request->updateName;
        $user->phone = $request->updatePhone;
        if ($request->has('updatePassword')) {
            $user->password = Hash::make($request->updatePassword);
        }
        $user->save();

        return redirect()->route('home');
    }

}
