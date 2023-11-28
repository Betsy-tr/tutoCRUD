<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    //
    public function index(){

        //Afficher la liste des étudiants par ordre croissant en fonction de leur nom
        $etudiants = Etudiant::orderBy("nom", "asc")->paginate(5); 
        
        return view("etudiant", compact("etudiants"));
    }

    public function create(){
        $classes = Classe::all();
        return view("createEtudiant" , compact("classes"));
    }

    public function edit(Etudiant $etudiant){
        $classes = Classe::all();
        return view("editEtudiant" , compact("etudiant" , "classes"));
    }

    // Cette fonction permet d'ajouter un étudiant
    public function store(Request $request){
        $request->validate([
            "nom"=>"required",
            "prenom"=>"required",
            "classe_id"=>"required",
        ]);

        // Etudiant::create($request->all());

        Etudiant::create([
            "nom"=>$request->nom,
            "prenom"=>$request->prenom,
            "classe_id"=>$request->classe_id,
        ]);

        return back()->with("success", "Etudiant ajouté avec succès !");
    }

    // Cette fonction permet de mettre à jour un étudiant
    public function update(Request $request , Etudiant $etudiant){
        $request->validate([
            "nom"=>"required",
            "prenom"=>"required",
            "classe_id"=>"required",
        ]);

        $etudiant->update([
            "nom"=>$request->nom,
            "prenom"=>$request->prenom,
            "classe_id"=>$request->classe_id,
        ]);

        return back()->with("success", "Etudiant mis à jour avec succès !");
    }

    // Cette fonction permet de supprimer un étudiant
    public function delete(Etudiant $etudiant){
        $nom_complet = $etudiant->nom ." ". $etudiant->prenom;
        $etudiant->delete();
        return back()->with("successDelete", "L'étudiant '$nom_complet' a été supprimé avec succès");
    }
}
