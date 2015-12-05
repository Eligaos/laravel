<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

 class PagesController extends Controller
{
   public function about()
   {

   	$name = "David Barbosa";
   	$people = [
   		"David", "Ruben"
   	];


   	return view('pages/about', compact('name', 'people'));
   	//return view('pages/about')->with('name', $name);
 	/*return view('pages/about')->with([

 			'name' => $name


 		]);*/

   }
}
