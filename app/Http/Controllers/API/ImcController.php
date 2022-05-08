<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Imc;
use App\Http\Resources\ImcResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImcController extends Controller
{
    /**
     * Calculate imc.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function calculateImc(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'weight' => 'required|integer|min:10',
            'height' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'message' => 'Validation Error']);
        }

        $data['result'] = $this->getImc($data['weight'], $data['height']);

        $imc = new Imc;
        $imc->fill($data);
        return response(['data' => new ImcResource($imc), 'message' => 'Success!'], 201);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Imc  $imc
     * @return \Illuminate\Http\Response
     */
    public function show(Imc $imc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Imc  $imc
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Imc $imc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Imc  $imc
     * @return \Illuminate\Http\Response
     */
    public function destroy(Imc $imc)
    {
        //
    }

    private function getImc($weight, $height) {
        $imc = $weight / pow($height, 2);

        if ($imc < 18.5) {
            $result = 'Magreza';
            $obesityLevel = 0;
        } else if ($imc < 25) {
            $result = 'Normal';
            $obesityLevel = 0;
        } else if ($imc < 30) {
            $result = 'Sobrepeso';
            $obesityLevel = 1;
        } else if ($imc < 40) {
            $result = 'Obesidade';
            $obesityLevel = 2;
        } else {
            $result = 'Obesidade Grave';
            $obesityLevel = 3;
        }

        return [
            'imc' => $imc,
            'result' => $result,
            'obesityLeval' => $obesityLevel
        ];
    }
}