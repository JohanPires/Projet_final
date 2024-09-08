<?php

namespace App\Http\Controllers;

use App\Models\Exercice;
use App\Models\Training;
use Illuminate\Http\Request;

class ExercicesController extends Controller
{
      public function index()
      {
          return Exercice::all();
      }

      public function show($id)
      {
          $exercice = Exercice::find($id);
          if ($exercice) {
              return response()->json($exercice);
          } else {
              return response()->json(['message' => 'Exercice non trouvé'], 404);
          }
      }

      public function store(Request $request)
      {
          $validated = $request->validate([
              'name' => 'required|string|max:255',
              'advice' => 'nullable|string',
          ]);
          $training = Training::find($request->id_training);

          $exercice = new Exercice;
          $exercice->name = $request->name;
          $exercice->advice = $request->advice;
          $exercice->save();

          if (!$training) {
              return response()->json(['message' => 'Séance non trouvée'], 404);
          }

          // $validated = $request->validate([
          //     'exercice_id' => 'required|exists:exercices,id',
          //     'series' => 'required|integer',
          //     'repetitions' => 'required|integer',
          // ]);

          $training->exercices()->attach($exercice->id, [
              'series' => $request->series,
              'repetitions' =>  $request->repetitions,
          ]);

          return response()->json($exercice, 201);
      }

      public function update(Request $request, $id)
      {
          $exercice = Exercice::find($id);
          if (!$exercice) {
              return response()->json(['message' => 'Exercice non trouvé'], 404);
          }

          $validated = $request->validate([
              'name' => 'required|string|max:255',
              'advice' => 'nullable|string',
          ]);

          $exercice->name = $request->name;
          $exercice->advice = $request->advice;
          $exercice->save();

          return response()->json($exercice);
      }

      public function destroy($id)
      {
          $exercice = Exercice::find($id);
          if ($exercice) {
              $exercice->delete();
              return response()->json(['message' => 'Exercice supprimé avec succès']);
          } else {
              return response()->json(['message' => 'Exercice non trouvé'], 404);
          }
      }
}
