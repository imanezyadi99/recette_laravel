<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB; // Make sure to add this line

use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index(Request $request)
{
    // Récupérer l'utilisateur connecté
    $user = Auth::user();

    // Récupérer toutes les recettes associées à l'utilisateur connecté
    $recipes = Recipe::where('user_id', $user->id);

    $sort = $request->input('sort', 'name', 'ingredients', 'preparation_time');
    $order = $request->input('order', 'asc');
    $search = $request->input('search', '');

    // Appliquer la recherche si un terme de recherche est saisi
    if (!empty($search)) {
        $recipes->where('name', 'like', '%' . $search . '%')
            ->orWhere('ingredients', 'like', '%' . $search . '%')
            ->orWhere('preparation_time', 'like', '%' . $search . '%');
    }

    // Appliquer le tri
    $recipes->orderBy($sort, $order);

    // Utiliser la méthode paginate pour obtenir une instance de LengthAwarePaginator
    $recipes = $recipes->paginate();

    // Utiliser la méthode compact pour transmettre les variables à la vue
    return view('index', compact('recipes', 'sort', 'order', 'search'));
}


    public function search(Request $request)

      {

       $search = $request->input('search', '');

        $recipes = Recipe::where('name', 'like', '%' . $search . '%')
                           ->orWhere('ingredients', 'like', '%' . $search . '%')
                           ->orWhere('preparation_time', 'like', '%' . $search . '%')
                           ->paginate();

        return view('index', compact('recipes', 'search'));
    
      
        }
   
      

    public function update(Request $request, Recipe $recipe)
    {
        // Valider les données du formulaire
        $request->validate([
            'name' => 'required',
            'ingredients' => 'required',
            'preparation_time' => 'required',
        ]);

        // Mettez à jour les attributs du modèle Recipe avec les données du formulaire
        $recipe->update([
            'name' => $request->input('name'),
            'ingredients' => $request->input('ingredients'),
            'preparation_time' => $request->input('preparation_time'),
            // Ajoutez d'autres champs ici pour les autres attributs du modèle
        ]);

        // Rediriger vers la page d'index ou une autre page appropriée
        return redirect()->route('index')->with('success', 'Recette mise à jour avec succès');
    }

   

    public function store(Request $request)
{
    $recipe = new Recipe();
    $recipe->name = $request->input('name');
    $recipe->ingredients = $request->input('ingredients');
    $recipe->preparation_time = $request->input('preparation_time');
    $recipe->instructions = $request->input('instructions');
    $recipe->photo = $request->input('photo');
    $recipe->user_id = auth()->id();


    $photo_name=time().'.'.$request->photo->extension();
    $request->photo->move(public_path('photos'),$photo_name);
    $recipe->photo = $photo_name;

    $recipe->save();

    session()->flash('message', 'New recipe has been added successfully');


    return redirect()->route('index');
}


    public function destroy(Recipe $recipe)
    {
        // Assurez-vous que l'utilisateur peut uniquement supprimer ses propres recettes
        if ($recipe->user_id !== Auth::id()) {
            abort(403, 'Non autorisé');
        }

        $recipe->delete();

        return redirect()->route('index')
            ->with('success', 'Recette supprimée avec succès');
    }
}
