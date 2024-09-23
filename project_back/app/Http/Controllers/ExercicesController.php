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
              'series' => 'required|integer',
              'repetitions' => 'required|integer',
          ]);

          $trainingId = $request->id_training;

          $maxRetries = 10;
          $retryInterval = 500000;
          $retries = 0;
          $training = null;
          while ($retries < $maxRetries) {
            $training = Training::find($trainingId);

            if ($training) {
                break;
            }

            usleep($retryInterval);
            $retries++;
        }

          $exercice = new Exercice;
          $exercice->name = $request->name;
          $exercice->training_id = $request->id_training;
          $exercice->advice = $request->advice;
          $exercice->series = $request->series;
          $exercice->repetitions = $request->repetitions;
          $exercice->save();

          if (!$training) {
              return response()->json(['message' => 'Séance non trouvée'], 404);
          }

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
