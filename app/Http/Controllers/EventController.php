<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Account;
Use App\Http\Controllers\DB;

class EventController extends Controller
{
    
    public function store(Request $request) {

        if($request->input('tipo') === 'deposito'){
            // Llamada del metodo deposito
            return $this->deposito($request->input('cuenta'),$request->input('monto'));
            
        } elseif ($request->input('tipo') === 'retiro') {
            return $this->retiro($request->input('origen'),$request->input('monto'));

        } elseif ($request->input('tipo') === 'transferencia') {
            return $this->transferencia($request->input('origen'),$request->input('monto'), $request->input('destino') );
        }


    }

    public function deposito($cuenta_destino, $monto){
        
        // Busco objeto a depositar en BD
        $account = Account::firstOrCreate([ // FirstOrCreate recibe dos arreglos: 1.- las condiciones de busqueda 2.- valores iniciales del posible registro nuevo
            'id' => $cuenta_destino
        ]); // solo usare el primer arreglo ya que tengo defaul en balane en accoun_create_account
    
        $account->balance += $monto;
        $account->save();

        return response()->json([
            'destinatario' => [
                'id' => $account->id,
                'balance' => $account->balance
                ]
         ], 201);
    }

    public function retiro($cuenta_origen, $monto){
        
        // Busco objeto a retirar en BD
        $account = Account::findOrFail($cuenta_origen); // solo usare el primer arreglo ya que tengo defaul en balane en accoun_create_account
          
        $account->balance -= $monto;
        $account->save();

        return response()->json([
            'cuenta origen' => [
                'id' => $account->id,
                'balance' => $account->balance
                ]
         ], 201);
    }

    public function transferencia($cuenta_origen, $monto, $cuenta_destino){
        
        $account_orig = Account::findOrFail($cuenta_origen);
        $account_dest = Account::firstOrCreate([
            'id'=> $cuenta_destino
        ]); // Si cuenta destino no existe, se crea

        // DB::transaction (function() use ($account_orig, $monto, $account_dest) {
                      
            $account_dest->balance += $monto;
            $account_orig->balance -= $monto;
    
            $account_dest->save();
            $account_orig->save();
        // });


        return response()->json([
            'cuenta origen' => [
                'id' => $account_orig->id,
                'balance' => $account_orig->balance
            ],
            'cuenta destino' => [
                'id' => $account_dest->id,
                'balance' => $account_dest->balance
            ],
         ], 201);
    }
}
