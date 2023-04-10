<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function like($image_id)
    {
        // Recoger datos del usuario y la imagen
        $user_id = Auth::user()->id;

        // Condicion para ver si ya existe el like y no duplicarlo
        $isset_like = Like::where('image_id', $image_id)
                            ->where('user_id', $user_id)
                            ->count(); // count trae la cantidad de registros

        if($isset_like == 0){
            $like           = new Like;
            $like->user_id  = $user_id;
            $like->image_id = $image_id;

            // Guardar
            $like->save();

            // Obtener cantidad de likes
            $cantidad = Like::where('image_id', $image_id)
                            ->count();

            return response()->json([
                'like' => $like,
                'cantidad' => $cantidad,
                'message' => 'Has dado like correctamente'
            ]);
        }else{
            return response()->json([
                'message' => 'El like ya existe'
            ]);
        }
    }

    public function dislike($image_id)
    {
        // Recoger datos del usuario y la imagen
        $user_id    = Auth::user()->id;

        // Condicion para ver si ya existe el like y no duplicarlo
        $like = Like::where('image_id', $image_id)
                    ->where('user_id', $user_id)
                    ->first(); //first equivale LIMIT 1. first si no hay data no trae nada. get trae un array vacio [] aunque no tenga data.

        if($like){
            // Eliminar like
            $like->delete();

            // Obtener cantidad de likes
            $cantidad = Like::where('image_id', $image_id)
                            ->count();

            return response()->json([
                'dislike' => $like,
                'cantidad' => $cantidad,
                'message' => 'Has dado dislike correctamente'
            ]);
        }else{
            return response()->json([
                'message' => 'El like no existe'
            ]);
        }

    }
}
