<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
       public function index()
       {
           return Training::with('exercices')->get();
       }

       public function show($id)
       {
           $seance = Training::with('exercices')->find($id);

           if ($seance) {
               return response()->json($seance);
           } else {
               return response()->json(['message' => 'Séance non trouvée'], 404);
           }
       }

       public function store(Request $request)
       {
           $validated = $request->validate([
               'name' => 'nullable|string|max:255',
           ]);

           $training = new Training;
           $training->name = $request->name;
           $training->save();
           return response()->json($training, 201);
       }

       public function update(Request $request, $id)
       {
           $training = Training::find($id);
           if (!$training) {
               return response()->json(['message' => 'Séance non trouvée'], 404);
           }

           $validated = $request->validate([
               'name' => 'nullable|string|max:255',
           ]);

           $training->name = $request->name;
           $training->save();

           return response()->json($training);
       }

       public function destroy($id)
       {
           $training = Training::find($id);
           if ($training) {
               $training->exercices()->detach();
               $training->delete();
               return response()->json(['message' => 'Séance supprimée avec succès']);
           } else {
               return response()->json(['message' => 'Séance non trouvée'], 404);
           }
       }

       public function attachExercice(Request $request, $id)
{
    $training = Training::find($id);

    if (!$training) {
        return response()->json(['message' => 'Séance non trouvée'], 404);
    }

    // $validated = $request->validate([
    //     'exercice_id' => 'required|exists:exercices,id',
    //     'series' => 'required|integer',
    //     'repetitions' => 'required|integer',
    // ]);

    $training->exercices()->attach($request->exercice_id, [
        'series' => $request->series,
        'repetitions' =>  $request->repetitions,
    ]);

    return response()->json(['message' => 'Exercice ajouté à la séance avec succès']);
}
}
