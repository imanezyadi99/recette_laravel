@extends('layouts.app')

@section('content')
<div>
    <div class="container mt-5">
        <div class="row mb-5">
            <div class="col-md-12 text-center">
                <h2><strong> Recette</strong></h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 style="float: center;"><strong>Liste des Recettes</strong></h5>
                      
                        <form action="{{ route('index') }}" method="GET">

                            <input type="search" name="search" id="" class="form-control" placeholder="Recherche" value="{{ $search }}" style="width: 230px" /><br/>
                            <button type="submit"style="float:left;" class="btn btn-primary">Search</button>
                        </form>
                        <button class="btn btn-sm btn-primary" style="float: right;" data-toggle="modal" data-target="#addStudentModal"><i class="fas fa-plus"></i>Ajouter</button>
                    </div>
                    <div class="card-body">
                        @if(count($recipes) > 0)
                        <table  id="datatable" class="table align-middle mb-0 bg-white">
                            <thead class="bg-light">
                                <tr>
                                    <th><a href="{{ route('index', ['sort' => 'name', 'order' => $sort === 'name' && $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">Nom du recette</a></th>
                                    <th><a href="{{ route('index', ['sort' => 'ingredients', 'order' => $sort === 'ingredients' && $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">Ingredients</a></th>
                                    <th><a href="{{ route('index', ['sort' => 'preparation_time', 'order' => $sort === 'preparation_time' && $order === 'asc' ? 'desc' : 'asc', 'search' => $search]) }}">Duree prparation</a></th>
                                    <th>Photo</th>


                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($recipes as $recipe)
                                        <tr>
                                            <td> 
                                                <p class="fw-normal mb-1">{{$recipe->name}}</p>
                       
                                            
                                            </td>

                                           <td> <p class="fw-normal mb-1">{{$recipe->ingredients}}</p></td>

                                           <td>
                                            <p class="fw-normal mb-1">{{$recipe->preparation_time}}</p>
                                           </td>
                                           <td>
                                            @if ($recipe->photo)
                                            <img src="{{ asset('photos/' . $recipe->photo) }}" alt="Recipe Image" style="max-width: 100px; max-height: 100px;">
                                        @endif
                                           </td>
                                         
                                    

                                            <td style="text-align: center;">
                                                <button class="btn btn-link" data-toggle="modal" data-target="#viewModal{{$recipe->id}}" wire:click="viewStudentDetails({{ $recipe->id }})"><i class='far fa-eye'></i></button>


                                                <button class="btn btn-link"  data-toggle="modal" data-target="#editModal{{$recipe->id}}" wire:click="$edit('show-edit-modal', {{ $recipe->id }})"><i class='far fa-edit'></i></button>

                                                <button class="btn btn-link "  data-toggle="modal" data-target="#deleteStudentModal{{$recipe->id}}" wire:click="deleteConfirmation({{ $recipe->id }})"><i class='far fa-trash-alt'></i></button>
                                            </td>
                                        </tr>
                                        <form action="{{ route('recipes.destroy', $recipe->id) }}" method="POST" enctype="multipart/form-data">
                                            {{ method_field('delete') }}
                                            {{ csrf_field() }}
                                    
                                            <div class="modal fade" id="deleteStudentModal{{$recipe->id}}" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">  <i class="fas fa-exclamation-triangle"></i>Supprimer la recette</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body pt-4 pb-4">
                                                            <h6>Etes-vous sur de vouloir supprimer cette recette <b>{{$recipe->name}}</b>? <br>
                                                            Cette opération est irreversible</h6>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-sm btn-primary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>
                                                            <button class="btn btn-sm btn-danger" wire:click="deleteStudentData()">Confirmer</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <form action="{{ route('recipes.update', $recipe->id) }}" method="POST"  enctype="multipart/form-data">
                                            @method('PATCH')
                                            @csrf
                                            <div class="modal fade " id="editModal{{ $recipe->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Modifier cette recette </h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nom" class="form-label">Nom</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $recipe->name }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="prenom" class="form-label">Ingredients</label>
                                                                <input type="text" name="ingredients" class="form-control" value="{{ $recipe->ingredients }}">
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="entreprise" class="form-label">duree preparation</label>
                                                                <input type="text" name="preparation_time" class="form-control" value="{{ $recipe->preparation_time }}">
                                                            </div>
                                                      
                                                            
                                                            <!-- Ajoutez d'autres champs ici pour les autres attributs du contact -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Modifier</button>
                                                            <button type="button" class="btn btn-danger" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <form action="{{ route('index', $recipe->id) }}" method="POST"  enctype="multipart/form-data">
                                            @method('GET')
                                            @csrf
                                            <div class="modal fade " id="viewModal{{ $recipe->id }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="myModalLabel">Voir la recette</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <p><strong>Nom:</strong> {{ $recipe->name}}</p>
                                                        <p><strong>Ingredients:</strong> {{ $recipe->ingredients }}</p>
                                                        <p><strong>Duree:</strong> {{ $recipe->preparation_time }}</p>
                                                        <p><strong>Photo:</strong> {{ $recipe->photo }}</p>

                                                  
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
    
     
                            @endforeach

                                                             
  

                            </tbody>
                          
                          
                        </table>
                        {{$recipes->links()}}
                        @else
                            <!-- Aucune recette -->
                            <p>Aucune recette disponible pour cet utilisateur.</p>
                        @endif
                    </div>
                   
                </div>
              
            </div>
       
        </div>
    </div>


     

    <!-- Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true"  wire:submit.prevent="store">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h5 class="modal-title" id="myModalLabel"> Détail du recette</h5>


                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{ route('recipes.store')}}" method="POST" enctype="multipart/form-data">
                      
        
                        @csrf

                        <div class="form-group row">
                            <label for="nom" class="col-3">Nom</label>
                            <div class="col-9">
                                <input type="text" name="name" class="form-control" wire:model="name">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="prenom" class="col-3">Ingredients</label>
                            <div class="col-9">
                                <input type="text" name="ingredients" class="form-control" wire:model="ingredients">
                                @error('ingredients')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="prenom" class="col-3">Instructions</label>
                            <div class="col-9">
                                <input type="text" name="instructions" class="form-control" wire:model="instructions">
                                @error('instructions')
                                    <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- ... (autres champs) ... -->
                            <div class="form-group row">
                                <label for="email" class="col-3">Durée préparation</label>
                                <div class="col-9">
                                    <input type="text" name="preparation_time" class="form-control" wire:model="preparation_time">
                                    @error('preparation_time')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <!-- ... (autres champs) ... -->
                            <div class="form-group row">
                                <label for="email" class="col-3">Photo</label>
                                <div class="col-9">
                                    <input type="file" name="photo" class="form-control" wire:model="photo">
                                    @error('photo')
                                        <span class="text-danger" style="font-size: 11.5px;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                       
                        
                            <!-- Fermer le formulaire ici -->
                            <div class="form-group row">
                                <label for="" class="col-3"></label>
                                <div class="col-9">
                                    <button type="submit" class="btn btn-sm btn-primary" >Valider</button>
                                    <button class="btn btn-sm btn-primary" wire:click="cancel()" data-dismiss="modal" aria-label="Close">Annuler</button>
                                </div>
                            </div>
                        </form> 
                </div>
            </div>
        </div>
    </div>

   
   


    @push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>


    <script>
    
        window.addEventListener('close-modal', () => {
            // Masquer tous les modals
            $('#addStudentModal').modal('hide');
            $('.editModal').modal('hide');
            $('#deleteStudentModal').modal('hide');

        });
    
        window.addEventListener('show-edit-modal', (recipeId) => {
            // Afficher le modal d'édition spécifique en utilisant l'ID du contact
            $('#editModal-' + recipeId).modal('show');
        });
    
        window.addEventListener('show-delete-modal', (recipeId) => {
            // Afficher le modal de suppression spécifique en utilisant l'ID du contact
            $('#deleteStudentModal-' + recipeId).modal('show');
        });
    
        window.addEventListener('show-view-student-modal', () => {
            $('#viewStudentModal').modal('show');
        });
    </script>


    @endpush

    @endsection